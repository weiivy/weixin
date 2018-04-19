<?php

namespace lulutrip\modules\tour\library\booking\api;

use Curl\Curl;
use Yii;


/**
 * Class GetOffPercent
 * @package lulutrip\modules\tour\library\booking\api
 */
class GetOffPercent {
    /**
     * 获取秒杀折扣
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-15
     * @param $tourCode integer 团号
     * @return array
     */
    public static function data($tourCode) {
        $curl = new Curl();
        $curl->get(Yii::$app->params['service']['api'] . "/tour/group-buying/". $tourCode);
        $offPercent = 1;
        if(isset($curl->response->data->off_percent)){
            $offPercent = $curl->response->data->off_percent / 10;
        }
        $promotionId = $curl->response->data->promotion_id;


        return ['offPercent' => $offPercent, 'promotionId' => $promotionId, 'tagInfo' => $curl->response->data->tagInfo];
    }
}