<?php

namespace lulutrip\modules\tour\library\booking\api;

use lulutrip\modules\tour\library\booking\ShoppingData;
use Yii;

/**
 * Class GetBooking
 * @package lulutrip\modules\tour\library\booking\api
 * @author Victor Tang<victor.tang@ipptravel.com>
 * @copyright (c) 2017, lulutrip.com
 */
class GetBooking {
    /**
     * 获取产品当日套餐信息
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-09-18
     * @param ShoppingData $shoppingData
     * @return mixed
     */
    public static function data(ShoppingData $shoppingData) {
        $url = Yii::$app->params['service']['tourapi'] . "/gtravel/lulu/product/{$shoppingData->pcode}/booking/{$shoppingData->sdate}";

        $data = [
            'currency' => Yii::$app->params['curCurrency'],
            'itemId' => $shoppingData->itemId,
            'roomInfos' => $shoppingData->roomInfos
        ];
        $result = Yii::$app->helper->curlJson($url, $data);

        Yii::info('API-POST:' . $url . '===' .json_encode($data) . '===' . json_encode($result), __METHOD__);

        return $result['data'];
    }
}