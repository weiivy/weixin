<?php
/**
 * 列表页控制器
 * @copyright (c) 2017, lulutrip.com
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\llt\controllers;

use yii\web\Controller;

class TourListController extends Controller
{
    public function actions ()
    {
        return [
            'get-hot-top'               => 'lulutrip\modules\llt\actions\tourlist\GetHotTop',
            'get-sales'                 => 'lulutrip\modules\llt\actions\tourlist\GetSales',
            'get-top'                   => 'lulutrip\modules\llt\actions\tourlist\GetTop5',
        ];
    }

}