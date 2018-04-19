<?php
/**
 * 查看发票
 * @copyright 2017-10-10
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\actions\order;
use yii\base\Action;
use api\models\Ordersum;
use common\models\Invoices;

class ViewInvoice extends Action
{
    public function run($orderId) {
        if (is_numeric($orderId)) {
            $order = Ordersum::findOne(['orderid' => $orderId]);
        } else {
            $order = Ordersum::findOne(['orderconf' => $orderId]);
        }

        $invoice = Invoices::findOne(['orderconf' => $order->orderconf]);
        $this->controller->layout = false;
        return $this->controller->render('invoice.html', [
            'order' => $order,
            'invoice' => $invoice
        ]);
    }
}