<?php
/**
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\llt\controllers;
use Yii;
use yii\rest\Controller;
use lulutrip\modules\rentcar\library\booking\ShoppingData;

class RentcarController extends Controller
{
    /**
     * @Summary 立即订购接口
     * @copyright 2017-09-07
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @return array
     */
    public function actionBooking() {
        $request = json_decode(Yii::$app->request->getRawBody(), true);
        $daylen = strtotime($request['return_time']) - strtotime($request['pickup_time']);
        if (empty($request['carid']) || empty($request['pickup_location']) || empty($request['return_location']) || $daylen <= 0) {
            Yii::$app->response->statusCode = 400;
            return ['error' => true, 'message' => '请检查必填项目'];
        }
        $shoppingData = new ShoppingData();
        $shoppingData->carid            = $request['carid'];
        $shoppingData->pickup_location  = $request['pickup_location'];
        $shoppingData->pickup_time      = $request['pickup_time'];
        $shoppingData->return_location  = $request['return_location'];
        $shoppingData->return_time      = $request['return_time'];
        $shoppingData->insurance        = $request['insurance'];

        if ($shoppingData->save()) {
            return ['shoppingId' => $shoppingData->shoppingId, Yii::$app->config->www . '/rental-car/booking/' .  $shoppingData->shoppingId];
        } else {
            Yii::$app->response->statusCode = 500;
            return ['error' => true, 'message' => '服务器错误'];
        }
    }
}