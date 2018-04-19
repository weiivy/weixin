<?php

/**
 * @copyright (c) 2017, lulutrip.com
 * @author  martin ren<martin@lulutrip.com>
 */

namespace  lulutrip\event;

use lulutrip\components\Cookies;
use Yii;
use yii\base\Event;

class Common extends Event
{
    /**
     * 获取购物车数量
     * @author Serena Liu<serena@lulutrip.com>
     * @copyright 2017-02-07
     * @return array
     */
    public static function getCartNum()
    {
        Yii::$app->params['cartNum'] = (int)(new Cookies())->getCookies('LuluOrderNum');
        return true;
        /*
        $cart_num = 0;
        if (!empty($_SESSION['LuluOrder'])) {
            foreach ((array) $_SESSION['LuluOrder'] as $value) {
                if ($value['subject'] != 'promotion' && $value['subject'] != '') {
                    $cart_num ++;
                }
            }
        }
        Yii::$app->params['cartNum'] = $cart_num;
        return true;
        */
    }
    /**
     * 设置语言 币种
     * @author Serena Liu<serena@lulutrip.com>
     * @copyright 2017-02-07
     * @return array
     */
    public static function setLangCurrency(Event $event)
    {
        //根据Ip获取当前的语言获取区域
        $location = Yii::$app->ip->matchArea(Yii::$app->ip->realIP());
        Yii::$app->params['IPArea'] = $location['area'];
        //cookie设置当前语言 区域
        Yii::$app->cookies->setCookies("CurrentLocation", $location['area'], 30);
        $curLang = Yii::$app->request->get('lang');
        $cookieLang = Yii::$app->cookies->getCookies('CurrentLang');
        if(array_key_exists($curLang, Yii::$app->params['langs']))
        {
            Yii::$app->cookies->setCookies("CurrentLang", $curLang, 30);
        }
        elseif(array_key_exists($cookieLang, Yii::$app->params['langs']))
        {
            $curLang = $cookieLang;
        }
        else
        {
            $curLang = $location['lang'];
            Yii::$app->cookies->setCookies("CurrentLang", $curLang, 30);
        }
        Yii::$app->params['curLang'] = $curLang;
        //cookie设置当前语言 区域 结束

        //cookie设置当前货币
        $curCurrency = Yii::$app->cookies->getCookies('CurrentCurrency');
        if(!array_key_exists($curCurrency, Yii::$app->params['currencies']))
        {
            $curCurrency = $location['currency'];
            Yii::$app->cookies->setCookies("CurrentCurrency", $curCurrency, 30);
        }
        Yii::$app->params['curCurrency'] = $curCurrency;
        Yii::$app->params['curCurrencies'] = Yii::$app->params['currencies'][$curCurrency];
        //cookie设置当前货币 结束
        return true;
    }
}