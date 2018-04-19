<?php
/**
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\library\booking;
use Yii;
use api\library\Help;
use common\models\Promotion;
use lulutrip\modules\rentcar\library\booking\ShoppingData;

class UsePromotions
{

    /**
     * @var Promotion
     */
    public $promotion;

    /**
     * @var ShoppingData
     */
    public $shoppingData;

    /**
     * UsePromotion constructor.
     * @param $promotion
     * @param $shoppingData
     */
    public function __construct($promotion, $shoppingData)
    {
        $this->promotion = $promotion;
        $this->shoppingData = $shoppingData;
    }

    /**
     * 检查优惠券
     * @author Justin Jia<justin.jia@lulutrip.com>
     * @copyright 2017-09-08
     * @return bool
     * @throws \Exception
     */
    public function check() {
        if ($this->promotion) {

            // 检查使用平台
            if (!in_array($this->promotion['promo_useplatform'], [0, 1])) {
                return false;
            }

            // 优惠码不能为空
            if (empty($this->promotion['promocode'])) {
                return false;
            }

            // 检查优惠活动类型(目前仅支持满减类型)
            if (!in_array($this->promotion['type'], [1, 7])) {
                return false;
            }

            // 检查优惠券数量
            if (!($this->promotion['countdown'] > 0 || $this->promotion['countdown'] == -1)) {
                return false;
            }

            // 检查优惠范围
            if (!$this->_checkDiscountProduct(unserialize($this->promotion['discount_info']), $this->shoppingData->carid)) {
                return false;
            }
            // 检查最小使用金额
            if ($this->promotion['min_price'] > 0) {
                $this->_checkMinPrice($this->promotion['min_price'], $this->shoppingData->totalAmount);
            }

            // 检查最大使用金额
            if ($this->promotion['max_price'] > 0) {
                $this->_checkMaxPrice($this->promotion['max_price'], $this->shoppingData->totalAmount);
            }

            // 检查有效日期范围
            if ($this->promotion['valid_sdate'] > date('Y-m-d H:i:s')) {
                return false;
            }

            // 检查有效日期范围
            if ($this->promotion['valid_edate'] < date('Y-m-d H:i:s')) {
                return false;
            }

            // 检查限定使用会员
            if (!$this->_checkUserLevel()) {
                return false;
            }

            // 检查限定域名后缀
            if (!$this->_checkDomainSuffix()) {
                return false;
            }

            return true;
        } else {
            throw New \Exception('请输入正确的优惠码');
        }
    }

    /**
     * 检查优惠范围
     * @author Justin Jia<justin.jia@lulutrip.com>
     * @copyright 2017-09-08
     * @param $discountInfo
     * @param $productCode
     * @return bool
     */
    private function _checkDiscountProduct($discountInfo, $productCode) {
        // 默认结果为false
        $defaultCheckStatus = false;

        foreach ($discountInfo as $discount) {
            //每个订单
            if ($discount['discount_type'] == 0) {
                return true;
            }

            //指定产品参与活动
            if ($discount['discount_type'] == 1) {
                if ($discount['discount_product'] == 5 && in_array($productCode, explode(',', $discount['discount_product_ids']))) {
                    return true;
                }
            }

            //指定产品不参与活动
            if ($discount['discount_type'] == 2) {
                $defaultCheckStatus = true;

                if ($discount['discount_product'] == 5 && in_array($productCode, explode(',', $discount['discount_product_ids']))) {
                    return false;
                }
            }
        }

        return $defaultCheckStatus;
    }

    /**
     * 检查最小使用金额
     * @author Justin Jia<justin.jia@lulutrip.com>
     * @copyright 2017-09-08
     * @param $minPrice
     * @param $totalAmount
     * @throws \Exception
     */
    private function _checkMinPrice($minPrice, $totalAmount) {
        if ($totalAmount < $minPrice) {
            throw New \Exception('无法使用该优惠券');
        }
    }

    /**
     * 检查最大使用金额
     * @author Justin Jia<justin.jia@lulutrip.com>
     * @copyright 2017-09-08
     * @param $maxPrice
     * @param $totalAmount
     * @throws \Exception
     */
    private function _checkMaxPrice($maxPrice, $totalAmount) {
        if ($totalAmount > $maxPrice) {
            throw New \Exception('无法使用该优惠券');
        }
    }


    /**
     * 检查限定使用会员
     * @author Justin Jia<justin.jia@lulutrip.com>
     * @copyright 2017-09-08
     * @return bool
     */
    private function _checkUserLevel() {
        $limitUserLevels = array_filter(explode(',', $this->promotion['userclass']));

        if (in_array(4, $limitUserLevels)) {
            return true;
        }

        if (in_array(Yii::$app->user->current_user['LuluUserClass']['class'], $limitUserLevels)) {
            return true;
        }

        return false;
    }

    /**
     * 校验优惠券域名后缀
     * @author Justin Jia<justin.jia@lulutrip.com>
     * @copyright 2017-09-08
     * @return bool
     */
    private function _checkDomainSuffix()
    {
        $domainSuffix = array_filter(explode(',', $this->promotion['domain_suffix']));
        if(count($domainSuffix) > 0) {
            if($email = Yii::$app->user->current_user['email']) {
                foreach ($domainSuffix as $suffix) {
                    if (substr(strtolower($email), 0 - strlen($suffix)) == strtolower($suffix)) {
                        return true;
                    }
                }
            }
            return false;
        } else {
            return true;
        }
    }

    /**
     * 使用优惠券
     * @author Justin Jia<justin.jia@lulutrip.com>
     * @copyright 2017-09-08
     * @return integer
     */
    public function apply() {
        $currency = $this->shoppingData->currency;
        $totalAmount = $this->shoppingData->totalAmount;
        $discountPrice = $this->_discountPrice($currency, $totalAmount);

        $this->shoppingData->usePromotion = new \lulutrip\modules\rentcar\library\booking\shoppingData\UsePromotions([
            'promotionId' => $this->promotion['promoid'],
            'promotionCode' => $this->promotion['promocode'],
            'discountPrice' => $discountPrice
        ]);
        $this->shoppingData->save();

        return $discountPrice;
    }

    /**
     * 取消使用优惠券
     * @author Justin Jia<justin.jia@lulutrip.com>
     * @copyright 2017-09-08
     * @param ShoppingData $shoppingData
     */
    public static function cancel(ShoppingData $shoppingData) {
        $shoppingData->usePromotion = new \lulutrip\modules\rentcar\library\booking\shoppingData\UsePromotions([
            'promotionCode' => null,
            'discountPrice' => 0
        ]);
        $shoppingData->save();
    }

    /**
     * 计算折后价
     * @author Justin Jia<justin.jia@lulutrip.com>
     * @copyright 2017-09-08
     * @param $currency string
     * @param $totalAmount integer
     * @return integer
     */
    private function _discountPrice($currency, $totalAmount) {
        $discountPrice = 0;

        $couponType = $this->promotion['coupon_type'];
        $couponPrice = $this->promotion['coupon_price'];
        $couponCurrency = $this->promotion['currency'];

        if ($couponType == 'P') {
            $discountPrice = floor($totalAmount * $couponPrice / 100);
        } elseif ($couponType == 'R') {
            $discountPrice = Help::exchangeCurrency($couponPrice, $couponCurrency, $currency, 'floor2');
        }

        return $discountPrice;
    }

    /**
     * 返回数据
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-09-08
     * @param ShoppingData $shoppingData
     * @param $discountPrice
     * @return array
     */
    public function _returnData(ShoppingData $shoppingData, $discountPrice)  {
        return [
            'currency' => Yii::$app->params['curCurrencies'],
            'discountPrice' => $discountPrice,
            'totalAmount' => $this->_getTotalAmount($shoppingData),
            'totalAmounts' => $this->_getTotalAmounts($shoppingData)
        ];
    }

    /**
     * 计算总价
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-09-08
     * @param ShoppingData $shoppingData
     * @return float|int
     */
    private function _getTotalAmount(ShoppingData $shoppingData) {
        $shoppingData->totalAmount = $shoppingData->totalAmount - $shoppingData->usePromotion->discountPrice;
        return $shoppingData->totalAmount;
    }

    /**
     * 计算各个币种总价
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-09-08
     * @param ShoppingData $shoppingData
     * @return TotalAmount[]
     */
    private function _getTotalAmounts(ShoppingData $shoppingData) {
        foreach ($shoppingData->totalAmounts as $totalAmounts) {
            $totalAmounts->amount = Help::exchangeCurrency($shoppingData->totalAmount, $shoppingData->currency, $totalAmounts->currency, 'ceil2');
            $totalAmounts->currency = Yii::$app->params['currencies'][$totalAmounts->currency];
        }
        return $shoppingData->totalAmounts;
    }
}