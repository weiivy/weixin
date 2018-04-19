<?php
/**
 * 旅行团售罄 预定表单提交
 * @copyright (c) 2017, lulutrip.com
 * @author  xiaopei Dou<xiaopei.dou@ipptravel.com>
 */
namespace lulutrip\modules\llt\actions\tour;

use common\components\Captcha;
use yii\rest\Action;
use api\library\product\SoldOut;

use Yii;

class bookingFormSubmit extends Action
{
    public $modelClass = '';

    public function run()
    {
        return $this->bookingFormSubmit();
    }
    /**
     * 我要提问：提交客户问题
     * @author Xiaopei Dou<xiaopei.dou@ipptravel.com>
     * @copyright 2017-09-29
     * @return array
     */
    private function bookingFormSubmit()
    {
        $post = Yii::$app->request->post();

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
        $data['uid'] = !empty(Yii::$app->user->current_user['memberid'])? Yii::$app->user->current_user['memberid'] : 0;
        $data['pid'] = $post['tourcode'];
        $data['ptype'] = $post['ptype'];
        $data['sdate'] = $post['startdate'];
        $data['info'] = serialize(array('name'=>$post['name'],'mobile'=>$post['mobile'],'email'=>$post['email'],'adult_qty'=>$post['adult_qty'],'child_qty'=>$post['child_qty']));
        $data['ctime'] = time();

        //把用户提交的信息入库
        $model = new SoldOut();
        $mpfid = $model->submitBookingForm($data);

        //发邮件
        if($mpfid) {
            \Yii::$app->mailer->backup = true;
            \Yii::$app->mailer->compose('@lulutrip/views/email/tour_help_form.html', ['Tour' => $post])
                ->setTo(['info@lulutrip.com'=>'Lulutrip Admin'])
                ->setSubject('Lulutrip.com - Tour Assist Form')
                ->send();

            $res = array('flg' => 'SUCCESS', 'msg' => '您的预订单已提交成功，小路会尽快给到回复');
            return $res;
        } else {
            $res = array('flg' => 'ERROR', 'msg' => '提交失败，请联系管理员');
            return $res;
        }

    }
}