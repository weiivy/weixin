<?php

namespace lulutrip\modules\tour\library\booking;

use Curl\Curl;
use lulutrip\models\sale\Activities;
use lulutrip\models\sale\ActivityProductsDiscount;
use Yii;
use api\library\Help;
use yii\base\Exception;

/**
 * Booking
 * @copyright (c) 2018, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
class Booking
{
    /**
     * 返回数据
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     * @param ShoppingData $shoppingData
     * @param $discountPrice
     * @return array
     */
    public static function _returnData(ShoppingData $shoppingData, $discountPrice)  {
        return [
            'currency' => Yii::$app->params['curCurrencies'],
            'discountPrice' => $discountPrice,
            'totalAmount' => self::_getTotalAmount($shoppingData),
            'totalAmounts' => self::_getTotalAmounts($shoppingData)
        ];
    }

    /**
     * 计算总价
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     * @param ShoppingData $shoppingData
     * @return float|int
     */
    public static function _getTotalAmount(ShoppingData $shoppingData) {
        $shoppingData->totalAmount = $shoppingData->totalAmount - $shoppingData->usePromotion->discountPrice - $shoppingData->usePoints->discountPrice - $shoppingData->useAfterDiscount->discountPrice;
        return $shoppingData->totalAmount;
    }

    /**
     * 计算各个币种总价
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     * @param ShoppingData $shoppingData
     * @return TotalAmount[]
     */
    public static function _getTotalAmounts(ShoppingData $shoppingData) {
        foreach ($shoppingData->totalAmounts as $totalAmounts) {
            $totalAmounts->amount = Help::exchangeCurrency($shoppingData->totalAmount, $shoppingData->currency, $totalAmounts->currency, 'ceil2');
            $totalAmounts->currency = Yii::$app->params['currencies'][$totalAmounts->currency];
        }

        return $shoppingData->totalAmounts;
    }

    /**
     * 根据优惠码回去数据并计算最优
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-02-09
     * @param ShoppingData $shoppingData
     * @param $promotionCode
     * @return array
     * @throws \Exception
     */
    public static function getCouponByCode(ShoppingData $shoppingData, $promotionCode)
    {
        $curl = new Curl();
        $post = [
            'pid' => $shoppingData->pcode,
            'promoCode' => $promotionCode,
            'channel'   => Activities::CHANNEL_1,
            'platform'  => Activities::PLATFORM_LUPC
        ];
        $curl->post(Yii::$app->config->api . '/saleactivity/get-coupon', $post);
        if(empty($curl->response->data)){
            throw new \Exception("优惠码不可用");
        }

        $discounts = json_decode(json_encode($curl->response->data), true);

        //过滤符合条件的
        $promotionRule = new PromotionRule($discounts, $shoppingData);
        $discounts = $promotionRule->checkPromotions();
        if(empty($discounts)){
            throw new \Exception("优惠码不可用");
        }

        //计算最优
        $currency = $shoppingData->currency;
        $participateCouponAmount = $shoppingData->participateCouponAmount;
        $discountPrice = 0;
        $discount = [];
        foreach($discounts  as $value) {
            $temp = 0;
            //折扣
            if($value['type'] == ActivityProductsDiscount::TYPE_DISCOUNT) {
                $temp = Yii::$app->helper->floor2($participateCouponAmount * (10 - $value['discount']) / 10);
            } elseif($value['type'] == ActivityProductsDiscount::TYPE_REDUCE) {
                //减价
                $coupon = json_decode($value['reduce'],true);
                $temp = Help::exchangeCurrency($coupon['value'], $coupon['unit'], $currency, 'floor2');
            }
            if($temp < $discountPrice ) continue;
            $discountPrice = $temp;
            $discount = $value;
        }
        return $discount;
    }

    /**
     * 修改discountType值
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-02-23
     * @param ShoppingData $shoppingData
     * @param $discountType
     */
    public static function saveDiscountType(ShoppingData $shoppingData, $discountType)
    {
        $shoppingData->discountType = $discountType;
        $shoppingData->save();
    }


} 