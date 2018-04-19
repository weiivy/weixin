<?php

/**
 * 测试邮件发送
 * @author Justin Jia<justin.jia@ipptravel.com>
 * @copyright 2017-08-31
 */
namespace lulutrip\modules\llt\actions\test;
use yii\base\Action;
use yii;

class SendEmail extends Action
{
    public function run() {
        $type = Yii::$app->request->get('type');
        $email = Yii::$app->request->get('email');
        Yii::$app->mailer->backup = false;
        Yii::$app->mailer->recordLog = false;
        $this->controller->layout = false;
        $body = $this->controller->render('@lulutrip/modules/llt/views/mail/test', ['content' => '测试邮件发送']);
        
        if($type == 1){
            Yii::$app->mailer->compose('@common/mail/layout.html', ['content' => $body])
                ->setTo($email)->setSubject('测试邮件发送情况')->send();
        }else{
            Yii::$app->mailer->compose()
                ->setTo($email)->setSubject('测试邮件发送情况')->setHtmlBody($body)->send();
        }
    }
}