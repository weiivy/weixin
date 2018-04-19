<?php
/**
 * 评论控制器
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\modules\llt\controllers;

use yii\web\Controller;

class CommentController extends Controller
{
    public function actions()
    {
        return [
            'package-tour' => 'lulutrip\modules\llt\actions\comment\PackageTour',
            'tour' => 'lulutrip\modules\llt\actions\comment\Tour',
        ];
    }
}