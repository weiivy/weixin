<?php
/**
 * 标准化包团控制器
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\modules\llt\controllers;

use yii\web\Controller;

class PackageTourController extends Controller
{
    public function actions()
    {
        return [
            'price' => 'lulutrip\modules\llt\actions\packagetour\Price',
            'hot'   => 'lulutrip\modules\llt\actions\packagetour\Hot',
            'hotel' => 'lulutrip\modules\llt\actions\packagetour\Hotel',
            'feedback' => 'lulutrip\modules\llt\actions\packagetour\Feedback',
        ];
    }

}