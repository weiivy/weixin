<?php
/**
 * 用户信息类
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\components;

use yii\web\User;
use linslin\yii2\curl\Curl;
use lulutrip\library\recording\Record;

class WebUser extends User
{
    /**
     * @var array 登录地址
     */
    public $loginUrl = ['user/login'];

    public $current_user = [];
    public $id;
    public $toArray;
    public $isGuest;

    public function init()
    {
        $this->getCurrentUser();
        if(isset($this->current_user['memberid'])) {
            $this->id      = $this->current_user['memberid'];
            $this->isGuest = false;
            $this->identity = \common\models\User::findOne(['memberid' => $this->id]);
        } else {
            $this->isGuest = true;
        }
    }
    /**
     * 获取当前登录用户信息
     * @author Serena Liu<serena@lulutrip.com>
     * @copyright 2017-02-07
     * @return array
     */
    public function getCurrentUser()
    {
        if (!isset($_COOKIE['LuluUser'])) {
            return null;
        }
        $helper = new Helper();
        $memberid = $helper->decrypt($_COOKIE['LuluUser']);
        $curl = new Curl();
        $result = $curl->get(\Yii::$app->params['service']['api'] . "/member/get-info/" . $memberid);
        $return = json_decode($curl->response, true);
        $this->current_user = $return['data'];

        $record = new Record;
        //检查用户是否登陆  将浏览数据导入mdc
        if($this->isGuest === false) {
            $record->attributeWriteForMdc(\Yii::$app->user->toArray);
        }
        $this->current_user['LuluUserClass'] = $this->getUserClass($this->current_user['luluamount'], $this->current_user['black_diamond']);
        return $this->current_user;
    }
    /**
     * 计算用户等级，从去年1.1截止到今天的消费金额达到升级条件，默认是美金
     * @author Serena Liu<serena@lulutrip.com>
     * @copyright 2017-02-07
     * @param $amount  积分
     * @param $black_diamond  等级
     * @return array
     */
    public function getUserClass($amount, $black_diamond)
    {
        include(__DIR__ . "/../data/userprivilege.php");
        if ($black_diamond == 1){
            $class = 4;
            $class_name = "黑钻会员";
            $points_double = 2;
            $msg = "谢谢！您是我们的黑钻卡会员，请继续支持我们～";
        } else if ($amount >= 10000){
            $class = 3;
            $class_name = "钻石卡会员";
            $points_double = 2;
            $msg = "谢谢！您是我们的钻石卡会员，请继续支持我们～";
        } else if ($amount >= 5000 ) {
            $class = 2;
            $class_name = "金卡会员";
            $points_double = 1.5;
            $msg = "加油！ 再消费 <span>$".(10000 - $amount)."</span>可升级为钻石卡会员哦～";
        } else if ($amount >= 1500 ) {
            $class = 1;
            $class_name = "银卡会员";
            $points_double = 1.25;
            $msg = "加油！ 再消费<span> $".(5000 - $amount)."</span>可升级为金卡会员哦～";
        } else {
            $class = 0;
            $class_name = "普通会员";
            $points_double = 1;
            $msg = "加油！ 再消费<span> $".(1500 - $amount)."</span>可升级为银卡会员哦～";
        }
        foreach ($privilege[$class] as $cls){
            $pre[$cls] = $userprivilege[$cls];
        }
        //升级可增加特权
        $pre_add = array();
        if ($class < 3) {
            $pre_add_class = array_diff($privilege[$class+1], $privilege[$class]);
            foreach ($pre_add_class as $cls_key => $cls_add){
                $pre_add[$cls_add] = $userprivilege[$cls_add];
            }
        }
        $user_class = array('class'=>$class, 'class_name'=>$class_name, 'points_double' => $points_double, 'msg' => $msg, 'privilege' => $pre, 'privilege_add' => $pre_add);
        return $user_class;
    }
}