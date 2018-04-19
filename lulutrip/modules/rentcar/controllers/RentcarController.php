<?php

/**
 * 柯信租车
 * @author Justin Jia<justin.jia@ipptravel.com>
 * @copyright 2017-08-25
 */

namespace lulutrip\modules\rentcar\controllers;
use yii\web\Controller;
use Yii;

class RentcarController extends Controller
{
    public $callmenowRegion;
    public $regionRoot;
    public $pageTitle;
    public $pageKeywords;
    public $pageDesc;
    public function actions() {
        $this->layout = '@lulutrip/views/layouts/lulutrip.php';
        $this->callmenowRegion = 'NA';
        $this->pageTitle = '租车详情页入口';
        $this->pageKeywords = '';
        $this->pageDesc = '';
        $this->regionRoot = 'NA';
        return [
            'view'          => 'lulutrip\modules\rentcar\actions\rentcar\GetView',
            'price'         => 'lulutrip\modules\rentcar\actions\rentcar\GetPrice',
            'count-price'   => 'lulutrip\modules\rentcar\actions\rentcar\CountPrice',
        ];
    }
}