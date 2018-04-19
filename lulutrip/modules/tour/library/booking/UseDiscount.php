<?php

namespace lulutrip\modules\tour\library\booking;

use api\library\Help;
use lulutrip\models\sale\ActivityProductsDiscount;
use lulutrip\modules\tour\library\detail\Discount;
use Yii;

/**
 * Class UseDiscount
 * @copyright (c) 2018, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
class UseDiscount
{
    /**
     * @var Discount
     */
    public $discount;

    /**
     * @var ShoppingData
     */
    public $shoppingData;

    /**
     * UseDiscount constructor.
     * @param $discount
     * @param $shoppingData
     */
    public function __construct($discount, $shoppingData)
    {
        $this->discount = $discount;
        $this->shoppingData = $shoppingData;
    }

    /**
     * 校验
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-02-03
     */
    public function _check()
    {
        if ($this->discount) {

            $promotionRule = new PromotionRule([], $this->shoppingData);
            return $promotionRule->_check($this->discount);
        } else {
            throw New \Exception('请选择参加的优惠');
        }
    }

    /**
     * 使用满减
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-02-03
     * @return float|int
     */
    public function apply()
    {
        $currency = $this->shoppingData->currency;
        $totalAmount = $this->shoppingData->totalAmount;
        $participateCouponAmount = $this->shoppingData->participateCouponAmount;
        $discountPrice = $this->_discountPrice($currency, $participateCouponAmount);

        // 优惠券减价金额不能超过订单总金额
        if ($discountPrice > $totalAmount) {
            $discountPrice = $totalAmount;
        }

        $formatDiscount = Discount::formatData($this->discount, $this->shoppingData->pcode);
        $this->shoppingData->useAfterDiscount = new \lulutrip\modules\tour\library\booking\shoppingData\UseDiscount([
            'id' => $this->discount['id'],
            'activity_id' => $this->discount['activity_id'],
            'title' => $formatDiscount['title'],
            'isDiscount' => $this->discount['is_discount'],
            'kind' => $this->discount['activity']['kind'],
            'discountPrice' => $discountPrice,
            'promoCode'     => $this->discount['activity']['promo_code']
        ]);
        $this->shoppingData->save();
        $this->shoppingData->promotionsInfo = [['displayName' =>  $formatDiscount['title'] . ' ' . $this->discount['activity']['promo_code'], 'amount' => -$discountPrice]];

        return $discountPrice;
    }

    /**
     * 计算折后价
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-02-03
     * @param $currency
     * @param $participateCouponAmount
     * @return float|int
     */
    private function _discountPrice($currency, $participateCouponAmount) {
        $discountPrice = 0;
        //折扣
        if($this->discount['type'] == ActivityProductsDiscount::TYPE_DISCOUNT) {
            $discountPrice = Yii::$app->helper->floor2($participateCouponAmount * (10-$this->discount['discount']) / 10);
        } elseif($this->discount['type'] == ActivityProductsDiscount::TYPE_REDUCE) {
            //减价
            $coupon = json_decode($this->discount['reduce'],true);
            $discountPrice = Help::exchangeCurrency($coupon['value'], $coupon['unit'], $currency, 'floor2');
        }
        return $discountPrice;
    }

    /**
     * 取消使用满减
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-02-03
     * @param ShoppingData $shoppingData
     */
    public static function cancel(ShoppingData $shoppingData) {
        $shoppingData->useAfterDiscount = new \lulutrip\modules\tour\library\booking\shoppingData\UseDiscount([
            'id' => null,
            'activity_id' => null,
            'title' => null,
            'isDiscount' => null,
            'kind' => null,
            'discountPrice' => 0
        ]);
        $shoppingData->promotionsInfo = null;
        $shoppingData->save();

    }
} 