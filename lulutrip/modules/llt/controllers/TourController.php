<?php
/**
 * 旅行团售罄 预定表单提交控制器
 * @copyright (c) 2017, lulutrip.com
 * @author  xiaopei Dou<xiaopei.dou@ipptravel.com>
 */
namespace lulutrip\modules\llt\controllers;

use yii\rest\Controller;

class TourController extends Controller
{
    public function actions()
    {
        return [
            'booking-form-submit' => 'lulutrip\modules\llt\actions\tour\bookingFormSubmit',
        ];
    }
}