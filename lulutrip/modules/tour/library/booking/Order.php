<?php

namespace lulutrip\modules\tour\library\booking;

use api\library\Help;
use common\models\VoucherFlightInfo;
use common\models\Activitybooked;
use common\models\Booking;
use common\models\TourGroupActivity;
use common\models\TourLocalPickup;
use common\models\Hoteladdonbooked;
use common\models\Ordersum;
use common\models\Passenger;
use common\models\PassengerBooking;
use common\models\Tourroombooked;
use common\models\AdviserSalerOrders;
use common\models\AdviserSalers;
use common\models\VoucherHoteladdonbooked;
use common\models\VoucherItineraries;
use common\models\Vouchers;
use lulutrip\models\Invoices;
use lulutrip\models\sale\ActivityOrdersum;
use Yii;
use lulutrip\models\ShoppingData as ShoppingDataModel;

class Order {

    /**
     * 下单
     * @param ShoppingData $shopping
     * @return Ordersum $order
     * @throws \Exception
     */
    public function create(ShoppingData $shopping) {
        try{
            Yii::$app->db->beginTransaction();
            // 生成主订单
            $order = $this->_saveOrder($shopping);

            // 生成子订单
            $booking = $this->_saveBooking($order, $shopping);

            //保存折后价使用记录
            if($shopping->useAfterDiscount->id > 0) {
                $this->_saveActivityOrdersum($order, $shopping);
            }

            if ($shopping->pickupType == 2){
                // 保存上车地点
                $this->_saveLocalPickup($booking, $shopping);
            }elseif ($shopping->pickupType == 1){
                // 保存接机信息
                $this->_saveFlightInfo($booking, $shopping);
            }

            // 保存房间信息
            $this->_saveRoomInfo($booking, $shopping);

            // 保存游客信息
            $this->_saveTravellerInfo($booking, $shopping);

            // 保存行程信息
            //if($booking->one_day_tour == 0){
                $this->_saveItineraries($booking, $shopping);
            //}

            // 保存自选项目
            $this->_saveActivity($booking, $shopping);

            // 保存酒店加订
            $this->_saveHotelAddOn($booking, $shopping);

            // 保存行程顾问
            $this->_saveAdviserSaler($shopping, $booking);

            // 保存其他 Voucher 需要的信息
            $this->_saveVoucherInfo($booking, $shopping);

            // 保存 Invoice 需要的信息
            $this->_saveInvoice($order, $shopping);

            // 保存 shoppingData 数据
            $this->_saveShoppingData($order, $shopping);

            Yii::$app->db->transaction->commit();
            return $order;
        }catch (\Exception $e){
            Yii::$app->db->transaction->rollBack();
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 生成订单号
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-30
     * @param $memberId integer 用户Id
     * @param $orderId integer 订单Id
     * @return string
     */
    private static function _genOrderConf($memberId, $orderId) {
        return date("ymd") . "-" . $memberId . "-" . $orderId;
    }

    /**
     * 生成主订单
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-30
     * @param ShoppingData $shopping
     * @return Ordersum
     * @throws \Exception
     */
    private function _saveOrder(ShoppingData $shopping) {
        $order = new Ordersum();
        $order->memberid = $shopping->memberId;
        $order->order_date = date('Y-m-d');
        $order->orderterms = 'Y';
        $order->currency = $shopping->currency;
        $order->usdrate = Help::getRate()['USD'][$shopping->currency];
        $order->status = 1;
        $order->sourcetype = 'pc';
        $order->sourcefrom = 'tour-new';
        $order->currency = $shopping->currency;
        $order->totalamount = $shopping->totalAmount;
        $order->totalamounts = json_encode($shopping->totalAmounts);
        $order->promoid = $shopping->usePromotion->promotionId;
        $order->promotion_price = $shopping->usePromotion->discountPrice;
        $order->llp_deduct = $shopping->usePoints->points;
        $order->company_entity = Yii::$app->helper->getCompanyEntity($shopping->currency);
        $order->contact_info = json_encode($shopping->contactInfo);
        $order->save();

        if ($order->errors) {
            throw new \Exception('生成主订单错误 === ' . json_encode($order->errors), 500);
        }

        // 更新订单号
        $order->orderconf = self::_genOrderConf($shopping->memberId, $order->orderid);
        $order->save();

        return $order;
    }

    /**
     * 生成子订单
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-30
     * @param Ordersum $order
     * @param ShoppingData $shopping
     * @return Booking
     * @throws \Exception
     */
    private function _saveBooking(Ordersum $order, ShoppingData $shopping) {
        $booking = new Booking();
        $booking->orderid = $order->orderid;
        $booking->tripid = 0;
        $booking->tourcode = $shopping->pcode;
        $booking->bookingconf = "{$order->orderconf}-0";
        $booking->bkamt = $shopping->totalAmount;
        $booking->pickup_type = $shopping->pickupType;
        $booking->pickupno = 0;
        if ($shopping->pickupType == 1) {
            $booking->flight_filled = $shopping->fillTransfer;
            $booking->flightinfo = $this->_combineFlight($shopping);
        }
        $booking->bookingnote = $shopping->remarks;
        $booking->customerpickupnote = $shopping->contactInfo->areaCode . '-' . $shopping->contactInfo->phoneNumber;
        $booking->status = 1;
        $booking->lang = Yii::$app->params['curLang'];
        $booking->promoid = $shopping->usePromotion->promotionId;
        $booking->product_id = $shopping->pcode;
        $booking->product_title = $shopping->productTitle;
        $booking->departure_date = $shopping->sdate;
        $booking->return_date = $shopping->returnDate;
        $booking->supplier_id = $shopping->supplier;
        $booking->supplier_product_title = $shopping->supplierProductTitle;
        $booking->touropcode_new = $shopping->supplierProductCode;
        $booking->one_day_tour = $shopping->tourlen > 1 ? 0 : 1;
        $booking->commission_rate_new = $shopping->commissionRate;
        $booking->save();

        if ($booking->errors) {
            throw new \Exception('生成子订单错误 === ' . json_encode($booking->errors), 500);
        }

        return $booking;
    }

    /**
     * 保存上车地点信息
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @param Booking $booking
     * @param ShoppingData $shopping
     * @throws \Exception
     */
    private function _saveLocalPickup(Booking $booking, ShoppingData $shopping){
        $tourLocalPickup = new TourLocalPickup();
        $tourLocalPickup->pickup_uid = $shopping->localPickup->uid;
        $tourLocalPickup->bookingconf = $booking->bookingconf;
        $tourLocalPickup->pickup_code = $shopping->localPickup->code;
        $tourLocalPickup->pickup_time = $shopping->localPickup->startTime;
        $tourLocalPickup->pickup_city = $shopping->localPickup->city;
        $tourLocalPickup->pickup_city_en = $shopping->localPickup->cityEn;
        $tourLocalPickup->pickup_point = $shopping->localPickup->point;
        $tourLocalPickup->pickup_point_en = $shopping->localPickup->pointEn;
        $tourLocalPickup->pickup_address = $shopping->localPickup->address;
        $tourLocalPickup->pickup_remark = $shopping->localPickup->remark;
        $tourLocalPickup->pickup_remark_en = $shopping->localPickup->remarkEn;
        $tourLocalPickup->save();

        if ($tourLocalPickup->errors) {
            throw new \Exception('保存上车地点信息出错 === ' . json_encode($tourLocalPickup->errors), 500);
        }
    }

    /**
     * 保存房间信息
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-30
     * @param Booking $booking
     * @param ShoppingData $shopping
     * @throws \Exception
     */
    private function _saveRoomInfo(Booking $booking, ShoppingData $shopping) {
        if (is_array($shopping->roomInfos)) {
            foreach ($shopping->roomInfos as $roomIndex => $roomInfo) {
                $room = new Tourroombooked();
                $room->tripid = 0;
                $room->orderid = $booking->orderid;
                $room->tourcode = $shopping->pcode;
                $room->hotelcode = 0;
                $room->seasoncode = 0;
                $room->roomseats = $roomInfo->adNum + $roomInfo->kdNum;
                if ($booking->one_day_tour) {
                    $room->roomtype = '';
                    $room->remark = '';
                } else if ($roomInfo->pf) {
                    $room->roomtype = '配房';
                    $room->remark = 'Lulu配房注意事项：Lulutrip及地接公司协助安排另一同性团友，入住双人房，在旅游中，请自行妥善保管个人财物、行李，并对自己人身安全全权负责。在任何情况下，如要求终止配房，您将自行承担由此产生的任何全部责任及全部额外费用。一切责任与Lulutrip无关。';
                } else {
                    $roomTypes = ['1' => '单人房', '2' => '双人房', '3' => '三人房', '4' => '四人房'];
                    $room->roomtype = $roomTypes[$room->roomseats];
                    $roomRemarks = ['1' => '一张双人床或一张单人床，以入住时房型为准', '2' => '一张双人床或两张单人床，以入住时房型为准', '3' => '房间以两张床为主，第三、四人同房，不另加床', '4' => '房间以两张床为主，第三、四人同房，不另加床'];
                    $room->remark = $roomRemarks[$room->roomseats];
                }
                $room->tourroomprice = 0;
                $room->bookingconf = $booking->bookingconf;
                $room->tourroomidx = $roomIndex;
                $room->save();

                if ($room->errors) {
                    throw new \Exception('保存房间信息出错 === ' . json_encode($room->errors), 500);
                }
            }
        }
    }

    /**
     * 保存游客信息
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-30
     * @param Booking $booking
     * @param ShoppingData $shopping
     * @throws \Exception
     */
    private function _saveTravellerInfo(Booking $booking, ShoppingData $shopping) {
        if (is_array($shopping->travellerInfo)) {
            foreach ($shopping->travellerInfo as $travellerInfo) {
                $passenger = new Passenger();
                $passenger->isadult = $travellerInfo->isAdult ? 'Y' : 'N';
                $passenger->firstname = $travellerInfo->firstName;
                $passenger->lastname = $travellerInfo->lastName;
                $passenger->gender = $travellerInfo->sex == 'man' ? "1" : "0";
                $passenger->dob = $travellerInfo->birthday;
                $passenger->nationality = $travellerInfo->nationality;
                $passenger->ppn = $travellerInfo->passportNumber;
                if ($travellerInfo->areaCode && $travellerInfo->phoneNumber) {
                    $passenger->email = $travellerInfo->areaCode . '-' . $travellerInfo->phoneNumber;
                }
                $passenger->tourroomidx = $travellerInfo->roomIndex;
                $passenger->save();

                if ($passenger->errors) {
                    throw new \Exception('保存游客信息出错 === ' . json_encode($passenger->errors), 500);
                }

                $passengerBooking = new PassengerBooking();
                $passengerBooking->passengerid = $passenger->passengerid;
                $passengerBooking->bookingconf = $booking->bookingconf;
                $passengerBooking->room_index = $travellerInfo->roomIndex;
                $passengerBooking->save();

                if ($passengerBooking->errors) {
                    throw new \Exception('保存游客信息出错 === ' . json_encode($passengerBooking->errors), 500);
                }
            }
        }
    }

    /**
     * 保存行程信息
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @param Booking $booking
     * @param ShoppingData $shopping
     * @throws \Exception
     */
    private function _saveItineraries(Booking $booking, ShoppingData $shopping){
        if(is_array($shopping->itineraries)){
            foreach($shopping->itineraries as $itinerary){
                $voucherItineraries = new VoucherItineraries();
                $voucherItineraries->orderid = $booking->orderid;
                $voucherItineraries->bookingconf = $booking->bookingconf;
                $voucherItineraries->title_cn = $itinerary['titleCN'];
                $voucherItineraries->title_en = $itinerary['titleEN'];
                $voucherItineraries->dayno = $itinerary['dayIndex'];
                if(is_array($itinerary['hotels'])){
                    $hotelName = [];
                    foreach($itinerary['hotels'] as $hotel){
                        $hotelName[] = $hotel['titleCN'];
                    }
                    if (count($hotelName) > 0) {
                        $hotelName[] = '同级';
                    }
                    $voucherItineraries->hotels = json_encode($hotelName);
                }

                $voucherItineraries->save();

                if($voucherItineraries->errors){
                    throw new \Exception('保存旅行团行程出错 === ' . json_encode($voucherItineraries->errors), 500);
                }
            }
        }
    }
    /**
     * 保存自选项目
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-30
     * @param Booking $booking
     * @param ShoppingData $shoppingData
     * @throws \Exception
     */
    private function _saveActivity(Booking $booking, ShoppingData $shoppingData) {
        if (is_array($shoppingData->activityGroups)) {
            foreach ($shoppingData->activityGroups as $activityGroup) {
                $groupId = $activityGroup->groupId;
                if (is_array($activityGroup->items)) {
                    foreach ($activityGroup->items as $item) {
                        $itemId = $item->itemId;
                        $unitCount = $item->unitCount;
                        $activity = new Activitybooked();
                        $activity->bookingconf = $booking->bookingconf;
                        $activity->activitycode = $itemId;
                        $activity->activityqty = $unitCount;
                        $activity->save();

                        if ($activity->errors) {
                            throw new \Exception('保存自选项目出错 === ' . json_encode($activity->errors), 500);
                        }
                        //保存自选项目 by serena
                        $tourGroupActivity = new TourGroupActivity();
                        $tourGroupActivity->bookingconf = $booking->bookingconf;
                        $tourGroupActivity->title = $shoppingData->activities[$itemId]['displayName'];
                        $tourGroupActivity->title_en = $shoppingData->activities[$itemId]['displayNameEn'];
                        $tourGroupActivity->group_type = $shoppingData->activities[$itemId]['groupSubType'];
                        $tourGroupActivity->item_type = json_encode([$shoppingData->activities[$itemId]['itemCount'], $shoppingData->activities[$itemId]['minItems']]);
                        $tourGroupActivity->price_type = $shoppingData->activities[$itemId]['priceType'];
                        $tourGroupActivity->price_info = (string)$shoppingData->activities[$itemId]['amount'];
                        $tourGroupActivity->unit_count = empty($unitCount) ? 0 : $unitCount;
                        $tourGroupActivity->group_id = $groupId;
                        $tourGroupActivity->item_id = $itemId;
                        $tourGroupActivity->person_info = json_encode(['adultCount' => $shoppingData->adultCount, 'childCount' => $shoppingData->childCount]);
                        $tourGroupActivity->save();

                        if($tourGroupActivity->errors){
                            throw new \Exception('保存自选项目-new 出错 === ' . json_encode($tourGroupActivity->errors), 500);
                        }
                    }
                }
            }
        }
    }

    /**
     * 保存加订酒店
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-30
     * @param Booking $booking
     * @param ShoppingData $shoppingData
     * @throws \Exception
     */
    private function _saveHotelAddOn(Booking $booking, ShoppingData $shoppingData) {
        $rooms = $this->_formatAddHotelRooms($shoppingData);

        if ($shoppingData->advanceHotel) {
            $itemId = $shoppingData->advanceHotel->itemId;
            foreach($rooms['advanceHotel'] as $key => $room) {
                $hotelAddOn = new Hoteladdonbooked();
                $hotelAddOn->bookingconf = $booking->bookingconf;
                $hotelAddOn->hotelcode = $itemId;
                $hotelAddOn->indate = $shoppingData->advanceHotel->checkIn;
                $hotelAddOn->outdate = $shoppingData->sdate;
                $hotelAddOn->numroom = $room['numroom'];
                $hotelAddOn->roomtype = $room['roomtype'];
                $hotelAddOn->hoteladdonprice = $shoppingData->hotelAdds[$itemId][$room['roomtype'].'RoomAmount'];
                $hotelAddOn->len = ceil((strtotime($hotelAddOn->outdate) - strtotime($hotelAddOn->indate)) / (3600 * 24));
                $hotelAddOn->save();

                if ($hotelAddOn->errors) {
                    throw new \Exception('保存加订酒店出错 === ' . json_encode($hotelAddOn->errors), 500);
                }
            }

            //voucher 加订酒店
            $voucherHotelAddBooked = new VoucherHoteladdonbooked();
            $voucherHotelAddBooked->bookingconf = $booking->bookingconf;
            $voucherHotelAddBooked->hotelcode = $itemId;
            $voucherHotelAddBooked->indate = $shoppingData->advanceHotel->checkIn;
            $voucherHotelAddBooked->outdate = $shoppingData->sdate;
            $voucherHotelAddBooked->len = $hotelAddOn->len;
            $voucherHotelAddBooked->hoteladdonprice = $shoppingData->hotelAdds[$itemId]['actualAmount'];

            $voucherHotelAddBooked->telephone = $shoppingData->hotelAdds[$itemId]['extInfo']['tell'];
            $voucherHotelAddBooked->hfullname_en = $shoppingData->hotelAdds[$itemId]['extInfo']['nameCN'];
            $voucherHotelAddBooked->address = $shoppingData->hotelAdds[$itemId]['extInfo']['address'];
            $voucherHotelAddBooked->rooms = empty($rooms['advanceHotel']) ? '' : json_encode($rooms['advanceHotel']);
            $voucherHotelAddBooked->save();

            if ($voucherHotelAddBooked->errors) {
                throw new \Exception('保存voucher-加订酒店-行前-出错 === ' . json_encode($voucherHotelAddBooked->errors), 500);
            }
        }

        if ($shoppingData->postponeHotel) {
            $itemId = $shoppingData->postponeHotel->itemId;
            foreach($rooms['postponeHotel'] as  $key => $room) {
                $hotelAddOn = new Hoteladdonbooked();
                $hotelAddOn->bookingconf = $booking->bookingconf;
                $hotelAddOn->hotelcode = $itemId;
                $hotelAddOn->indate = $shoppingData->returnDate;
                $hotelAddOn->outdate = $shoppingData->postponeHotel->checkOut;
                $hotelAddOn->numroom = $room['numroom'];
                $hotelAddOn->roomtype = $room['roomtype'];
                $hotelAddOn->hoteladdonprice = $shoppingData->hotelAdds[$itemId][$room['roomtype'].'RoomAmount'];
                $hotelAddOn->len = ceil((strtotime($hotelAddOn->outdate) - strtotime($hotelAddOn->indate)) / (3600 * 24));

                $hotelAddOn->save();

                if ($hotelAddOn->errors) {
                    throw new \Exception('保存加订酒店出错 === ' . json_encode($hotelAddOn->errors), 500);
                }
            }

            //voucher 加订酒店
            $voucherHotelAddBooked = new VoucherHoteladdonbooked();
            $voucherHotelAddBooked->bookingconf = $booking->bookingconf;
            $voucherHotelAddBooked->hotelcode = $itemId;
            $voucherHotelAddBooked->indate = $shoppingData->returnDate;
            $voucherHotelAddBooked->outdate = $shoppingData->postponeHotel->checkOut;
            $voucherHotelAddBooked->len = $hotelAddOn->len;
            $voucherHotelAddBooked->hoteladdonprice = $shoppingData->hotelAdds[$itemId]['actualAmount'];

            $voucherHotelAddBooked->telephone = $shoppingData->hotelAdds[$itemId]['extInfo']['tell'];
            $voucherHotelAddBooked->hfullname_en = $shoppingData->hotelAdds[$itemId]['extInfo']['nameCN'];
            $voucherHotelAddBooked->address = $shoppingData->hotelAdds[$itemId]['extInfo']['address'];
            $voucherHotelAddBooked->rooms = empty($rooms['postponeHotel']) ? '' : json_encode($rooms['postponeHotel']);
            $voucherHotelAddBooked->save();

            if ($voucherHotelAddBooked->errors) {
                throw new \Exception('保存voucher-加订酒店-行后-出错 === ' . json_encode($voucherHotelAddBooked->errors), 500);
            }
        }
    }

    /**
     * 保存行程顾问
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @param ShoppingData $shopping
     * @param Booking $booking
     * @throws \Exception
     */
    private function _saveAdviserSaler(ShoppingData $shopping, Booking $booking){
        if (isset($shopping->adviser)) {
            //获取顾问名字
            $seller = AdviserSalers::findOne(['id' => $shopping->adviser]);
            $adviserSaler = new AdviserSalerOrders();
            $adviserSaler->orderid = $booking->orderid;
            $adviserSaler->bookingconf = $booking->bookingconf;
            $adviserSaler->memberid = $shopping->memberId;
            $adviserSaler->saler_id = $seller->id;
            $adviserSaler->saler_name = $seller->name_en;
            $adviserSaler->ordername = addslashes($shopping->productTitle).'（产品编号: ' . $shopping->pcode . '）';
            $adviserSaler->saler_evaluation_id = 0;
            $adviserSaler->evaluation_url = '';
            $adviserSaler->booking_status = 1; //RECEIVED
            $adviserSaler->order_type = 'tour';
            $adviserSaler->save();

            if ($adviserSaler->errors) {
                throw new \Exception('保存行程顾问出错 === ' . json_encode($adviserSaler->errors), 500);
            }
        }
    }

    /**
     * 格式化航班信息
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @param ShoppingData $shopping
     * @return string
     */
    private function _combineFlight(ShoppingData $shopping) {
        $config = [
            "flight" => [
            "inbound" => "飞抵航班",
            "dept" => "飞离",
            "at" => "于",
            "arrive" => "飞抵",
            "outbound" => "飞出航班"
            ]
        ];
        $flight = $shopping->formData;
        $flightinfo = '';

        if($shopping->fillTransfer == 1){
            isset($flight['inflight']) && $flightinfo = $config['flight']['inbound'] . ":&nbsp;" . "&nbsp;" . $flight['inflight']['flight'] . "&nbsp;" . $config['flight']['dept'] . "&nbsp;" . "&nbsp;" . "&nbsp;" . $config['flight']['at'] . "&nbsp;" . $flight['inflight']['date'] . "&nbsp;-- " . $config['flight']['arrive'] . "&nbsp;" . $flight['inflight']['arrivalap'] . "&nbsp;" . "&nbsp;" . $flight['inflight']['arrival'] . "&nbsp;\n";
            isset($flight['outflight']) && $flightinfo .= $config['flight']['outbound'] . ":&nbsp;" . "&nbsp;" . $flight['outflight']['flight'] . "&nbsp;" . $config['flight']['dept'] . "&nbsp;" . $flight['outflight']['deptap'] . "&nbsp;" . $flight['outflight']['dept'] . "&nbsp;" . $config['flight']['at'] . "&nbsp;" . $flight['outflight']['date'];
        }

        return str_replace(array("'"), array("’"), $flightinfo);
    }

    /**
     * 保存接机信息
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-09-08
     * @param Booking $booking
     * @param ShoppingData $shoppingData
     * @throws \Exception
     */
    private function _saveFlightInfo(Booking $booking, ShoppingData $shoppingData) {
        if ($shoppingData->fillTransfer == 1) {
            $flightInfo = new VoucherFlightInfo();
            $flightInfo->bookingconf = $booking->bookingconf;
            $flightInfo->in_flight = json_encode($shoppingData->formData['inflight']);
            $flightInfo->out_flight = json_encode($shoppingData->formData['outflight']);
            $flightInfo->save();

            if ($flightInfo->errors) {
                throw new \Exception('保存航班信息出错 === ' . json_encode($flightInfo->errors), 500);
            }
        }
    }

    /**
     * 保存Voucher信息
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-09-11
     * @param Booking $booking
     * @param ShoppingData $shoppingData
     * @throws \Exception
     */
    private function _saveVoucherInfo(Booking $booking, ShoppingData $shoppingData) {
        $voucher = new Vouchers();
        $voucher->orderid = $booking->orderid;
        $voucher->bookingconf = $booking->bookingconf;
//        $voucher->priceincludes = $shoppingData->priceIncludes;
//        $voucher->pricenotincludes = $shoppingData->priceExcludes;
//        $voucher->tournotes = $shoppingData->importantNotice;
        //费用包含
        if(!empty($shoppingData->basic['priceIncludes'])){
            $info = [];
            foreach($shoppingData->basic['priceIncludes'] as $key => $priceInclude){
                $info[] = ($key + 1) . '. ' . $priceInclude['key'] . ": " . $priceInclude['value'];
            }
            $voucher->priceincludes = implode('<br/>', $info);
        }else{
            $voucher->priceincludes = $shoppingData->basic['priceIncludeLuluCN'];
        }
        //费用不包含
        if(!empty($shoppingData->basic['priceExcludes'])){
            $info = [];
            foreach($shoppingData->basic['priceExcludes'] as $key => $priceExclude){
                $info[] = ($key + 1) . '. ' . $priceExclude['key'] . ": " . $priceExclude['value'];
            }
            $voucher->pricenotincludes = implode('<br/>', $info);
        }else {
            $voucher->pricenotincludes = $shoppingData->basic['priceExcludeLuluCN'];
        }
        //注意事项
        if(!empty($shoppingData->translation['needToKnow'])){
            $notes = [];
            foreach($shoppingData->translation['needToKnow'] as $needToKnow){
                $notes[] = $needToKnow['content'];
            }
            $voucher->tournotes = implode('<br/>', $notes);
        }
        //接机参团
        if(!empty($shoppingData->translation['pickupTips'])){
            $notes = [];
            foreach($shoppingData->translation['pickupTips'] as $pickupTip){
                $notes[] = $pickupTip['content'];
            }
            $voucher->pickup_notes = implode('<br/>', $notes);
        }
        //上车点参团
        if(!empty($shoppingData->translation['aboardTips'])){
            $notes = [];
            foreach($shoppingData->translation['aboardTips'] as $aboardTip){
                $notes[] = $aboardTip['content'];
            }
            $voucher->tourin_notes = implode('<br/>', $notes);
        }
//        if ($booking->supplier->parse_ic == 'xls') {
//            $voucher->use_op_iti = 1;
//        } elseif ($booking->supplier->parse_ic == 'pdf') {
//            $voucher->use_op_iti = 2;
//        } else {
//            $voucher->use_op_iti = 0;
//        }
        $voucher->save();

        if ($voucher->errors) {
            throw new \Exception('保存Voucher信息出错 === ' . json_encode($voucher->errors), 500);
        }
    }

    /**
     * 保存Invoice信息
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-09-12
     * @param Ordersum $order
     * @param ShoppingData $shoppingData
     * @throws \Exception
     */
    private function _saveInvoice(Ordersum $order, ShoppingData $shoppingData) {
        $invoice = new Invoices();
        $invoice->orderconf = $order->orderconf;
        $invoice->currency = $order->currency;
        $invoice->grandtotal = $order->totalamount;
        $invoice->items = $shoppingData->priceInventory;
        if(!empty($shoppingData->promotionsInfo)) $invoice->promotions = $shoppingData->promotionsInfo;
        $invoice->status = 2;
        $invoice->save();

        if ($invoice->errors) {
            throw new \Exception('保存Invoice信息 === ' . json_encode($invoice->errors), 500);
        }
    }

    /**
     * 格式化加订酒店房间数
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-09-21
     * @param ShoppingData $shoppingData
     * @return array 返回数据
     */
    private function _formatAddHotelRooms(ShoppingData $shoppingData)
    {

        $data['advanceHotel'] =  $data['postponeHotel']= [];
        $alisa = Booking::getRoomTypeAlisa();

        //加订前
        $advanceHotel = $shoppingData->advanceHotel;
        if($advanceHotel) {
            $advanceHotelRooms = ['single' => $advanceHotel->singleRoomCount, 'double' => $advanceHotel->doubleRoomCount, 'triple' => $advanceHotel->tripleRoomCount, 'quad' => $advanceHotel->quadRoomCount];
            $advanceHotelRooms = array_filter($advanceHotelRooms);
            foreach($advanceHotelRooms as $key => $value) {
                $data['advanceHotel'][] = [
                    'numroom'  => $value,
                    'roomtype' => $key,

                ];
            }
        }


        //加订后
        $postponeHotel = $shoppingData->postponeHotel;
        if($postponeHotel) {
            $postponeHotelRooms = ['single' => $postponeHotel->singleRoomCount, 'double' => $postponeHotel->doubleRoomCount, 'triple' => $postponeHotel->tripleRoomCount, 'quad' => $postponeHotel->quadRoomCount];
            $postponeHotelRooms = array_filter($postponeHotelRooms);
            foreach($postponeHotelRooms as $key => $value) {
                $data['postponeHotel'][] = [
                    'numroom'  => $value,
                    'roomtype' => $key,
                ];
            }
        }

        return $data;
    }

    /**
     * 保存折扣信息
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-12-04
     * @param Ordersum $order
     * @param ShoppingData $shoppingData
     * @throws \Exception
     */
    private function _saveActivityOrdersum(Ordersum $order, ShoppingData $shoppingData)
    {
        $activityOrdersum = new ActivityOrdersum();
        $activityOrdersum->orderid = $order->orderid;
        $activityOrdersum->activity_id = $shoppingData->useAfterDiscount->activity_id;
        $activityOrdersum->sub_activity_id = $shoppingData->useAfterDiscount->id;
        $activityOrdersum->title = $shoppingData->useAfterDiscount->title;
        $activityOrdersum->discount_price = $shoppingData->useAfterDiscount->discountPrice;
        $activityOrdersum->promo_code = $shoppingData->useAfterDiscount->promoCode;
        $activityOrdersum->kind = $shoppingData->useAfterDiscount->kind;
        $activityOrdersum->is_discount = $shoppingData->useAfterDiscount->isDiscount;
        $activityOrdersum->save();
        if ($activityOrdersum->errors) {
            throw new \Exception('保存ActivityOrdersum信息 === ' . json_encode($activityOrdersum->errors), 500);
        }
    }

    /**
     * 保存 ShoppingData
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2018-02-08
     * @param Ordersum $order
     * @param ShoppingData $shoppingData
     * @throws \Exception
     */
    private function _saveShoppingData(Ordersum $order, ShoppingData $shoppingData) {
        $shoppingDataModel = new ShoppingDataModel();
        $shoppingDataModel->order_id = $order->orderid;
        $shoppingDataModel->shopping_data = json_encode($shoppingData);
        $shoppingDataModel->save();

        if ($shoppingDataModel->errors) {
            throw new \Exception("保存 ShoppingData 错误: " . json_encode($shoppingDataModel->errors), 500);
        }
    }
}