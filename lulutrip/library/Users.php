<?php
/**
 * 用户相关
 * @copyright (c) 2017, lulutrip.com
 * @author  Serena Liu<serena.liu@ipptravel.com>
 */
namespace lulutrip\library;

use common\models\Members;
use lulutrip\components\Helper;
use yii\base\Component;
use Yii;

class Users extends Component
{
    public function index()
    {
        return [
            'detail' => 'hello',
        ];
    }
    /**
     * 根据会员id获取会员信息
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-02-16
     * @param $memberId
     *
     * @return array
     */
    public function getMemberById($memberId)
    {
        return Members::find()
            ->select('*')
            ->asArray()
            ->where('memberid = :memberid', array(":memberid" => $memberId))
            ->one();
    }

    /**
     * 更新 订购人 信息(包括更新 或 插入)
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @copyright 2017-08-27
     * @return array
     */
    public function saveMembers($data)
    {
        $member = new Members();
        if(!empty($data['memberid'])){
            $member->updateAll($data, 'memberid = :memberid', [':memberid' => $data['memberid']]);
            $memberId = $data['memberid'];
        }else{
            foreach ($data as $key => $val){
                $member->$key = $val;
            }
            $member->insert();
            $memberId = $member->memberid;
        }

        if($member->errors){
            //写日志
            Yii::error('SQL: ' . json_encode($member->errors) . '入库错误', __METHOD__);
        }
        return $memberId;
    }

    /**
     * 根据email获取用户信息
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-06-13
     * @param $email
     * @return array 返回数据
     */
    public function getMemberByEmail($email)
    {
        return Members::find()
            ->select('memberid, name, screenname, email, islite, register_date')
            ->asArray()
            ->where(['email' => $email])
            ->one();
    }

    /**
     * 无注册订购
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @copyright 2017-08-27
     * @param $request
     * @param $product
     * @return array
     * @throws \Exception
     */
    public function noRegisterBuy($request, $product){
        $email = $request['contactInfo']['emailAddress'];
        //查看这个email是否注册
        $row = $this->getMemberByEmail($email);
        //未注册
        if (!is_array($row) || $row['islite'] == 'Y' || $row['islite'] == "Q") {
            if ($row['islite'] == 'Y' || $row['islite'] == "Q") {//针对订阅用户
                $data = [
                    'memberid' => $row['memberid'],
                    'islite' => 'N',
                    'register_date' => $row['register_date'] ? $row['register_date'] : date('Y-m-d'),
                ];
                //更新
                $memberId = $this->saveMembers($data);
            }else{
                $data = [
                    "name" => $request['contactInfo']['fullName'],
                    "screenname" => explode('@', $email)[0],
                    "email" => $email,
                    "phone1" => $request['contactInfo']['phoneNumber'],
                    "password" => '',
                    "register_date" => date("Y-m-d"),
                    "memberlang" => Yii::$app->params['curLang'],
                    "registerIP" => !empty(Yii::$app->ip->realIP()) ? Yii::$app->ip->realIP() : '',
                    "authcode" => rand(100000, 999999),
                    "isactivated" => -1
                ];
                //插入
                $memberId = $this->saveMembers($data);
            }
            if($memberId) {
                $helper = new Helper();
                Yii::$app->cookies->setCookies("LuluUser", $helper->encrypt($memberId));
                Yii::$app->cookies->setCookies("LuluUserEmail", $helper->encrypt($email), 30);

                $row = $this->getMemberById($memberId);
                //发邮件
                $data = [];
                $data['name'] = !empty($row['name']) ? $row['name'] : '用户';
                $data['authcode'] = md5($row['authcode']);
                $data['memberid'] = $row['memberid'];
                $data['product'] = $product;
                Yii::$app->controller->layout = false;
                $body = Yii::$app->controller->render('@lulutrip/views/email/no-register-buy.html', $data);
                Yii::$app->mailer->compose('@common/mail/layout.html', ['content' => $body])->setTo([$email=>$row['screenname']])
                    ->setSubject('【路路行】请确认您的电子邮件地址，激活账户')->send();
                //发邮件 end

                //邮件记录器
                //Yii::$app->helper->crmSent($email, 'index_registeractivate', md5($email . time()));
                //无注册订购, 返回memberId
                return $memberId;
            }else{
                Yii::error('SQL: 入库失败，请联系管理员', __METHOD__);
                throw new \Exception('入库失败，请联系管理员', 500);
            }
        }else{
            //已注册
            throw new \Exception('已注册，需输入密码登录', 401);
        }
    }

    /**
     * 订购 - 快速登录
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @param $request
     * @return bool
     * @throws \Exception
     */
    public function quickLogin($request) {
        $row = Members::find()
            ->select('memberid, email, password')
            ->asArray()
            ->where("email = :email AND islite NOT IN ('Y', 'Q')", array(":email" => $request['email']))
            ->one();
        if(isset($row['memberid']) && $row['password'] == md5($request['password'])){
            $helper = new Helper();
            Yii::$app->cookies->setCookies("LuluUser", $helper->encrypt($row['memberid']));
            Yii::$app->cookies->setCookies("LuluUserEmail", $helper->encrypt($row['email']), 30);
            return true;
        }else{
            throw new \Exception('密码错误', 403);
        }
    }

}