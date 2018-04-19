<?php
/**
 * 问答控制器
 * @copyright (c) 2017, lulutrip.com
 * @author  xiaopei Dou<xiaopei.dou@ipptravel.com>
 */
namespace lulutrip\modules\llt\controllers;

use yii\rest\Controller;

class QnaController extends Controller
{
    public function actions()
    {
        return [
            'tour' => 'lulutrip\modules\llt\actions\qna\Tour',
            'qna-submit' => 'lulutrip\modules\llt\actions\qna\qnaSubmit',
        ];
    }
}