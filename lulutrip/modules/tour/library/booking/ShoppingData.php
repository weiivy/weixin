<?php

namespace lulutrip\modules\tour\library\booking;

use api\library\Help;
use lulutrip\modules\tour\library\booking\api\GetAfterDiscount;
use lulutrip\modules\tour\library\booking\api\GetInventory;
use lulutrip\modules\tour\library\booking\api\GetOffPercent;
use lulutrip\modules\tour\library\booking\api\GetProductInfo;
use lulutrip\modules\tour\library\booking\shoppingData\ActivityGroup;
use lulutrip\modules\tour\library\booking\shoppingData\AdvanceHotel;
use lulutrip\modules\tour\library\booking\shoppingData\ContactInfo;
use lulutrip\modules\tour\library\booking\shoppingData\InFlight;
use lulutrip\modules\tour\library\booking\shoppingData\LocalPickup;
use lulutrip\modules\tour\library\booking\shoppingData\OutFlight;
use lulutrip\modules\tour\library\booking\shoppingData\PostponeHotel;
use lulutrip\modules\tour\library\booking\shoppingData\RoomInfo;
use lulutrip\modules\tour\library\booking\shoppingData\TotalAmount;
use lulutrip\modules\tour\library\booking\shoppingData\TravellerInfo;
use lulutrip\modules\tour\library\booking\shoppingData\UseDiscount;
use lulutrip\modules\tour\library\booking\shoppingData\UsePromotion;
use lulutrip\modules\tour\library\booking\shoppingData\UsePoints;
use Yii;

/**
 * Class ShoppingData
 * @package lulutrip\modules\tour\library\booking
 * @author Victor Tang<victor.tang@ipptravel.com>
 * @copyright (c) 2017, lulutrip.com
 */
class ShoppingData {
    /**
     * @var integer
     */
    public $shoppingId;

    /**
     * @var integer 产品Id
     */
    public $pcode;

    /**
     * @var string 产品标题
     */
    public $productTitle;

    /**
     * @var array 产品游玩区域
     */
    public $productAreaCodes = [];

    /**
     * @var string 出发日期
     */
    public $sdate;

    /**
     * @var string 返回日期
     */
    public $returnDate;

    /**
     * @var integer 套餐 Id
     */
    public $itemId;

    /**
     * @var RoomInfo[] 房间信息
     */
    public $roomInfos;

    /**
     * @var ActivityGroup[] 自选套餐信息
     */
    public $activityGroups;

    /**
     * @var AdvanceHotel 酒店前加订
     */
    public $advanceHotel;

    /**
     * @var PostponeHotel 酒店后加订
     */
    public $postponeHotel;

    /**
     * @var TravellerInfo[] 旅客信息
     */
    public $travellerInfo;

    /**
     * @var ContactInfo 订单联系人信息
     */
    public $contactInfo;

    /**
     * @var string 订单备注
     */
    public $remarks;

    /**
     * @var integer 用户Id
     */
    public $memberId;

    /**
     * @var integer|float 参与折扣金额
     */
    public $participateCouponAmount;

    /**
     * @var integer|float 秒杀折扣
     */
    public $offPercent;

    /**
     * @var UsePromotion 使用的优惠码
     */
    public $usePromotion;

    /**
     * @var UsePoints 使用的积分数量
     */
    public $usePoints;

    /**
     * @var string 当前币种
     */
    public $currency;

    /**
     * @var string 当前币种原价
     */
    public $originPrice;

    /**
     * @var integer|float 当前币种价格
     */
    public $totalAmount;

    /**
     * @var TotalAmount[] 所有币种价格
     */
    public $totalAmounts;

    /**
     * @var int 行程顾问
     */
    public $adviser;

    /**
     * @var localPickup 上车地点
     */
    public $localPickup;

    /**
     * @var int 免费接送机类型[1: 需要机场接送,已订票; 4: 需要机场接送,未订票; 8: 无需机场接送]
     */
    public $fillTransfer;

    /**
     * @var InFlight[] 接机服务
     */
    public $inFlight;

    /**
     * @var OutFlight[] 送机服务
     */
    public $outFlight;

    /**
     * @var array "行程安排"的表单数据
     */
    public $formData;

    /**
     * @var int 供应商
     */
    public $supplier;

    /**
     * @var string 供应商产品编码
     */
    public $supplierProductCode;

    /**
     * @var string 供应商产品名称
     */
    public $supplierProductTitle;

    /**
     * @var integer 参团方式
     */
    public $pickupType;

    /**
     * @var int 旅行团天数
     */
    public $tourlen;

    /**
     * @var array 旅行团行程信息
     */
    public $itineraries;

    /**
     * @var int 成人总数
     */
    public $adultCount = 0;

    /**
     * @var int 儿童总数
     */
    public $childCount = 0;

    /**
     * @var string 费用包含
     */
    public $priceIncludes;

    /**
     * @var string 费用不包含
     */
    public $priceExcludes;

    /**
     * @var string 注意事项
     */
    public $importantNotice;

    /**
     * @var string 费用明细
     */
    public $priceInventory;

    /**
     * @var array 酒店加订
     */
    public $hotelAdds;

    /**
     * @var array 自选项目详情信息, itemId做为key
     */
    public $activities;

    /**
     * @var float 佣金率
     */
    public $commissionRate;

    /**
     * @var 使用折后价
     */
    public $useAfterDiscount;

    /**
     * @var 优惠信息
     */
    public $promotionsInfo;

    /**
     * @var array 包装信息
     */
    public $translation;

    /**
     * @var array 产品基础信息
     */
    public $basic;

    /**
     * @var object 价格清单
     */
    public $inventory;

    /**
     * @var 标记使用优惠情况
     */
    public $discountType;  // 3 满减及新后台优惠券  4 老后台优惠券 5 什么都不选

    /**
     * ShoppingData constructor.
     * @param $shoppingId
     * @throws \Exception
     */
    public function __construct($shoppingId = null) {
        if ($shoppingId) {
            if ($shoppingData = Yii::$app->cache->get($shoppingId)) {
                $this->shoppingId = $shoppingId;
                $this->pcode = $shoppingData['pcode'];
                $this->sdate = $shoppingData['sdate'];
                $this->itemId = $shoppingData['itemId'];
                if (is_array($shoppingData['roomInfos'])) {
                    foreach ($shoppingData['roomInfos'] as $roomInfo) {
                        $this->roomInfos[] = new RoomInfo($roomInfo);
                        $this->adultCount += $roomInfo['adNum'];
                        $this->childCount += $roomInfo['kdNum'];
                    }
                }
                $this->discountType = $shoppingData['discountType'];
                $this->formData = $shoppingData['formData'];
                $this->_dealFormData();
                $this->usePromotion = new UsePromotion($shoppingData['usePromotion']);
                $this->usePoints = new UsePoints($shoppingData['usePoints']);
                $this->useAfterDiscount = new UseDiscount($shoppingData['useAfterDiscount']);
            } else {
                throw new \Exception("shoppingId 已过期", 400);
            }
        }
    }

    /**
     * 保存订购数据
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     * @return bool
     */
    public function save() {
        if (!$this->shoppingId) {
            $this->shoppingId = md5(session_id() . $this->pcode);
        }

        return Yii::$app->cache->set($this->shoppingId, [
            // 详情页
            'pcode' => $this->pcode,
            'sdate' => $this->sdate,
            'itemId' => $this->itemId,
            'roomInfos' => $this->roomInfos,
            // Step 1
            'formData' => $this->formData,
            // Step 2
            'usePromotion' => $this->usePromotion,
            'usePoints' => $this->usePoints,
            'useAfterDiscount' => $this->useAfterDiscount,
            'discountType'   => $this->discountType
        ], 24*60*60);
    }

    /**
     * 处理表单数据
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     */
    private function _dealFormData() {
        //行程顾问
        isset($this->formData['adviser']) && $this->adviser = $this->formData['adviser'];
        //上车地点
        isset($this->formData['localPickup']) && $this->localPickup = new LocalPickup($this->pcode, $this->formData['localPickup']);
        //自选项目
        if(isset($this->formData['activityGroups'])){
            foreach($this->formData['activityGroups'] as $groupId => $groups){
                $activityGroups = [];
                $activityGroups['groupId'] = $groupId;
                $activityGroups['items'] = array_values($groups);
                $this->activityGroups[] = new ActivityGroup($activityGroups);
            }
        }
        //加订酒店 行前
        if(isset($this->formData['hotelAddonFront'])){
            $this->advanceHotel = new AdvanceHotel($this->formData['advanceHotel']);
        }
        //加订酒店 行后
        if(isset($this->formData['hotelAddonBack'])){
            $this->postponeHotel = new PostponeHotel($this->formData['postponeHotel']);
        }
        //免费接送机类型
        $this->fillTransfer = $this->formData['fillTransfer'];
        if($this->fillTransfer == 1){
            //免费接送机 接机服务
            if(isset($this->formData['inflight'])){
                $this->inFlight = new InFlight($this->formData['inflight']);
            }
            //免费接送机 送机服务
            if(isset($this->formData['outflight'])){
                $this->outFlight = new OutFlight($this->formData['outflight']);
            }
        }
    }

    /**
     * 获取价格清单
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     * @param bool $check
     * @return mixed
     */
    public function getInventory($check = false) {
        if(empty($this->discountType)){
            $offPercent = GetOffPercent::data($this->pcode);
            $this->offPercent = $offPercent['offPercent'];
        }

        $this->inventory = $result = GetInventory::data($this, $check);
        foreach ($result['area'] as $area) {
            $this->productAreaCodes[] = $area['luluCode'];
        }
        $this->currency = $result['currency'];
        $this->participateCouponAmount = $result['participateCouponAmount'];

        //团购价
        if ($this->offPercent > 0 && $this->offPercent < 1) {
            $this->usePromotion = new UsePromotion([
                'promotionId' => $offPercent['promotionId'],
                'discountPrice' => Yii::$app->helper->floor2($this->participateCouponAmount * (1 - $this->offPercent))
            ]);
        }

        //折后价
        if(empty($this->offPercent) || $this->offPercent == 1) {
            if(empty($this->discountType)){
                $afterDiscount = GetAfterDiscount::data($this->pcode);
                $this->offPercent = $afterDiscount['offPercent'];
            }
            if ($this->offPercent > 0 && $this->offPercent < 1) {
                $this->useAfterDiscount = new UseDiscount([
                    'id' => $afterDiscount['id'],
                    'activity_id' => $afterDiscount['activity_id'],
                    'title' => $afterDiscount['detailInfo']->title,
                    'discountPrice' => Yii::$app->helper->floor2($this->participateCouponAmount * (1 - $this->offPercent))
                ]);
                $this->promotionsInfo[] = ['displayName' => $this->useAfterDiscount->title . ' ' . $this->useAfterDiscount->promoCode, 'amount' => -$this->useAfterDiscount->discountPrice];
            }

        }

        $this->totalAmount = $result['totalAmount'];
        $this->commissionRate = intval(($result['totalAmount'] - $result['baseAmount']) / $result['totalAmount'] * 100);
        $this->priceInventory = $result['inventors'];
        foreach ($result['totalAmounts'] as $totalAmount) {
            $totalAmount['amount'] *= Help::exchangeCurrency($this->totalAmount, $this->currency, $totalAmount['currency'], 'ceil2');
            $this->totalAmounts[] = new TotalAmount($totalAmount);
        }
        return $result;
    }

    /**
     * 获取酒店加订 价格及其他信息
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @param $hotelAdd
     */
    public function getHotelAddPrice($hotelAdd){
        foreach($hotelAdd['items'] as $val){
            if($val['itemId'] == $this->advanceHotel->itemId){
                $this->advanceHotel->amount = $val['amount'];
                $this->advanceHotel->title = $val['extInfo']['nameCN'];
                $this->advanceHotel->telephone = $val['extInfo']['tell'];
                $this->advanceHotel->address = $val['extInfo']['address'];
            }
            if($val['itemId'] == $this->postponeHotel->itemId){
                $this->postponeHotel->amount = $val['amount'];
                $this->postponeHotel->title = $val['extInfo']['nameCN'];
                $this->postponeHotel->telephone = $val['extInfo']['tell'];
                $this->postponeHotel->address = $val['extInfo']['address'];
            }
        }
    }

    /**
     * 计算总价
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     * @return float|int
     */
    public function getTotalAmount() {
        $this->originPrice = $this->totalAmount;
        $this->totalAmount = $this->totalAmount - $this->usePromotion->discountPrice - $this->usePoints->discountPrice - $this->useAfterDiscount->discountPrice;
        $this->totalAmount = $this->totalAmount < 0 ? 0 : $this->totalAmount;
        foreach ($this->totalAmounts as $totalAmount) {
            $totalAmount->amount = Help::exchangeCurrency($this->totalAmount, $this->currency, $totalAmount->currency, 'ceil2');
        }
    }

    /**
     * 下单页第一步数据检查
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2018-01-18
     * @throws \Exception
     */
    public function checkStep1() {
        $this->checkActivityGroups();

        $productInfo = GetProductInfo::data($this);
        $this->pickupType = $productInfo['basic']['pickupType']['code'];
        if ($this->pickupType == 1) {
            if ($this->checkAirportPickup() == false) {
                throw new \Exception("请选择是否需要接送机。");
            }
        } elseif ($this->pickupType == 2) {
            if ($this->checkLocalPickup() == false) {
                throw new \Exception("请填写上车地点信息。");
            }
        }

        return true;
    }


    /**
     * 检查自选项目/加订酒店
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2018-01-18
     * @return bool
     */
    public function checkActivityGroups() {
        GetInventory::data($this, true);
        return true;
    }

    /**
     * 检查接送机信息
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2018-01-18
     * @return bool
     */
    public function checkAirportPickup()
    {
        if ($this->fillTransfer == 1 && (!empty($this->formData['inflight']) || !empty($this->formData['outflight']))) {
            return true;
        }
        if ($this->fillTransfer == 4) {
            return true;
        }
        if ($this->fillTransfer == 8) {
            return true;
        }

        return false;
    }

    /**
     * 检查上车地点信息
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2018-01-16
     * @return bool
     */
    public function checkLocalPickup() {
        if (!empty($this->localPickup)) {
            return true;
        }

        return false;
    }
}