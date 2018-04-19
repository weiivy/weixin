<?php
/**
 * 路路回电action
 * @copyright (c) 2017, lulutrip.com
 * @author  Serena Liu<serena@lulutrip.com>
 */
namespace lulutrip\modules\llt\actions\common;

use linslin\yii2\curl\Curl;
use yii\base\Action;
use yii\swiftmailer\Mailer;
use Yii;

class CallMeNow extends Action
{
    public function run()
    {
        $this->callMeNowPhoneSubmit();
    }
    /**
     * 路路回电：提交客户电话号码
     * @author Serena Liu<serena@lulutrip.com>
     * @copyright 2017-02-07
     * @return array
     */
    private function callMeNowPhoneSubmit()
    {
        $curl = new Curl();
        //提交失败1：若当前窗口，提交时间相隔，小于1分钟
        $smstime = \Yii::$app->session['CALLMENOW_AUTH']['timestamp'];
        if((time() - $smstime) / 60 < 1)
        {
            $data = array('flg' => 'ERR', 'msg' => '操作频繁，请休息一分钟吧');
            echo json_encode($data);
            exit;
        }

        //设置过期时间
        $authNum = array();
        $authNum['num'] = rand(100000, 999999);
        $authNum['timestamp'] = time();
        \Yii::$app->session['CALLMENOW_AUTH'] = $authNum;
        //设置过期时间 end
        $data = $whereArr = \Yii::$app->request->post();
        $data['submit_time'] = time();
        $data['source_link'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

        //提交失败2：若国家，电话号码，处理状态，数据库里存在
        $whereArr['status'] = 0;
        $result = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . "/get-callmenow/" . $whereArr['country'] . "/" . $whereArr['phone']);
        $total = $result['data'];
        if($total > 0)
        {
            $data = array('flg' => 'ERR', 'msg' => '提交成功，请等待小路回电');
            echo json_encode($data);
            exit;
        }

        $result = Yii::$app->helper->curlPost(Yii::$app->params['service']['api'] . "/add-callmenow", $data);
        $id = $result['data'];
        if($id)
        {
            //发邮件
            $data['id'] = $id;
            Yii::$app->mailer->backup = false;
            \Yii::$app->mailer->compose('@lulutrip/views/email/callmenow', ['data' => $data])
                ->setTo(['info@lulutrip.com'=>'Lulutrip Admin'])->setSubject('Lulutrip.com - 路路回电')->send();
            //发邮件 end

            $data = array('flg' => 'OK', 'msg' => '提交成功，请等待小路回电');
            echo json_encode($data);
            exit;
        }
        else
        {
            $data = array('flg' => 'ERR', 'msg' => '提交失败，请联系管理员');
            echo json_encode($data);
            exit;
        }
    }
}