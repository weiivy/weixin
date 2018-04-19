<?php

/**
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\actions\rentcar;
use api\library\Help;
use linslin\yii2\curl\Curl;
use yii\base\Action;
use yii;
use lulutrip\modules\rentcar\library\GetParams;

class GetView extends Action
{
    public function run() {
        $id = Yii::$app->request->get('id');
        //处理参数
        $_GET = Yii::$app->request->get();
        $param = GetParams::adaptParams($_GET);

        $curl = new Curl();
        $curl->get(Yii::$app->params['service']['api'] . '/rentcar/view/' . $id);
        $car = json_decode($curl->response, true)['data'];

        return $this->controller->render('@lulutrip/modules/rentcar/views/rentcar/view', [
            'param' => $param,
            'car' => $car['detail'],
            'location' => $car['location'],
        ]);
    }
}