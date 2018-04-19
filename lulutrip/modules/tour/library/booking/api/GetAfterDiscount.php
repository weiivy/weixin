<?php

namespace lulutrip\modules\tour\library\booking\api;
use Curl\Curl;
use lulutrip\models\sale\Activities;
use Yii;

/**
 * Class GetAfterDiscount
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
class GetAfterDiscount {
    /**
     * 获取折后价最大折扣
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-12-01
     *
     * @param $tourCode integer 团号
     * @return array
     */
    public static function data($tourCode) {
        $curl = new Curl();
        $post = [
            'pid'       => $tourCode,
            'channel'   => Activities::CHANNEL_1,
            'platform'  => Activities::PLATFORM_LUPC
        ];
        $curl->post(Yii::$app->params['service']['api'] . "/saleactivity/get-max-discount", $post);
        $offPercent = 1;
        if(isset($curl->response->data->discount)){
            $offPercent = $curl->response->data->discount / 10;
        }
        $id = $curl->response->data->id;
        $activityId = $curl->response->data->activity_id;
        $detailInfo = $curl->response->data;

        return ['offPercent' => $offPercent, 'id' => $id, 'activity_id' => $activityId, 'detailInfo' => $detailInfo];
    }
} 