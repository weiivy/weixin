<?php

/**
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\library\rentcar;
use lulutrip\modules\rentcar\library\booking\ShoppingData;
use Yii;
use yii\base\Component;
use common\models\rentcar\RentCar;
use common\models\rentcar\RentCarLocation;
use common\models\rentcar\RentCarModelPrice;

class CarDetail extends Component
{
    /**
     * @copyright 2017-09-07
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @param ShoppingData $shoppingData
     * @return array|null|\yii\db\ActiveRecord
     */
    public function detail(ShoppingData $shoppingData) {
        $car = RentCar::find()->alias('c')
            ->select('c.id, c.title, c.car_model, cm.*')
            ->joinWith('rentCarModel cm')
            ->where("c.id = '{$shoppingData->carid}'")
            ->asArray()->one();
        unset($car['rentCarModel']);
        $default = $this->getModelPrice($car['car_model'],date('Y-m-d', strtotime($shoppingData->pickup_time)));
        $car['priceDay'] = $default['priceDay'];
        $car['priceDayLoss'] = $default['priceDayLoss'];
        $car['priceDayLossDuty'] = $default['priceDayLossDuty'];
        $car['priceWeek'] = $default['priceWeek'];
        $car['priceWeekLoss'] = $default['priceWeekLoss'];
        $car['priceWeekLossDuty'] = $default['priceWeekLossDuty'];
        return $car;
    }

    /**
     * 获取car_model_price
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-01-17
     * @param $car_model
     * @param $startDate
     * @return array
     */
    public function getModelPrice($car_model, $startDate) {
        $rentPrice = RentCarModelPrice::find()->select('*')->where('car_model = :car_model', ['car_model' => $car_model])->asArray()->all();
        if (empty($rentPrice)) return [];
        $key_id = 0;
        foreach ($rentPrice as $key => $var) {
            if (empty($var['starttime']) || empty($var['endtime'])) {
                $key_id = $key;
            }
            if ($var['starttime'] && $var['endtime'] && (($var['starttime'] <= $startDate) && ($var['endtime'] >= $startDate))) {
                $key_id = $key;
                break;
            }
        }
        $price = array(
            'priceDay' => $rentPrice[$key_id]['priceDay'],
            'priceDayLoss' => $rentPrice[$key_id]['priceDayLoss'],
            'priceDayLossDuty' => $rentPrice[$key_id]['priceDayLossDuty'],
            'priceWeek' => $rentPrice[$key_id]['priceWeek'],
            'priceWeekLoss' => $rentPrice[$key_id]['priceWeekLoss'],
            'priceWeekLossDuty' => $rentPrice[$key_id]['priceWeekLossDuty'],
        );
        return $price;
    }

    /**
     * @Summary 获取地点名称
     * @copyright 2017-09-07
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @param $id
     * @return mixed
     */
    public function getLocation($id) {
        $name = RentCarLocation::find()->select('agency_name')->where("id = '{$id}'")->asArray()->one()['agency_name'];
        return $name;
    }
}