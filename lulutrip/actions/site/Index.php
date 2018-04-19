<?php

/**
 * Created by PhpStorm.
 * User: renlikang
 * Date: 2017/1/19
 * Time: 上午11:43
 */

namespace lulutrip\actions\site;

use linslin\yii2\curl\Curl;
use yii\base\Action;

class Index extends Action
{
    public function run()
    {
       return $this->controller->render('index');
    }
}