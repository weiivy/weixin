<?php

namespace lulutrip\controllers;

use yii\web\Controller;

/**
 * Class CpsController
 * @package lulutrip\controllers
 */
class CpsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'union' => 'lulutrip\actions\cps\Union'
        ];
    }
}