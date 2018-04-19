<?php

/**
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\actions\booking;
use yii\base\Action;
use Yii;
use lulutrip\modules\rentcar\library\booking\ShoppingData;
use lulutrip\modules\rentcar\library\booking\RentcarPrice;

class CountPrice extends Action
{
    public function run($shoppingId) {

        try {
            $shoppingData = new ShoppingData($shoppingId);
            $result = (new RentcarPrice)->getPrice($shoppingData);

            foreach ($result['totalAmounts'] as &$totalAmount) {
                $totalAmount['currency'] = Yii::$app->params['currencies'][$totalAmount['currency']];
            }

            $result['currency'] = Yii::$app->params['currencies'][$result['currency']];
            $result['setting'] = $shoppingData->setting;
            return ['rs' => 1, 'data' => $result, 'url' => Yii::$app->config->www . '/rental-car/order/' .  $shoppingId];
        } catch (\Exception $e) {
            return ['rs' => 0, 'code' => $e->getCode(), 'msg' => $e->getMessage()];
        }
    }
}