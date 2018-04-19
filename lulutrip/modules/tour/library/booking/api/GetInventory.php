<?php

namespace lulutrip\modules\tour\library\booking\api;

use lulutrip\modules\tour\library\booking\ShoppingData;
use Yii;
use \Exception;

/**
 * Class GetInventory
 * @author Victor Tang<victor.tang@ipptravel.com>
 * @copyright (c) 2017, lulutrip.com
 */
class GetInventory {
    /**
     * 获取产品价格清单
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     * @param ShoppingData $shoppingData 订购数据
     * @param boolean $check 下单检查
     * @return mixed
     * @throws Exception
     */
    public static function data(ShoppingData $shoppingData, $check = false) {
        $url = Yii::$app->params['service']['tourapi'] . "/gtravel/lulu/product/{$shoppingData->pcode}/inventorys/{$shoppingData->sdate}";

        $data = json_encode([
            'currency' => Yii::$app->params['curCurrency'],
            'itemId' => $shoppingData->itemId,
            'check' => $check,
            'roomInfos' => $shoppingData->roomInfos,
            'activityGroups' => $shoppingData->activityGroups,
            'advanceHotel' => $shoppingData->advanceHotel,
            'postponeHotel' => $shoppingData->postponeHotel
        ]);
        $result = Yii::$app->helper->curlJson($url, $data);

        $message = 'API-POST: ' . $url . '===' . $data . '===' . json_encode($result);
        if ($result['rs'] == 1) {
            Yii::info($message, __METHOD__);
            return $result['data'];
        } else {
            Yii::error($message, __METHOD__);
            throw new \Exception($result['msg'], $result['code']);
        }
    }
}