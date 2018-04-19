<?php

namespace lulutrip\modules\rentcar\library\booking;

use api\library\Help;
use api\models\rentcar\VoucherFlightInfo;
use common\models\rentcar\OrderRentcar;
use common\models\rentcar\OrderRentcarProduct;
use common\models\rentcar\OrderRentcarPassenger;
use common\models\Ordersum;
use common\models\Vouchers;
use lulutrip\models\Invoices;
use Yii;

class Order {

    /**
     * 下单
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-09-08
     * @param ShoppingData $shoppingData
     * @return array
     * @throws \Exception
     */
    public function create(ShoppingData $shoppingData) {
        Yii::$app->db->beginTransaction();

        // 生成主订单
        $order = $this->_saveOrder($shoppingData);

        // 生成子订单
        $orderRentcar = $this->_saveOrderRentcar($order, $shoppingData);

        // 保存自选项目
        $this->_saveActivity($orderRentcar, $shoppingData);

        // 保存驾驶员信息
        $this->_savePersonsInfo($orderRentcar, $shoppingData);

        // 保存接机信息
        $this->_saveFlightInfo($orderRentcar, $shoppingData);

        // 保存voucher相关信息
        $this->_saveVoucherInfo($orderRentcar, $shoppingData);

        // 保存Invoice相关信息
        $this->_saveInvoice($order, $shoppingData);

        Yii::$app->db->transaction->commit();

        $info = VoucherFlightInfo::findOne(['or_id' =>$orderRentcar->or_id ]);

        return ['orderId' => $order->orderid];
    }

    /**
     * 生成订单号
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-09-11
     * @param $memberId integer 用户Id
     * @param $orderId integer 订单Id
     * @return string
     */
    private static function _genOrderConf($memberId, $orderId) {
        return date("ymd") . "-" . $memberId . "-" . $orderId;
    }

    /**
     * 生成主订单
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-09-08
     * @param ShoppingData $shoppingData
     * @return Ordersum
     * @throws \Exception
     */
    private function _saveOrder(ShoppingData $shoppingData) {
        $order = new Ordersum();
        $order->memberid = $shoppingData->memberId;
        $order->order_date = date('Y-m-d');
        $order->orderterms = 'Y';
        $order->currency = $shoppingData->currency;
        $order->usdrate = Help::getRate()['USD'][$shoppingData->currency];
        $order->status = 1;
        $order->sourcetype = 'pc';
        $order->sourcefrom = 'rentcar';
        $order->product_type ='rent-car';
        $order->totalamount = $shoppingData->totalAmount;
        $order->totalamounts = json_encode($shoppingData->totalAmounts);
        if (!empty($shoppingData->usePromotion)) {
            $order->promoid = $shoppingData->usePromotion->promotionId;
            $order->promotion_price = $shoppingData->usePromotion->discountPrice;
        }
        $order->company_entity = Yii::$app->helper->getCompanyEntity($shoppingData->currency);
        $order->contact_info = json_encode($shoppingData->contactInfo);
        $order->save();

        if ($order->errors) {
            Yii::$app->db->transaction->rollBack();
            throw new \Exception('生成主订单错误', 500);
        }

        // 更新订单号
        $order->orderconf = self::_genOrderConf($shoppingData->memberId, $order->orderid);
        $order->save();

        return $order;
    }

    /**
     * 生成子订单
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-09-11
     * @param Ordersum $order
     * @param ShoppingData $shoppingData
     * @return OrderRentcar
     * @throws \Exception
     */
    private function _saveOrderRentcar(Ordersum $order, ShoppingData $shoppingData) {
        $carinfo = $shoppingData->cars['make'] . ' ' . $shoppingData->cars['model'] . ' ' . $shoppingData->cars['year'];
        $daylen = ceil((strtotime($shoppingData->return_time) - strtotime($shoppingData->pickup_time)) / 86400);
        $orderRentcar = new OrderRentcar();
        $orderRentcar->orderid = $order->orderid;
        $orderRentcar->carid = $shoppingData->carid;
        $orderRentcar->carname = $shoppingData->cars['title'];
        $orderRentcar->carinfo = $carinfo;
        $orderRentcar->seats = $shoppingData->cars['seats'];
        $orderRentcar->luggage = $shoppingData->cars['luggage'];
        $orderRentcar->daylen = $daylen;
        $orderRentcar->pickup_location = $shoppingData->pickup_location;
        $orderRentcar->return_location = $shoppingData->return_location;
        $orderRentcar->pickup_time = $shoppingData->pickup_time;
        $orderRentcar->return_time = $shoppingData->return_time;
        $orderRentcar->insurance = $shoppingData->insurance;
        $orderRentcar->total_amount = $shoppingData->totalAmount;
        $orderRentcar->customerpickupnote = $shoppingData->contactInfo->areaCode . '-' . $shoppingData->contactInfo->phoneNumber;
        $orderRentcar->create_date = date("Y-m-d H:i:s", time());
        $orderRentcar->status = 1;
        $orderRentcar->bookingnote = $shoppingData->remarks;
        $orderRentcar->orderconf = "{$order->orderconf}-0";
        $orderRentcar->lang = "CN";
        $orderRentcar->supplier_id = 432;
        $orderRentcar->flightpickuptype = ($shoppingData->formData['fillTransfer'] == 1 ? 3 : ($shoppingData->formData['fillTransfer'] == 3 ? 1 : $shoppingData->formData['fillTransfer']));
        if (!empty($shoppingData->usePromotion)) {
            $orderRentcar->promoid = $shoppingData->usePromotion->promotionId;
            $orderRentcar->promotion_price = $shoppingData->usePromotion->discountPrice;
        }

        $orderRentcar->save();

        if ($orderRentcar->errors) {
            Yii::$app->db->transaction->rollBack();
            throw new \Exception('生成子订单错误', 500);
        }

        return $orderRentcar;
    }

    /**
     * 保存自选项目
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-09-11
     * @param OrderRentcar $orderRentcar
     * @param ShoppingData $shoppingData
     * @throws \Exception
     */
    private function _saveActivity(OrderRentcar $orderRentcar, ShoppingData $shoppingData) {
        $optionalids = explode(',', $shoppingData->optionalids);
        $daylen = ceil((strtotime($shoppingData->return_time) - strtotime($shoppingData->pickup_time)) / 86400);
        if (!empty($optionalids)) {
            $OptionalProject = (new OptionalProject)->getOptional();
            foreach ($OptionalProject['items'] as $item) {
                $total_price = ceil($daylen * $item['price']) > $item['priceCaps'] ? $item['priceCaps'] : ceil($daylen * $item['price']);
                if (in_array($item['id'], $optionalids)) {
                    $product = new OrderRentcarProduct();
                    $product->or_id = $orderRentcar->or_id;
                    $product->product_name = $item['name'];
                    $product->product_price = $item['price'];
                    $product->product_price_caps = $item['priceCaps'];
                    $product->total_price = $total_price;

                    $product->save();

                    if ($product->errors) {
                        Yii::$app->db->transaction->rollBack();
                        throw new \Exception("保存自选项目出错", 500);
                    }
                }
            }
        }
    }

    /**
     * 保存驾驶员信息
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-09-11
     * @param OrderRentcar $orderRentcar
     * @param ShoppingData $shoppingData
     * @throws \Exception
     */
    private function _savePersonsInfo(OrderRentcar $orderRentcar, ShoppingData $shoppingData) {
        $personsInfo = new OrderRentcarPassenger();
        $personsInfo->or_id = $orderRentcar->or_id;
        $personsInfo->areacode = $shoppingData->personsInfo->areaCode;
        $personsInfo->phone = $shoppingData->personsInfo->phoneNumber;
        $personsInfo->lastname = $shoppingData->personsInfo->lastName;
        $personsInfo->firstname = $shoppingData->personsInfo->firstName;
        $personsInfo->age = $shoppingData->personsInfo->age;
        $personsInfo->type = $shoppingData->personsInfo->type;

        $personsInfo->save();

        if ($personsInfo->errors) {
            Yii::$app->db->transaction->rollBack();
            throw new \Exception('驾驶员信息保存出错', 500);
        }
    }

    /**
     * 保存Voucher信息
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-09-30
     * @param OrderRentcar $orderRentcar
     * @param ShoppingData $shoppingData
     * @throws \Exception
     */
    private function _saveVoucherInfo(OrderRentcar $orderRentcar, ShoppingData $shoppingData) {
        $voucher = new Vouchers();
        $voucher->orderid = $orderRentcar->orderid;
        $voucher->bookingconf = $orderRentcar->orderconf;
        $voucher->save();

        if ($voucher->errors) {
            Yii::$app->db->transaction->rollBack();
            throw new \Exception("保存Voucher信息出错", 500);
        }
    }

    /**
     * 保存Invoice信息
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-09-30
     * @param Ordersum $order
     * @param ShoppingData $shoppingData
     * @throws \Exception
     */
    private function _saveInvoice(Ordersum $order, ShoppingData $shoppingData) {
        $rental = ['rental' => [
            'displayName' => $shoppingData->cars['title'],
            'departureDate' => $shoppingData->pickup_time,
            'passengers' => $shoppingData->personsInfo->lastName . ',' . $shoppingData->personsInfo->firstName,
            'amount' => $order->totalamount,
        ]];
        $invoice = new Invoices();
        $invoice->orderconf = $order->orderconf;
        $invoice->currency = $order->currency;
        $invoice->grandtotal = $order->totalamount;
        $invoice->items = $rental;
        $invoice->status = 2;
        $invoice->save();

        if ($invoice->errors) {
            Yii::$app->db->transaction->rollBack();
            throw new \Exception("保存Invoice信息出错", 500);
        }
    }

    /**
     * 保存接机信息
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-12-12
     * @param OrderRentcar $orderRentcar
     * @param ShoppingData $shoppingData
     * @throws \Exception
     */
    private function _saveFlightInfo(OrderRentcar $orderRentcar, ShoppingData $shoppingData) {
        if ($shoppingData->fillTransfer == 1) {
            $flightInfo = new VoucherFlightInfo();
            $flightInfo->or_id = $orderRentcar->or_id;
            $flightInfo->in_flight = json_encode($shoppingData->formData['inflight']);
            $flightInfo->out_flight = json_encode($shoppingData->formData['outflight']);
            $flightInfo->save();

            if ($flightInfo->errors) {
                throw new \Exception("保存航班信息出错", 500);
            }
        }
    }
}