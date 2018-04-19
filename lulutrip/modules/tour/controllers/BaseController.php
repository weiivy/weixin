<?php
/**
 * Created by PhpStorm.
 * User: zhangweiwei
 * Date: 17/7/10
 * Time: 下午2:48
 */

namespace lulutrip\modules\tour\controllers;

use yii\web\Controller;
use Yii;

class BaseController extends Controller
{
    public $layout;
    public $pageTitle;
    public $pageKeywords;
    public $pageDesc;
    public $regionRoot;
    public $staticUrl;

    public function beforeAction($action)
    {
        $this->layout = '@channelModule/views/layouts/main';
        $this->staticUrl = Yii::$app->params['staticDomain'] . "/lulutrip/".Yii::$app->params['front_version']."/dist/pages/";

        return parent::beforeAction($action);
    }

}