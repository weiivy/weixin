<?php

/**
 * 个性化定制产品
 * @copyright (c) 2017, lulutrip.com
 * @author Justin Jia<justin.jia@ipptravel.com>
 */
namespace lulutrip\modules\customized\controllers;
use yii\web\Controller;

class CustomizedController extends Controller
{
    public $callmenowRegion;
    public $regionRoot;
    public $pageTitle;
    public $pageKeywords;
    public $pageDesc;

    public function actions () {
        $this->layout = '@lulutrip/views/layouts/lulutrip.php';
        $this->callmenowRegion = 'NA';
        $this->regionRoot = 'NA';
        return [
            'entry' => 'lulutrip\modules\customized\actions\customized\Entry'
        ];
    }
}
