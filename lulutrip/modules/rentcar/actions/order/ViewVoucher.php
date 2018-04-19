<?php
/**
 * 查看电子凭证
 * @copyright 2017-10-10
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\actions\order;
use api\models\Ordersum;
use common\models\rentcar\RentCarLocation;
use yii\base\Action;
use Yii;
use linslin\yii2\curl\Curl;

class ViewVoucher extends Action
{
    public function run($orderId) {
        if (is_numeric($orderId)) {
            $order = Ordersum::findOne(['orderid' => $orderId]);
        } else {
            $order = Ordersum::findOne(['orderconf' => $orderId]);
        }
        $orderRentcar = $order->orderRentcar;
        $operators = $orderRentcar->operators;
        $passenger = $orderRentcar->orderRentcarPassenger;
        $item = $orderRentcar->orderRentcarProduct;
        $insurance = ['1' => '无保险', '2' => '车辆盗抢险', '3' => '车辆盗抢险 + 第三者责任险'];
        $location = $this->getLocation();

        $priview = Yii::$app->request->get('preview', 0);
        if ($priview == 1) {
            $key = Yii::$app->request->get('key');
            $voucher = Yii::$app->cache->get($key)['voucher'];
        } else {
            $voucher = $orderRentcar->voucher;
        }
        $this->controller->layout = false;
        return $this->controller->render('voucher.html', [
            'order' => $order,
            'orderRentcar' => $orderRentcar,
            'operators' => $operators,
            'passenger' => $passenger,
            'item' => $item,
            'insurance' => $insurance,
            'location' => $location,
            'voucher' => $voucher,
            'flightInfo' => $orderRentcar->flightInfo
        ]);
    }

    /**
     * 获取地址
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-10-10
     */
    public function getLocation() {
        $location = RentCarLocation::find()->select('*')->asArray()->all();
        $location2 = [];
        foreach ($location as $local) {
            $location2[$local['id']] = $local;
        }
        return $location2;
    }
}