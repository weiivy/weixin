<?php
/**
 * 公共控制器
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\modules\llt\controllers;

use yii\web\Controller;

class CommonController extends Controller
{
    public function actions()
    {
        return [
            'currency'          => 'lulutrip\modules\llt\actions\common\Currency',
             'lang'             => 'lulutrip\modules\llt\actions\common\Lang',
            'get-history'       => 'lulutrip\modules\llt\actions\common\ProductHistory',
            'callmenow'         => 'lulutrip\modules\llt\actions\common\CallMeNow',
            'comparison'        => 'lulutrip\modules\llt\actions\common\Comparison',
            'crystal_ball_log'  => 'lulutrip\modules\llt\actions\common\CrystalBall',
            'getIsAlert'        => 'lulutrip\modules\llt\actions\common\getIsAlert',
            'SearchDownBox'     => 'lulutrip\modules\llt\actions\common\SearchDownBox',
            'get-keyword'       => 'lulutrip\modules\llt\actions\common\GetKeyword',
            'get-salers'        => 'lulutrip\modules\llt\actions\common\GeSalers',
            'get-phone-code'    => 'lulutrip\modules\llt\actions\common\GetPhoneAreaCode',
            'get-comparison'    => 'lulutrip\modules\llt\actions\common\GetComparison',
            'get-phone-list'    => 'lulutrip\modules\llt\actions\common\GetPhoneList',
            'get-phone'         => 'lulutrip\modules\llt\actions\common\GetPhone',
            'get-saler-list'    => 'lulutrip\modules\llt\actions\common\GetSalerList',
            'search-tour'       => 'lulutrip\modules\llt\actions\common\SearchTour',

        ];
    }

}