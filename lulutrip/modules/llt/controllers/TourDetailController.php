<?php

namespace lulutrip\modules\llt\controllers;

use lulutrip\models\sale\Activities;
use lulutrip\modules\tour\library\booking\ShoppingData;
use yii\rest\Controller;
use Curl\Curl;
use Yii;

class TourDetailController extends Controller {

    /**
     * 获取秒杀折扣
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-15
     * @param $tourCode integer 团号
     * @return float|int
     */
    protected function getOffPercent($tourCode) {
        $curl = new Curl();
        $offPercent = 1;

        //团购
        $curl->get(Yii::$app->params['service']['api'] . "/tour/group-buying/". $tourCode);
        if(!empty($curl->response->data)){
            $offPercent = $curl->response->data->off_percent / 10;
        }


        if($offPercent == 1) {
            //折后价
            $post = [
                'pid'       => $tourCode,
                'channel'   => Activities::CHANNEL_1,
                'platform'  => Activities::PLATFORM_LUPC
            ];
            $curl->post(Yii::$app->params['service']['api'] . "/saleactivity/get-max-discount", $post);
            if(!empty($curl->response->data)){
                $offPercent = $curl->response->data->discount / 10;
            }
        }

        return $offPercent;
    }

    /**
     * 计算秒杀价格
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-11-01
     * @param $tourCode
     * @param $items
     */
    protected function calculateOffPrice($tourCode, $items) {
        $offPercent = $this->getOffPercent($tourCode);
        if ($offPercent > 0 && $offPercent < 1) {
            foreach ((array)$items as $item) {
                $item->roomsOriginPrice = clone $item->rooms;
                foreach ((array)$item->rooms as $roomType => $price) {
                    if (in_array($roomType, ['one_person', 'two_person', 'three_person', 'four_person', 'adult']) && $price > 0) {
                        $item->rooms->{$roomType} = Yii::$app->helper->ceil2($price * $offPercent);
                    }
                }
                $item->startPrice = ceil($item->startPrice * $offPercent);
            }
        }
    }

    /**
     * 获取日历索引
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-14
     * @param $tourCode integer 团号
     * @return mixed
     */
    public function actionFirstMonthPrice($tourCode) {
        $currency = Yii::$app->params['curCurrencies']['code'];

        $curl = new Curl();
        $curl->setHeader('currency', $currency);
        $url = Yii::$app->params['service']['tourapi'] . "/gtravel/lulu/product/{$tourCode}/price/mindex";
        $curl->get($url);
        Yii::info('API-GET: ' . $url . '===HEAD: ' . json_encode(['currency'=> $currency]) . '===' . json_encode($curl->response), __METHOD__);

        // 计算秒杀价格
        $this->calculateOffPrice($tourCode, $curl->response->data->first->items);

        return $curl->response;
    }

    /**
     * 获取指定月份价格日历
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-14
     * @param $tourCode integer 团号
     * @param $month string 月份
     * @return mixed
     */
    public function actionMonthlyPrice($tourCode, $month) {
        $currency = Yii::$app->params['curCurrencies']['code'];

        $curl = new Curl();
        $curl->setHeader('currency', $currency);
        $url = Yii::$app->params['service']['tourapi'] . "/gtravel/lulu/product/{$tourCode}/price/{$month}";
        $curl->get($url);
        Yii::info('API-GET: ' . $url . '===HEAD: ' . json_encode(['currency'=> $currency]) . '===' . json_encode($curl->response), __METHOD__);

        // 计算秒杀价格
        $this->calculateOffPrice($tourCode, $curl->response->data->items);

        return $curl->response;
    }

    /**
     * 获取价格清单
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-14
     * @return mixed
     */
    public function actionCountPrice() {
        $currency = Yii::$app->params['curCurrencies']['code'];

        $request = json_decode(Yii::$app->request->getRawBody(), true);
        $curl = new Curl();
        $curl->setHeader('Content-Type', 'application/json');
        $url = Yii::$app->params['service']['tourapi'] . "/gtravel/lulu/product/{$request['pcode']}/inventorys/{$request['sdate']}";
        $data = [
            'currency' => $currency,
            'itemId' => $request['itemId'],
            'roomInfos' => $request['roomInfos']
        ];
        $curl->post($url, $data);
        Yii::info('API-POST: ' . $url . '===' . json_encode($data) . '===' . json_encode($curl->response), __METHOD__);

        $personAmount = 0;
        foreach ((array)$request['roomInfos'] as $room) {
            $personAmount += $room['adNum'] + $room['kdNum'];
        }

        // 计算秒杀价格
        $offPercent = $this->getOffPercent($request['pcode']);
        if ($offPercent > 0 && $offPercent < 1) {
            $data = Yii::$app->helper->stdClassObjectToArray($curl->response);
            $data['data']['totalAmount'] = Yii::$app->helper->ceil2($data['data']['totalAmount'] - $data['data']['participateCouponAmount'] * (1 - $offPercent));
            $data['data']['avgAmount'] = Yii::$app->helper->ceil2($data['data']['totalAmount'] / $personAmount);
            return $data;
        }

        return $curl->response;
    }

    /**
     * 我要订购接口
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-14
     * @return array
     */
    public function actionBooking() {
        $request = json_decode(Yii::$app->request->getRawBody(), true);

        if (empty($request['pcode']) || empty($request['sdate'] || empty($request['itemId'] || empty($request['roomInfos'])))) {
            Yii::$app->response->statusCode = 400;
            return ['error' => true, 'message' => '请检查必填项目'];
        }

        $shoppingData = new ShoppingData();
        $shoppingData->pcode = $request['pcode'];
        $shoppingData->sdate = $request['sdate'];
        $shoppingData->itemId = $request['itemId'];
        $shoppingData->roomInfos = $request['roomInfos'];
        if ($shoppingData->save()) {
            return ['shoppingId' => $shoppingData->shoppingId, 'url' => Yii::$app->config->bookingUrl . '/tour/booking/' .  $shoppingData->shoppingId];
        } else {
            Yii::$app->response->statusCode = 500;
            return ['error' => true, 'message' => '服务器错误'];
        }
    }
}
