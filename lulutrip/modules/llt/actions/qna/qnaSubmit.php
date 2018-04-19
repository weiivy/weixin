<?php
/**
 * 旅行团详情页提交问题
 * @copyright (c) 2017, lulutrip.com
 * @author  xiaopei Dou<xiaopei.dou@ipptravel.com>
 */
namespace lulutrip\modules\llt\actions\qna;

use common\components\Captcha;
use yii\rest\Action;
use api\library\product\Qna;
use api\library\member\MemberInfo;

use Yii;

class qnaSubmit extends Action
{
    public $modelClass = '';

    public function run()
    {
        return $this->qnaSubmit();
    }
    /**
     * 我要提问：提交客户问题
     * @author Xiaopei Dou<xiaopei.dou@ipptravel.com>
     * @copyright 2017-08-01
     * @return array
     */
    private function qnaSubmit()
    {
        $post = Yii::$app->request->post();
        $data['datetime'] = time();

        //验证问题内容
        if(\Yii::$app->helper->strLength($post['content'])<10){
            $res = array('flg' => 'CONLESS', 'msg' => '问题内容不能少于10个字符');
            return $res;
        }
        //验证邮箱
        if(!\Yii::$app->helper->ce($post['email'])){
            $res = array('flg' => 'EMAILERR', 'msg' => '邮箱格式错误');
            return $res;
        }
        //检测验证码
        if (!Captcha::check($post['authcode'])) {
            $res = array('flg' => 'CODEERR', 'msg' => '验证码错误');
            return $res;
        }
        $data['member_email'] = $post['email'];
        $data['product_title'] = $post['productTitle'];
        $data['product_type'] = $post['productType'];
        $data['tourcode'] = $post['tourcode'];
        $data['content'] = $post['content'];
        //禁止重复提交
        $model = new Qna();
        $qna = $model->CheckResubmit($data['tourcode'], $data['member_email'], $data['content'], $data['product_type']);
        if($qna){
            $res = array('flg' => 'REPEAT', 'msg' => '请勿重复提交');
            return $res;
        }

        // Add To Maillist
        $row = (new MemberInfo())->getMemberByEmail($data['member_email']);
        if (empty($row['memberid'])) {
            $member = array(
                "email" => $data['member_email'],
                "mailinglist" => "Y",
                "membertype" => 0,
                "islite" => "Q");
            $data['memberid'] = (new MemberInfo())->saveMembers($member);
        }else{
            $data['memberid'] = $row['memberid'];
        }

        //把问题入库
        $qid = $model->submitQna($data);

        //发邮件
        if($qid) {
            //发邮件
            $data['id'] = $qid;
            \Yii::$app->mailer->backup = false;
            \Yii::$app->mailer->compose('@lulutrip/views/email/qna_question', ['data' => $data])
                ->setTo(['info@lulutrip.com'=>'Lulutrip Admin'])
                ->setSubject('Lulutrip.com - 用户提问')
                ->send();
            //发邮件 end

            $res = array('flg' => 'SUCCESS', 'msg' => '您的问题已提交成功，小路会尽快给到回复');
            return $res;
        } else {
            $res = array('flg' => 'ERROR', 'msg' => '提交失败，请联系管理员');
            return $res;
        }

    }
}