<?php

namespace lulutrip\modules\channel\actions\channel;

use lulutrip\components\Cookies;
use yii\base\Action;
use Yii;

/**
 * 美加频道页
 * @copyright (c) 2018, lulutrip.com
 * @author  Victor Tang<victortang@ipptravel.com>
 */
class America extends Action
{
    public function run()
    {
        $cookies = new Cookies();
        $cookies->setCookies('visitHomePage', 'ok');

        //Sonic SEM投放UTM代码传递至跳转后页面
        $urlTemp = explode("?", $_SERVER['REQUEST_URI']);
        if(count($urlTemp) > 1)
        {
            array_shift($urlTemp);
            $params = "?". $urlTemp[0];
        }
        $url = Yii::$app->params['service']['www'] . $params;

        return Yii::$app->response->redirect($url);
    }
} 