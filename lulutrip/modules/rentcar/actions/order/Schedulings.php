<?php
/**
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\actions\order;
use lulutrip\modules\rentcar\library\booking\ShoppingData;
use lulutrip\modules\rentcar\library\booking\OptionalProject;
use lulutrip\modules\rentcar\library\rentcar\CarDetail;
use Yii;
use yii\base\Action;

class Schedulings extends Action
{
    public function run($shoppingId) {
        //产品信息
        $data['order'] = $this->rentCar($shoppingId);
        //自选项目
        $data['optionalProject'] = (new OptionalProject)->getOptional();
        $shoppingData = new ShoppingData($shoppingId);
        $data['selectOptional'] = explode(',' ,$shoppingData->optionalids);
        Yii::$app->params['formData'] = $shoppingData->formData;
        Yii::$app->controller->pageTitle = '租车下单页-自选项目';
        return $this->controller->render("scheduling/index.html", array('data' => $data, 'shoppingId' => $shoppingId));
    }

    /**
     * 产品信息
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-09-07
     * @param $shoppingId
     * @return array
     */
    public function rentCar($shoppingId) {

        $shoppingData = new ShoppingData($shoppingId);
        $car = (new CarDetail)->detail($shoppingData);
        $shoppingData->cars = $car;
        $shoppingData->currency = Yii::$app->params['curCurrency'];
        $shoppingData->save();
        $daylen = ceil((strtotime($shoppingData->return_time) - strtotime($shoppingData->pickup_time)) / 86400);
        $data = [
            'carid' => $car['id'],
            'carinfo' => $car['make'] . ',' . $car['model'] . ',' . $car['year'],
            'carname' => $car['title'],
            'daylen' => $daylen,
            'insurance' => $shoppingData->insurance,
            'luggage' => $car['luggage'],
            'seats' => $car['seats'],
            'pickup_time' => $shoppingData->pickup_time,
            'return_time' => $shoppingData->return_time,
            'pickup_location' => $shoppingData->pickup_location,
            'return_location' => $shoppingData->return_location,
            'pickup_location_name' => (new CarDetail)->getLocation($shoppingData->pickup_location),
            'return_location_name' => (new CarDetail)->getLocation($shoppingData->return_location),
        ];
        unset($car);
        return $data;
    }
}