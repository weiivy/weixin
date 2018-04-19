<?php

namespace lulutrip\modules\order\controllers;

use api\modules\order\library\Email;
use yii\filters\AccessControl;
use common\models\Ordersum;
use common\models\TourLocalPickup;
use common\models\VoucherFlightInfo;
use Curl\Curl;
use lulutrip\models\Invoices;
use yii\web\Controller;
use Yii;

/**
 * Class OrderController
 * @copyright (c) 2017, lulutrip.com
 * @author  Victor Tang<victor.tang@ipptravel.com>
 * @package lulutrip\modules\order\controllers
 */
class OrderController extends Controller {
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view-voucher', 'view-invoice'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['view-voucher', 'view-invoice'],
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view-voucher', 'view-invoice'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->request->get('accessKey') or Yii::$app->request->get('emailAccessKey') ? true : false;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * 检查权限
     * @author  Victor Tang<victor.tang@ipptravel.com>
     * @param Ordersum $order
     * @return bool
     */
    private function _checkPermissions(Ordersum $order) {
        // 从邮箱打开
        if (isset($_GET['emailAccessKey'])) {
            $emailAccessKey = $_GET['emailAccessKey'];

            if ($emailAccessKey == Email::getEmailAccessKey($order)) {
                return true;
            } else {
                return false;
            }
        }

        // 从后台查看
        if (isset($_GET['accessKey'])) {
            $accessKey = $_GET['accessKey'];

            $curl = new Curl();
            $curl->get(API_BASE . '/auth/check?accessKey=' . $accessKey);
            $result = $curl->response;

            if ($result->role == 'admin' && $result->expire >= time()) {
                return true;
            } else {
                echo '<script>alert("你的权限已过期，请从后台重新打开")</script>';
                exit();
            }
        }

        if ($order->memberid == Yii::$app->user->current_user['memberid']) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 查看电子凭证
     * @author  Victor Tang<victor.tang@ipptravel.com>
     * @param $orderId
     * @param $preview
     * @return string
     */
    public function actionViewVoucher($orderId, $preview = false) {
        if (is_numeric($orderId)) {
            $order = Ordersum::findOne(['orderid' => $orderId]);
        } else {
            $order = Ordersum::findOne(['orderconf' => $orderId]);
        }

        if (!$this->_checkPermissions($order)) {
            throw new \Exception("你没有权限查看{$order->orderconf}电子凭证");
        }

        $booking = $order->booking;
        $supplier = $booking->supplier;
        $rooms = $booking->rooms;
        $passengers = [];
        foreach ($rooms as $room) {
            $passengers[] = $room->passengers;
        }
        //客服电话
        $serviceTel = Yii::$app->helper->curlPost(Yii::$app->params['service']['api'] . '/admin/base/phone/list');

        $voucher = $booking->voucher;
        $pickup = $booking->pickup ? $booking->pickup : new TourLocalPickup();
        $flightInfo = $booking->flightInfo;

        // 凭证预览
        if ($preview) {
            $previewData = Yii::$app->redisShared->get("voucher-preview-{$orderId}");
            $voucher->operator_confirm_code = $previewData['voucher']['operator_confirm_code'];
            $voucher->tour_guide_info = $previewData['voucher']['tour_guide_info'];
            $voucher->pickup_remark = $previewData['voucher']['pickup_remark'];
            $voucher->dropoff_remark = $previewData['voucher']['dropoff_remark'];
            $voucher->pickup_notes = $previewData['voucher']['pickup_notes'];
            $voucher->tour_remark = $previewData['voucher']['tour_remark'];
            if (isset($previewData['voucher']['tourin_notes'])) {
                $voucher->tourin_notes = $previewData['voucher']['tourin_notes'];
            }
            $voucher->priceincludes = $previewData['voucher']['priceincludes'];
            $voucher->pricenotincludes = $previewData['voucher']['pricenotincludes'];
            $voucher->tournotes = $previewData['voucher']['tournotes'];
            foreach ($rooms as $room) {
                foreach ($previewData['rooms'] as $previewRoom) {
                    if ($room->tourroomidx == $previewRoom['tourroomidx']) {
                        $room->remark = $previewRoom['remark'];
                    }
                }
            }

            if (isset($previewData['voucher']['pickup_info'])) {
                $pickup->pickup_time = $previewData['voucher']['pickup_info']['time'];
                $pickup->pickup_city = $previewData['voucher']['pickup_info']['city'];
                $pickup->pickup_point = $previewData['voucher']['pickup_info']['location'];
                $pickup->pickup_address = $previewData['voucher']['pickup_info']['address'];
            }

            if (isset($previewData['inflight'], $previewData['outflight'])) {
                if (!$flightInfo) {
                    $flightInfo = new VoucherFlightInfo();
                }
                $flightInfo->in_flight = $previewData['inflight'];
                $flightInfo->out_flight = $previewData['outflight'];
            }
        }

        $this->layout = false;
        return $this->render('voucher.html', [
            'order' => $order,
            'booking' => $booking,
            'supplier' => $supplier,
            'rooms' => $rooms,
            'passengers' => $passengers,
            'voucher' => $booking->voucher,
            'serviceTel' => isset($serviceTel['data']) ? $serviceTel['data'] : array(),
            'telDefault' => isset($serviceTel['default']) ? $serviceTel['default'] : array(),
            'voucher' => $voucher,
            'pickup' => $pickup,
            'flightInfo' => $flightInfo
        ]);
    }

    /**
     * 查看电子发票
     * @author  Victor Tang<victor.tang@ipptravel.com>
     * @param $orderId
     * @return string
     */
    public function actionViewInvoice($orderId) {
        if (is_numeric($orderId)) {
            $order = Ordersum::findOne(['orderid' => $orderId]);
        } else {
            $order = Ordersum::findOne(['orderconf' => $orderId]);
        }

        if (!$this->_checkPermissions($order)) {
            throw new \Exception("你没有权限查看{$order->orderconf}电子发票");
        }

        $invoice = Invoices::findOne(['orderconf' => $order->orderconf]);

        //客服电话
        $serviceTel = Yii::$app->helper->curlPost(Yii::$app->params['service']['api'] . '/admin/base/phone/list');
        $this->layout = false;
        return $this->render('invoice.html', [
            'order' => $order,
            'invoice' => $invoice,
            'serviceTel' => isset($serviceTel['data']) ? $serviceTel['data'] : array(),
            'telDefault' => isset($serviceTel['default']) ? $serviceTel['default'] : array(),
        ]);
    }

}
