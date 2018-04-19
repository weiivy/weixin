<?php
/**
 * cookie组件
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\components;

use yii\base\Component;

class Cookies extends Component
{
    public static $key = "llttll\0\0\0\0\0\0\0\0\0\0";//兼容 php 5.6 by todd

    //cookie 加密
    public static function encrypt($cookie) {
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $encryptText = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, self::$key, $cookie, MCRYPT_MODE_ECB, $iv);
        return trim(base64_encode($encryptText));

    }
    //cookie 解密
    public static function decrypt($cookie) {
        $cryptText = base64_decode($cookie);
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $decryptText = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, self::$key, $cryptText, MCRYPT_MODE_ECB, $iv);
        return trim($decryptText);
    }

    /**
     * 设置cookie
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-02-15
     * @param $name
     * @param $value
     * @param int $expire
     * @param string $path
     */
    public function setCookies($name, $value, $expire = 1, $path = '/')
    {
        setcookie($name, $value, time() + $expire * 24 * 3600, $path, DOMAIN_NAME);
    }

    /**
     * 根据$key 获取$key值
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-02-16
     * @param $key
     * @param null $default  默认值
     *
     * @return string 返回数据
     */
    public function getCookies($key, $default = null)
    {
        if(isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        }

        return $default;
    }

    /**
     * 检查值是否存在
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-02-16
     * @param $key
     *
     * @return bool
     */
    public function getCheckExists($key)
    {
        return isset($_COOKIE[$key]);
    }
    //注销cookie
    public function clearCookies($name, $path = '/') {
        unset($_COOKIE[$name]);
        @setcookie($name, "", -1, $path, DOMAIN_NAME);
    }
}