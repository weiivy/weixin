<?php
/**
 * @Summary 用于测试
 * @author Justin Jia<justin.jia@ipptravel.com>
 * @copyright 2017-08-31
 */

namespace lulutrip\modules\llt\controllers;

use yii\rest\Controller;
class TestController extends Controller
{
    public function actions() {
        return [
            'email'       => 'lulutrip\modules\llt\actions\test\SendEmail',
            'write-file'  => 'lulutrip\modules\llt\actions\test\WriteFile',
            'batch-data'  => 'lulutrip\modules\llt\actions\test\BatchData',
            'send-short-message'       => 'lulutrip\modules\llt\actions\test\SendSMS',
        ];
    }
}