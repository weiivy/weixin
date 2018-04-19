<?php

/**
 * 柯信租车
 * @author Justin Jia<justin.jia@ipptravel.com>
 * @copyright 2017-09-25
 */

namespace lulutrip\modules\rentcar\controllers;
use yii\web\Controller;
use Yii;

class RentalController extends Controller
{
    public $callmenowRegion;
    public $regionRoot;
    public $pageTitle;
    public $pageKeywords;
    public $pageDesc;
    public $staticUrl;
    public function actions() {
        $this->layout = '@lulutrip/views/layouts/lulutrip.php';
        $this->callmenowRegion = 'NA';
        $this->pageTitle = '中文租车 海外当地7*24中文租车服务';
        $this->pageKeywords = '';
        $this->pageDesc = '中文取车服务中文司机机场接送到店,中文贴心服务驾照翻译、车险购买一站式服务,中文检车服务现场陪同检车全中文讲解,中文交规指导现场学习交规全中文讲解';
        $this->regionRoot = 'NA';
        $this->staticUrl = Yii::$app->params['staticDomain'] . "/lulutrip/".Yii::$app->params['front_version']."/dist/pages/";
        return [
            'entry' => 'lulutrip\modules\rentcar\actions\rental\Entry',
        ];
    }
}