<?php
/**
 * @copyright (c) 2017, lulutrip.com
 * @author LT<todd@lulutrip.com>
 */
namespace lulutrip\actions\cruise;

use api\library\cruise\Tourico;
use linslin\yii2\curl\Curl;
use yii\base\Action;
use Yii;

class GetDeal extends Action
{
    public function run()
    {
        $this->controller->layout = false;
        $curl = new Curl();
        $curl->get(Yii::$app->params['service']['api'] . '/cruise/deal');
        //echo $curl->response;die;
        $return = json_decode($curl->response, true);
        $deal = (new Tourico())->getBestDeals(1);
        return $this->controller->render("deal", [
            'deal' => $return['data']
        ]);
    }
}