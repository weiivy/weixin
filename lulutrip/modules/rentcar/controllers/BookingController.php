<?php
/**
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\controllers;
use yii\rest\Controller;
use Yii;

class BookingController extends Controller
{
    public function actions() {
        return [
            'count-price'       => 'lulutrip\modules\rentcar\actions\booking\CountPrice',
            'get-promotions'    => 'lulutrip\modules\rentcar\actions\booking\GetPromotions',
            'use-promotion'     => 'lulutrip\modules\rentcar\actions\booking\UsePromotion',
            'delete-promotion'  => 'lulutrip\modules\rentcar\actions\booking\DeletePromotion',
        ];
    }
}