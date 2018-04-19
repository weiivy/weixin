<?php

namespace lulutrip\modules\order\actions\payment;

use yii\base\Action;
use yii\web\NotFoundHttpException;
use common\models\Ordersum;

/**
 * 支付结果
 * @copyright (c) 2017, lulutrip.com
 * @author  Victor Tang<victor.tang@ipptravel.com>
 */
class Result extends Action
{
    /**
     * @var ga使用参数
     */
    public $gaParams;
    public function run($merchantOrderCD, $result)
    {
        $order = Ordersum::findOne(['orderconf' => $merchantOrderCD]);
        if (empty($order)) {
            throw new NotFoundHttpException("Order {$merchantOrderCD} Not Exists");
        }
        $this->gaParams['orderId'] = $order->orderid;
        $this->gaParams['result'] = $result;
        $this->gaParams['totalAmount'] = \Yii::$app->request->get('amount');
        $this->gaParams['currency'] = \Yii::$app->request->get('currency');

        $contactInfo = json_decode($order->contact_info);
        $emailAddress = $contactInfo->emailAddress;

        if ($result == 'SUCCESS') {
            $this->controller->pageTitle = '路路行下单页-支付成功';
            return $this->controller->render("success/index.html", [
                'merchantOrderCD' => $merchantOrderCD,
                'emailAddress' => $emailAddress
            ]);
        } else {
            $this->controller->pageTitle = '路路行下单页-支付失败';
            return $this->controller->render("failure/index.html", [
                'merchantOrderCD' => $merchantOrderCD
            ]);
        }
    }
} 