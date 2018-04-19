<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')

);

return [
    'id' => 'lulutrip',
    'language' => "zh-CN",
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'package-tour/home',
    'controllerNamespace' => 'lulutrip\controllers',
    'timeZone'=>'America/Los_Angeles',
    'components' => [
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'csrfParam' => '_csrf-lulutrip',
        ],

        'user' => [
            'class' => 'lulutrip\components\WebUser',
            /*'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],*/
        ],
        'cookies' => [
            'class' => 'lulutrip\components\Cookies',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require dirname(dirname(__DIR__)) . '/lulutrip/config/url_rule.php',
        ],
    ],
    'params' => $params,
];

