<?php

namespace lulutrip\modules\tour\actions\booking;

use lulutrip\modules\tour\library\booking\Booking;
use lulutrip\modules\tour\library\booking\ShoppingData;
use lulutrip\modules\tour\library\booking\UseDiscount;
use Yii;
use yii\base\Action;

/**
 * 去除使用满减
 * @copyright (c) 2018, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
class DeleteFullReduce extends Action
{
    public function run()
    {
        $request = json_decode(Yii::$app->request->getRawBody(), true);

        if (empty($request['shoppingId'])) {
            Yii::$app->response->statusCode = 400;
            return ['code' => 400, 'message' => '缺少参数'];
        }

        $shoppingId = $request['shoppingId'];
        $shoppingData = new ShoppingData($shoppingId);
        $shoppingData->getInventory();

        UseDiscount::cancel($shoppingData);
        Booking::saveDiscountType($shoppingData, 5);
        return Booking::_returnData($shoppingData, 0);
    }
} 