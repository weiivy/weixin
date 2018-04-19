<?php
/**
 * @copyright (c) 2017, lulutrip.com
 * @author LT<todd@lulutrip.com>
 */
namespace lulutrip\actions\cruise;

use lulutrip\components\Cookies;
use lulutrip\components\Helper;
use yii\base\Action;
use Yii;
use linslin\yii2\curl\Curl;

class Index extends Action
{
    public function run()
    {
        $curl = new Curl();
        $curl->get(Yii::$app->params['service']['api'] . '/cruise/home');
        //echo $curl->response;die;
        $return = json_decode($curl->response, true);
        //var_dump($return['data']['filter']);die;
        $cookie = new Cookies();
        $navigationtype = $cookie->getCookies('navigationtype', 'NA');
        Helper::setSeo('cruise', 'home');
        //客服电话
        $curl->get(Yii::$app->params['service']['api'] . '/get-static-nav');
        $phones = json_decode($curl->response, true);
        return $this->controller->render('home', [
            'navigationtype'  => $navigationtype,
            'destination' => $return['data']['destination'],
            'line' => $return['data']['line'],
            'port' => $return['data']['port'],
            //'deal' => $return['data']['deal'],
            'dep' => $return['data']['dep'],
            'tod' => $return['data']['tod'],
            'length' => $return['data']['length'],
            'filter' => $return['data']['filter'],
            'newFilter' => $return['data']['newFilter'],
            'phones' => empty($phones['data']['IpPhone']) ? [] : $phones['data']['IpPhone']
        ]);
    }
}