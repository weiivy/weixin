<?php
/**
 * @copyright (c) 2017, lulutrip.com
 * @author LT<todd@lulutrip.com>
 */
namespace lulutrip\controllers;
use yii\web\Controller;

class CruiseController extends Controller
{
    public $pageTitle;
    public $callmenowRegion;
    public $regionRoot;
    public $pageKeywords;
    public $pageDesc;

    public function actions()
    {
        $this->layout = 'lulutrip';
        $this->callmenowRegion = 'NA';
        $this->regionRoot = 'NA';

        return [
            'index'  => 'lulutrip\actions\cruise\Index',
            'search' => 'lulutrip\actions\cruise\SearchCruise',
            'view' => 'lulutrip\actions\cruise\View',
            'select_num' => 'lulutrip\actions\cruise\SelectNum',
            'select_cabincategory' => 'lulutrip\actions\cruise\SelectCabincat',
            'select_cabin' => 'lulutrip\actions\cruise\SelectCabin',
            'add_to_cart' => 'lulutrip\actions\cruise\AddToCart',
            'get_deal' => 'lulutrip\actions\cruise\GetDeal',
            'get_search_total' => 'lulutrip\actions\cruise\GetSearchTotal'
        ];
    }
}