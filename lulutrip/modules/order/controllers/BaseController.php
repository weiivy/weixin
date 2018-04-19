<?php
/**
 * base 控制器
 * @copyright (c) 2017, lulutrip.com
 * @author  Serena Liu<serena.liu@ipptravel.com>
 */

namespace lulutrip\modules\order\controllers;

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
        $this->layout = '@orderModule/views/layouts/main.html';
        $this->staticUrl = Yii::$app->params['staticDomain'] . "/lulutrip/".Yii::$app->params['front_version']."/dist/pages/";

        return parent::beforeAction($action);
    }

}