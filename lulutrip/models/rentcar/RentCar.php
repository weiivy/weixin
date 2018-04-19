<?php

namespace lulutrip\models\rentcar;

/**
 * RentCar
 * @copyright (c) 2018, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
class RentCar extends \common\models\rentcar\RentCar
{
    public function getCarModel()
    {
        return $this->hasOne(RentCarModel::className(), ['id' => 'car_model']);
    }
} 