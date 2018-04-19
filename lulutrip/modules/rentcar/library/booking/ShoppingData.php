<?php
/**
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\library\booking;

use lulutrip\modules\rentcar\library\booking\ShoppingData\InFlight;
use lulutrip\modules\rentcar\library\booking\ShoppingData\OutFlight;
use Yii;
use lulutrip\modules\rentcar\library\booking\RentcarPrice;
use lulutrip\modules\rentcar\library\booking\ShoppingData\TotalAmount;
use lulutrip\modules\rentcar\library\booking\ShoppingData\UsePromotions;
use lulutrip\modules\rentcar\library\booking\ShoppingData\ContactInfo;
use api\library\Help;

class ShoppingData
{
    /**
     * @var
     */
    public $shoppingId;

    /**
     * @var integer 车辆ID
     */
    public $carid;

    /**
     * @var array 车辆信息
     */
    public $cars;

    /**
     * @var integer 保险
     */
    public $insurance;

    /**
     * @var string 取车地点
     */
    public $pickup_location;

    /**
     * @var string 取车时间
     */
    public $pickup_time;

    /**
     * @var string 还车地点
     */
    public $return_location;

    /**
     * @var string 还车时间
     */
    public $return_time;

    /**
     * @var array number 自选项目
     */
    public $optionalids;

    /**
     * @var number 总价
     */
    public $totalAmount;

    /**
     * @var array 所有价格
     */
    public $totalAmounts;

    /**
     * @var string 当前币种
     */
    public $currency;

    /**
     * @var array 优惠券
     */
    public $usePromotion;

    /**
     * @var array 驾驶员信息
     */
    public $personsInfo;

    /**
     * @var ContactInfo 订单联系人信息
     */
    public $contactInfo;

    /**
     * @var integer 用户ID
     */
    public $memberId;

    /**
     * @var string 订单备注
     */
    public $remarks;

    /**
     * @var string  异地还车
     */
    public $setting;

    /**
     * @var int 免费接送机类型[1: 需要机场接送,已订票; 2: 需要机场接送,未订票; 3: 无需机场接送]
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


    public function __construct($shoppingId = null) {
        if ($shoppingId) {
            if ($shoppingData = Yii::$app->cache->get($shoppingId)) {
                $this->shoppingId = $shoppingId;
                $this->carid = $shoppingData['carid'];
                $this->cars = $shoppingData['cars'];
                $this->insurance = $shoppingData['insurance'];
                $this->pickup_location = $shoppingData['pickup_location'];
                $this->pickup_time = $shoppingData['pickup_time'];
                $this->return_location = $shoppingData['return_location'];
                $this->return_time = $shoppingData['return_time'];

                $this->formData = $shoppingData['formData'];
                $this->_dealFormData();
                $this->usePromotion = new UsePromotions($shoppingData['usePromotion']);
                $this->personsInfo = $shoppingData['personsInfo'];
                $this->setting = ($shoppingData['pickup_location'] == $shoppingData['return_location'] ? '' : '含异地还车费');

            } else {
                throw new \Exception("shoppingId 已过期", 400);
            }
        }
    }

    /**
     * 保存订单联系人信息
     * @copyright 2017-09-06
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @return bool
     */
    public function save() {
        if (!$this->shoppingId) {
            $this->shoppingId = md5(session_id() . $this->carid);
        }

        Yii::$app->cache->set($this->shoppingId, [
            'carid' => $this->carid,
            'cars' => $this->cars,
            'insurance' => $this->insurance,
            'pickup_location' => $this->pickup_location,
            'pickup_time' => $this->pickup_time,
            'return_location' => $this->return_location,
            'return_time' => $this->return_time,
            'optionalids' => $this->formData['optionalids'],
            'usePromotion' => $this->usePromotion,
            'personsInfo' => $this->personsInfo,
            'formData'    => $this->formData
        ], 24*60*60);

        return true;
    }

    /**
     * 处理表单数据
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     */
    private function _dealFormData() {
        //免费接送机类型
        $this->fillTransfer = isset($this->formData['fillTransfer']) ? $this->formData['fillTransfer'] : 8;
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

        $this->optionalids = $this->formData['optionalids'];
    }

    /**
     * 获取价格清单
     * @copyright 2017-09-08
     * @author Justin Jia<justin.jia@ipptravel.com>
     */
    public function getInventory() {
        $result = (new RentcarPrice)->getPrice($this);
        $this->currency = $result['currency'];
        $this->totalAmount = $result['totalAmount'];
        foreach ($result['totalAmounts'] as $totalAmount) {
            $this->totalAmounts[] = new TotalAmount($totalAmount);
        }
    }

    /**
     * 计算总价
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-09-11
     * @return float|int
     */
    public function getTotalAmount() {
        $this->totalAmount = $this->totalAmount - $this->usePromotion->discountPrice;

        foreach ($this->totalAmounts as $totalAmount) {
            $totalAmount->amount = Help::exchangeCurrency($this->totalAmount, $this->currency, $totalAmount->currency, 'ceil2');
        }
    }
}