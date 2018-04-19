<?php
/**
 * 标准化包团控制器
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\controllers;

use yii\web\Controller;

class PackageTourController extends Controller
{
    public $callmenowRegion;
    public $regionRoot;
    public $pageTitle;
    public $pageKeywords;
    public $pageDesc;
    public $_themeData;

    public function actions()
    {
        $this->layout = 'lulutrip';
        $this->callmenowRegion = 'NA';
        $this->regionRoot = 'NA';
        $this->_themeData = array(
            'csjs' => '城市精髓', 'mxxl' => '名校巡礼', 'ztly' => '主题乐园', 'gjgy' => '国家公园', 'rdhd' => '热带海岛', 'zrqj' => '自然奇景', 'whtq' => '文化探奇', 'glsy' => '公路摄影',);
        return [
            'index'  => 'lulutrip\actions\packagetour\Index',
            'home'  => 'lulutrip\actions\packagetour\Home',
            'entry' => 'lulutrip\actions\packagetour\Entry',
            'view'  => 'lulutrip\actions\packagetour\View',
            'ptour' => 'lulutrip\actions\packagetour\Ptour',
        ];
    }

}