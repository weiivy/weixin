<?php

namespace lulutrip\modules\llt\controllers;

use yii\rest\Controller;
use common\components\Captcha;
use Gregwar\Captcha\CaptchaBuilder;

/**
 * Class CaptchaController
 * @package lulutrip\controllers
 * @author Victor Tang<victor.tang@ipptravel.com>
 * @copyright (c) 2017, lulutrip.com
 */
class CaptchaController extends Controller {

    public $modelClass = '';

    /**
     * 获取验证码
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-14
     * @param int $width 验证码图片长度，默认150px
     * @param int $height 验证码图片宽度，默认40px
     */
    public function actionIndex($width = 150, $height = 40) {
        $captchaCode = Captcha::generate();
        $builder = new CaptchaBuilder($captchaCode);
        $builder->build($width, $height);

        header('Content-type: image/jpeg');
        echo $builder->output();
        exit();
    }

    /*
     * 检测验证码
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-15
     * @param string $authcode 验证码
     */
    public function actionCheckAuthcode() {
        $authcode = \Yii::$app->request->get('code');
        if (Captcha::check($authcode)) {
            $res = array('flg' => 'OK', 'msg' => '');
        }else{
            $res = array('flg' => 'CODEERR', 'msg' => '验证码错误');
        }

        return $res;
    }


}