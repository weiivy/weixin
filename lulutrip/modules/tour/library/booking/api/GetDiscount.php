<?php

namespace lulutrip\modules\tour\library\booking\api;


use Curl\Curl;
use lulutrip\models\sale\Activities;
use lulutrip\models\sale\ActivityProductsDiscount;
use Yii;

/**
 * class GetDiscount
 * @copyright (c) 2018, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
class GetDiscount
{
    public static function data($tourCode, $discountId)
    {
        $curl = new Curl();
        $post = [
            'pid'       => $tourCode,
            'channel'   => Activities::CHANNEL_1,
            'platform'  => Activities::PLATFORM_LUPC,
            'id'        => $discountId
        ];
        $curl->post(Yii::$app->params['service']['api'] . "/saleactivity/get-discount-info", $post);
        $offPercent = 1;
        $offPrice   = [];
        if(!empty($curl->response->data)) {
            switch($curl->response->data->type)
            {
                case ActivityProductsDiscount::TYPE_DISCOUNT:
                    $offPercent = $curl->response->data->discount;
                    break;
                case ActivityProductsDiscount::TYPE_REDUCE:
                    $offPrice = json_decode($curl->response->data->reduce, true);
                    break;
            }
        }
        return ['offPercent' => $offPercent, 'offPrice' => $offPrice, 'discountInfo' => $curl->response->data];

    }
} 