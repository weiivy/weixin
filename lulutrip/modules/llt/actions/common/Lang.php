<?php
/**
 * 切换繁简
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\modules\llt\actions\common;

use yii\base\Action;
use Yii;

class Lang extends Action
{
    public function run()
    {
        $curLang = \Yii::$app->request->get('lang');
        if(!isset(Yii::$app->params['langs'][$curLang]))
        {
            return json_encode(array('status' => 0, 'msg' => 'ERROR LANG'));
        }
        Yii::$app->cookies->setCookies('CurrentLang', $curLang);
        return json_encode(array('status' => 1, 'msg' => 'success'));
    }
}