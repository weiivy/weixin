<?php

namespace lulutrip\modules\tour\library\booking;

use api\library\Help;
use common\models\Promotion;
use lulutrip\modules\tour\library\booking\ShoppingData;
use Yii;

/**
 * Class UsePromotion
 * @package lulutrip\library
 */
class UsePromotion {

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
     * @author Victor Tang<victortang@lulutrip.com>
     * @copyright 2017-8-21
     * @return bool
     * @throws \Exception
     */
    public function check() {
        if ($this->promotion) {

            // 检查使用平台
            if (!in_array($this->promotion['promo_useplatform'], [0, 1])) {
                Yii::info('平台错误' . $this->promotion['promo_useplatform'], __METHOD__);
                return false;
            }

            // 优惠码不能为空
            if (empty($this->promotion['promocode'])) {
                Yii::info('优惠码不能为空', __METHOD__);
                return false;
            }

            // 检查优惠活动类型(目前仅支持满减类型)
            if ($this->promotion['type'] != 1) {
                Yii::info('检查优惠活动类型(目前仅支持满减类型)', __METHOD__);
                return false;
            }

            // 检查优惠券数量
            if (!($this->promotion['countdown'] > 0 || $this->promotion['countdown'] == -1)) {
                Yii::info('检查优惠券数量', __METHOD__);
                return false;
            }

            // 检查优惠范围
            if (!$this->_checkDiscountProduct(unserialize($this->promotion['discount_info']), $this->shoppingData->pcode, $this->shoppingData->productAreaCodes)) {
                Yii::info('检查优惠范围', __METHOD__);
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
                Yii::info('检查有效日期范围', __METHOD__);
                return false;
            }

            // 检查有效日期范围
            if ($this->promotion['valid_edate'] < date('Y-m-d H:i:s')) {
                Yii::info('检查有效日期范围', __METHOD__);
                return false;
            }

            // 检查出发日期
            if (!$this->_checkDepartureDate($this->shoppingData->sdate)) {
                Yii::info('检查出发日期', __METHOD__);
                return false;
            }

            // 检查限定使用会员
            if (!$this->_checkUserLevel()) {
                Yii::info('检查限定使用会员', __METHOD__);
                return false;
            }

            // 检查限定域名后缀
            if (!$this->_checkDomainSuffix()) {
                Yii::info('检查限定域名后缀', __METHOD__);
                return false;
            }

            return true;
        } else {
            throw New \Exception('请输入正确的优惠码');
        }
    }

    /**
     * 检查优惠范围
     * @author Victor Tang<victortang@lulutrip.com>
     * @copyright 2017-8-21
     * @param $discountInfo
     * @param $productCode
     * @param $productAreaCodes
     * @return bool
     */
    private function _checkDiscountProduct($discountInfo, $productCode, $productAreaCodes) {
        // 默认结果为false
        $defaultCheckStatus = false;

        foreach ($discountInfo as $discount) {
            //每个订单
            if ($discount['discount_type'] == 0) {
                return true;
            }

            //指定产品参与活动
            if ($discount['discount_type'] == 1) {
                if ($discount['discount_product'] == 0 && (in_array($productCode, explode(',', $discount['discount_product_ids'])) || array_intersect($productAreaCodes, $discount['discount_region']))) {
                    return true;
                }
            }

            //指定产品不参与活动
            if ($discount['discount_type'] == 2) {
                $defaultCheckStatus = true;

                if ($discount['discount_product'] == 0 && (in_array($productCode, explode(',', $discount['discount_product_ids'])) || array_intersect($productAreaCodes, $discount['discount_region']))) {
                    return false;
                }
            }
        }

        return $defaultCheckStatus;
    }

    /**
     * 检查最小使用金额
     * @author Victor Tang<victortang@lulutrip.com>
     * @copyright 2017-8-21
     * @param $minPrice
     * @param $totalAmount
     * @throws \Exception
     */
    private function _checkMinPrice($minPrice, $totalAmount) {
        if ($totalAmount < $minPrice) {
            Yii::info('检查最小使用金额', __METHOD__);
            throw New \Exception('无法使用该优惠券');
        }
    }

    /**
     * 检查最大使用金额
     * @author Victor Tang<victortang@lulutrip.com>
     * @copyright 2017-8-21
     * @param $maxPrice
     * @param $totalAmount
     * @throws \Exception
     */
    private function _checkMaxPrice($maxPrice, $totalAmount) {
        if ($totalAmount > $maxPrice) {
            Yii::info('检查最大使用金额', __METHOD__);
            throw New \Exception('无法使用该优惠券');
        }
    }

    /**
     * 检查最大使用金额
     * @author Victor Tang<victortang@lulutrip.com>
     * @copyright 2017-8-21
     * @param $departureDate
     * @return bool
     */
    private function _checkDepartureDate($departureDate) {
        if ($this->promotion['limit_date_type'] == 1) {
            if ($this->promotion['departdate'] != '0000-00-00' && strtotime($departureDate) < strtotime($this->promotion['departdate'])) {
                return false;
            }

            if ($this->promotion['enddate'] != '0000-00-00' && strtotime($departureDate) > strtotime($this->promotion['enddate'])) {
                return false;
            }
        } elseif ($this->promotion['limit_date_type'] == 2) {
            $limitDates = array_filter(explode(',', $this->promotion['limit_date']));
            if (count($limitDates) > 0 && !in_array($departureDate, $limitDates)) {
                return false;
            }
        }

        return true;
    }

    /**
     * 检查限定使用会员
     * @author Victor Tang<victortang@lulutrip.com>
     * @copyright 2017-8-21
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
     * @author Victor Tang<victortang@lulutrip.com>
     * @copyright 2017-8-21
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
     * @author Victor Tang<victortang@lulutrip.com>
     * @copyright 2017-8-21
     * @return integer
     */
    public function apply() {
        $currency = $this->shoppingData->currency;
        $totalAmount = $this->shoppingData->totalAmount;
        $participateCouponAmount = $this->shoppingData->participateCouponAmount;
        $discountPrice = $this->_discountPrice($currency, $participateCouponAmount);

        // 优惠券减价金额不能超过订单总金额
        if ($discountPrice > $totalAmount) {
            $discountPrice = $totalAmount;
        }

        $this->shoppingData->usePromotion = new \lulutrip\modules\tour\library\booking\shoppingData\UsePromotion([
            'promotionId' => $this->promotion['promoid'],
            'promotionCode' => $this->promotion['promocode'],
            'discountPrice' => $discountPrice
        ]);
        $this->shoppingData->save();

        return $discountPrice;
    }

    /**
     * 取消使用优惠券
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-30
     * @param ShoppingData $shoppingData
     */
    public static function cancel(ShoppingData $shoppingData) {
        $shoppingData->usePromotion = new \lulutrip\modules\tour\library\booking\shoppingData\UsePromotion([
            'promotionCode' => null,
            'discountPrice' => 0
        ]);
        $shoppingData->save();
    }

    /**
     * 计算折后价
     * @author Victor Tang<victortang@lulutrip.com>
     * @copyright 2017-8-29
     * @param $currency string
     * @param $participateCouponAmount integer|float
     * @return integer
     */
    private function _discountPrice($currency, $participateCouponAmount) {
        $discountPrice = 0;

        $couponType = $this->promotion['coupon_type'];
        $couponPrice = $this->promotion['coupon_price'];
        $couponCurrency = $this->promotion['currency'];

        if ($couponType == 'P') {
            $discountPrice = Yii::$app->helper->floor2($participateCouponAmount * $couponPrice / 100);
        } elseif ($couponType == 'R') {
            $discountPrice = Help::exchangeCurrency($couponPrice, $couponCurrency, $currency, 'floor2');
        }

        return $discountPrice;
    }
}