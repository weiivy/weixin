<?php
/**
 * @copyright (c) lulutrip, 2017
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\actions\rentcar;

use linslin\yii2\curl\Curl;
use yii\base\Action;
use yii;

class GetPrice extends Action
{
    public function run() {
        $id             = Yii::$app->request->post('id', 0);
        $pickUpLocation = Yii::$app->request->post('pickUpLocation', 0);
        $returnLocation = Yii::$app->request->post('returnLocation', 0);
        $pickUpDate     = Yii::$app->request->post('pickUpDate');
        $pickUpTime     = Yii::$app->request->post('pickUpTime');
        $returnDate     = Yii::$app->request->post('returnDate');
        $returnTime     = Yii::$app->request->post('returnTime');
        $insurance      = Yii::$app->request->post('insurance', 0);
        $curl           = new Curl();
        $post           = [
            'id'             => $id,
            'pickUpLocation' => $pickUpLocation,
            'returnLocation' => $returnLocation,
            'pickUpDate'     => $pickUpDate,
            'pickUpTime'     => $pickUpTime,
            'returnDate'     => $returnDate,
            'returnTime'     => $returnTime,
            'insurance'      => $insurance,
        ];
        $curl->reset()->setOption(CURLOPT_POSTFIELDS, http_build_query($post))
            ->post(\Yii::$app->params['service']['api'] . "/rentcar/price");
        return $curl->response;
    }
}