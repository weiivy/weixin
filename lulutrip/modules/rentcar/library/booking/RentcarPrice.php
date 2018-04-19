<?php
/**
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\library\booking;
use yii\base\Component;
use Yii;
use lulutrip\modules\rentcar\library\booking\ShoppingData;
use lulutrip\modules\rentcar\library\booking\OptionalProject;
use common\models\rentcar\RentCarReturnFee;
use api\library\Help;

class RentcarPrice extends Component
{
    /**
     * 费用明细
     * @copyright 2017-09-07
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @param \lulutrip\modules\rentcar\library\booking\ShoppingData $shoppingData
     * @return  array
     */
    public function getPrice(ShoppingData $shoppingData) {
        $daylen = ceil((strtotime($shoppingData->return_time) - strtotime($shoppingData->pickup_time)) / 86400);
        $car['totalAmount'] = $this->carPrice($shoppingData->cars, $daylen, $shoppingData->pickup_location, $shoppingData->return_location, $shoppingData->insurance);
        $optionalProject = $this->optionalPrice($shoppingData->optionalids, $daylen);
        $data['inventors']['car']['totalAmount'] = $car['totalAmount'];
        $data['totalAmount'] = $car['totalAmount'];
        if (!empty($optionalProject)) {
            $data['inventors']['optionalProject'] = $optionalProject;
            $data['totalAmount'] += $optionalProject['totalAmount'];
        }
        $currencies = Yii::$app->params['currencies'];
        $curCurrency = Yii::$app->params['curCurrency'];
        foreach ($currencies as $val) {
            if ($val['code'] == $curCurrency) {
                $data['currency'] = $val['code'];
            }
            $data['totalAmounts'][] = array(
                'amount' => Help::fmtPrice($data['totalAmount'], $curCurrency)[$val['code']],
                'currency' => $val['code']
            );
        }
        return $data;
    }

    /**
     * 租车总价格
     * @copyright 2017-09-07
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @param $cars
     * @param $daylen
     * @param $pickup_location
     * @param $return_location
     * @param $insurance
     * @return float|int
     */
    public function carPrice($cars, $daylen, $pickup_location, $return_location, $insurance) {
        $week = floor($daylen / 7);
        $day = $daylen % 7;
        $price = 0;
        if ($insurance == 1) {
            $price = $week * 7 * $cars['priceWeek'] + $day * $cars['priceDay'];
        } else if($insurance == 2) {
            $price = $week * 7 * $cars['priceWeekLoss'] + $day * $cars['priceDayLoss'];
        } else if ($insurance == 3) {
            $price = $week * 7 * $cars['priceWeekLossDuty'] + $day * $cars['priceDayLossDuty'];
        }
        //异地还车费
        $location_fee = $this->getLocationPrice($pickup_location, $return_location);
        $price += $location_fee;
        $price = Help::fmtPrice($price, 'USD');
        return $price[Yii::$app->params['curCurrency']];
    }

    /**
     * 计算异地还车费
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-09-07
     * @param $pickup_location
     * @param $return_location
     * @return int
     */
    public function getLocationPrice($pickup_location, $return_location) {
        if ($pickup_location == $return_location) return 0;
        $fee = RentCarReturnFee::find()->select('*')->where('pickup_location = :pickup and return_location = :return', ['pickup' => $pickup_location, 'return' => $return_location])->asArray()->one();
        if (empty($fee)) {
            $fee = RentCarReturnFee::find()->select('*')->where('pickup_location = :pickup and return_location = :return', ['pickup' => $return_location, 'return' => $pickup_location])->asArray()->one();
        }
        return $fee['return_fee'];
    }

    /**
     * 自选项目价格清单
     * @copyright 2017-09-07
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @param $optionalids
     * @param $daylen
     * @return array
     */
    public function optionalPrice($optionalids, $daylen) {
        $optional = (new OptionalProject)->getOptional()['items'];
        $items = [];
        if (!empty($optionalids)) {
            $optionals = explode(',', $optionalids);
            $totalPrice = 0;
            foreach ($optionals as $val) {
                $price = $optional[$val]['price'] * $daylen;
                if ($price >= $optional[$val]['priceCaps']) $price = $optional[$val]['priceCaps'];
                $totalPrice += $price;
                $items['items'][] = array(
                    'itemId' => $optional[$val]['id'],
                    'amount' => $price,
                    'displayName' => $optional[$val]['name'],
                );
            }
            $items['totalAmount'] = $totalPrice;
        }
        return $items;
    }
}