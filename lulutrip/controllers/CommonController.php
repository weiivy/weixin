<?php
/**
 * 公共控制器
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\controllers;

use yii\web\Controller;

class CommonController extends Controller
{
    public function actions()
    {
        return [
            'currency'          => 'lulutrip\actions\common\Currency',
             'lang'             => 'lulutrip\actions\common\Lang',
            'get-history'       => 'lulutrip\actions\common\ProductHistory',
            'callmenow'         => 'lulutrip\actions\common\CallMeNow',
            'comparison'        => 'lulutrip\actions\common\Comparison',
            'crystal_ball_log'  => 'lulutrip\actions\common\CrystalBall',
            'getIsAlert'  => 'lulutrip\actions\common\getIsAlert'
        ];
    }

}