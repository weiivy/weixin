<?php
/**
 * 帮助类
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\components;

use linslin\yii2\curl\Curl;
use lulutrip\library\Seotdk;
use yii\base\Component;

class Helper extends Component
{
    public static $key = "llttll\0\0\0\0\0\0\0\0\0\0";//兼容 php 5.6

    /**
     * 加密用户id
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-02-07
     * @param $cookie
     * @return string
     */
    public static function encrypt($cookie) {
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $encryptText = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, self::$key, $cookie, MCRYPT_MODE_ECB, $iv);
        return trim(base64_encode($encryptText));

    }
    /**
     * 解密用户id
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-02-07
     * @param $cookie
     * @return string
     */
    public static function decrypt($cookie) {
        $cryptText = base64_decode($cookie);
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $decryptText = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, self::$key, $cryptText, MCRYPT_MODE_ECB, $iv);
        return trim($decryptText);
    }

    /**
     * 设置静态seo
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-02-09
     * @param $controller
     * @param $action
     * @param null $params
     */
    public static  function setSeo($controller, $action, $params = null)
    {
        $seoDtk = new Seotdk();
        list(\Yii::$app->controller->pageTitle, \Yii::$app->controller->pageKeywords, \Yii::$app->controller->pageDesc) = $seoDtk->setSeoTDK($controller, $action, $params);
    }

}