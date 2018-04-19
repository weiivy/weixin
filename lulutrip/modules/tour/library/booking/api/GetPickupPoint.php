<?php

namespace lulutrip\modules\tour\library\booking\api;

use Curl\Curl;
use lulutrip\modules\tour\library\booking\ShoppingData;
use Yii;

/**
 * Class GetPickupPoint
 * @package lulutrip\modules\tour\library\booking\api
 * @author Victor Tang<victor.tang@ipptravel.com>
 * @copyright (c) 2018, lulutrip.com
 */
class GetPickupPoint {
    /**
     * 获取上车地点数据
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2018-02-03
     * @param ShoppingData $shoppingData
     * @return mixed
     * @throws \Exception
     */
    public static function data(ShoppingData $shoppingData) {
        $curl = new Curl();
        $url = Yii::$app->params['service']['tourapi'] . "/gtravel/product/{$shoppingData->pcode}/point/{$shoppingData->localPickup->uid}";
        $curl->get($url);
        $result = json_decode(json_encode($curl->response), true);
        if ($result['rs'] == 1) {
            Yii::info('API-GET: ' . $url . '===' . json_encode($result), __METHOD__);
            return $result['data'];
        } else {
            Yii::error('API-GET: ' . $url . '===' . json_encode($result), __METHOD__);
            throw new \Exception("接口错误");
        }
    }
}