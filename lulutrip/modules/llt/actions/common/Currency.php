<?php
/**
 * 切换币种action
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\modules\llt\actions\common;

use yii\base\Action;
use Yii;

class Currency extends Action
{
    public function run()
    {
        $curCurrency = Yii::$app->request->get('currency');
        if(!isset(Yii::$app->params['currencies'][$curCurrency]))
        {
            return json_encode(array('status' => 0, 'msg' => 'ERROR CURRENCY'));
        }
        Yii::$app->cookies->setCookies('CurrentCurrency', $curCurrency);
        return json_encode(array('status' => 1, 'msg' => 'success'));
    }
}