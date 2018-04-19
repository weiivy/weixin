<?php
/**
 * 旅行团列表页控制器
 * @copyright (c) 2017, lulutrip.com
 * @author  Serena Liu<serena.liu@ipptravel.com>
 */
namespace lulutrip\modules\tour\controllers;

use yii;
use yii\web\Controller;

class TourListController extends BaseController
{
    public $regionRoot = 'NA';
    public $staticUrl;

    public function init()
    {
        parent::init();
//        $this->layout = '@channelModule/views/layouts/main';
//        $this->staticUrl = Yii::$app->params['staticDomain'] . "/lulutrip/" . Yii::$app->params['front_version'] . "/dist/pages/";
    }

    public function actions()
    {
        return [
            'list' => 'lulutrip\modules\tour\actions\tourlist\Lists',
        ];
    }
}