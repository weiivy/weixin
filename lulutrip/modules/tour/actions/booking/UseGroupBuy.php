<?php

namespace lulutrip\modules\tour\actions\booking;


use lulutrip\modules\tour\library\booking\Booking;
use lulutrip\modules\tour\library\booking\ShoppingData;
use lulutrip\modules\tour\library\booking\UseDiscount;
use lulutrip\modules\tour\library\booking\UsePoints;
use lulutrip\modules\tour\library\booking\UsePromotion;
use yii\base\Action;
use Yii;

/**
 * 使用秒杀或折后价
 * @copyright (c) 2018, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
class UseGroupBuy extends Action
{
    public function run()
    {
        $request = json_decode(Yii::$app->request->getRawBody(), true);

        if (empty($request['shoppingId'])) {
            Yii::$app->response->statusCode = 400;
            return ['code' => 400, 'message' => '缺少参数'];
        }
        $type = $request['type'];

        $shoppingId = $request['shoppingId'];
        $shoppingData = new ShoppingData($shoppingId);

        if($type == 'use') {
            Booking::saveDiscountType($shoppingData, null);
        }
        $shoppingData->getInventory();
        $discountPrice = 0;
        if($type == 'use') {
            if($shoppingData->usePromotion->promotionId > 0) {
                $discountPrice = $shoppingData->usePromotion->discountPrice;
            } elseif($shoppingData->useAfterDiscount->id > 0) {
                $discountPrice = $shoppingData->useAfterDiscount->discountPrice;
            }
        } elseif($type == 'delete') {
            UseDiscount::cancel($shoppingData);
            //取消使用优惠券
            UsePoints::cancel($shoppingData);
            UsePromotion::cancel($shoppingData);
            Booking::saveDiscountType($shoppingData, 5);

        }

        return Booking::_returnData($shoppingData, $discountPrice);
    }
} 