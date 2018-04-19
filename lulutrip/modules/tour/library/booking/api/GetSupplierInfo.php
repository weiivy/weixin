<?php

namespace lulutrip\modules\tour\library\booking\api;

use Curl\Curl;
use lulutrip\modules\tour\library\booking\ShoppingData;
use Yii;

/**
 * Class GetSupplierInfo
 * @package lulutrip\modules\tour\library\booking\api
 * @author Victor Tang<victor.tang@ipptravel.com>
 * @copyright (c) 2018, lulutrip.com
 */
class GetSupplierInfo {
    /**
     * 获取产品供应商信息
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2018-01-26
     * @param ShoppingData $shoppingData
     * @return mixed
     * @throws \Exception
     */
    public static function data(ShoppingData $shoppingData) {
        $curl = new Curl();
        $url = Yii::$app->config->tourapi . "/gtravel/lulu/product/{$shoppingData->pcode}/pinfo";
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