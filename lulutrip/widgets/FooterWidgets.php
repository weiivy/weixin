<?php
/**
 * 底部小部件
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\widgets;

use linslin\yii2\curl\Curl;
use yii\base\Widget;

class FooterWidgets extends Widget
{
    public function run()
    {
        $curl = new Curl();
        $result = $curl->get(\Yii::$app->params['service']['api'] . "/get-ads");
        $adviserSaler = json_decode($curl->response, true);
        //客服电话
        $curl->post(\Yii::$app->params['service']['api'] . '/admin/base/phone/list');
        $serviceTel = json_decode($curl->response, true);
        return $this->render('@lulutrip/views/widgets/_footer', array(
            'adviserSaler' => empty($adviserSaler['data']) ? [] : $adviserSaler['data'],
            'serviceTel' => empty($serviceTel['data']) ? [] : $serviceTel['data']
        ));
    }
}