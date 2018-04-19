<?php
/**
 * @Copyright (c) 2017, lulutrip.com
 * @Author:  Ivy Zhang<ivyzhang@lulutrip.com>
 * @Summary: 跳转404页面action
 * @Date:    2017-02-09
 */
namespace lulutrip\actions\site;

use yii\base\Action;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class Error extends Action
{
    public function run()
    {
        $exception = \Yii::$app->errorHandler->exception;
        if ($exception instanceof NotFoundHttpException) {
            http_response_code(404);
        } else {
            http_response_code($exception->statusCode);
            echo 'An internal server error occurred.';
        }
    }
}