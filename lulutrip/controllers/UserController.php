<?php

namespace lulutrip\controllers;

/**
 * Class UserController
 * @package lulutrip\controllers
 */
class UserController extends \yii\web\Controller {
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'login-from-woqu' => 'lulutrip\actions\user\LoginFromWoqu'
        ];
    }
}