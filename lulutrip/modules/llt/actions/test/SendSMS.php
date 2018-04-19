<?php

namespace lulutrip\modules\llt\actions\test;
use yii\base\Action;
use yii;

/**
 * 测试短信发送
 * @author Xiaopei Dou<xiaopei.dou@ipptravel.com>
 * @copyright 2018-03-06
 */
class SendSMS extends Action
{
    public function run() {
        $post = Yii::$app->request->post();
        $return = Yii::$app->helper->curlPost(Yii::$app->params['service']['api'] . '/send-short-message', $post);
        echo json_encode($return);
        exit;

    }
}