<?php
/**
 * 路路行小众
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\controllers;

use yii\web\Controller;
use lulutrip\components\Helper;

class AggregationController extends Controller
{
    public $pageTitle;
    public $pageKeywords;
    public $pageDesc;
    public $regionRoot;

    public function beforeAction($action)
    {
        if($action->region == 'eu') {
            Helper::setSeo('aggregation', 'index_EU');
        } else {
            Helper::setSeo('aggregation', 'index');
        }
        return parent::beforeAction($action);
    }

    public function actions()
    {
        $this->layout = 'lulutrip';

        return [
            'index' => ['class' => 'lulutrip\actions\aggregation\Index'],
            'index_eu' => ['class' => 'lulutrip\actions\aggregation\Index', 'region' => 'eu']
        ];
    }
} 