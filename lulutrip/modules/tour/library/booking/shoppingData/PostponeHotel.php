<?php

namespace lulutrip\modules\tour\library\booking\shoppingData;

/**
 * 酒店后加订
 * @author Victor Tang<victor.tang@ipptravel.com>
 * @package lulutrip\library\tour\shoppingData
 */
class PostponeHotel {

    /**
     * @var string 入住日期
     */
    public $checkIn;

    /**
     * @var string 离店日期
     */
    public $checkOut;

    /**
     * @var string 选择的酒店套餐
     */
    public $itemId;

    /**
     * @var float 价格总计
     */
    public $amount;

    /**
     * @var string 酒店标题
     */
    public $title;

    /**
     * @var string 酒店电话
     */
    public $telephone;

    /**
     * @var string 酒店地址
     */
    public $address;

    /**
     * @var int 单人房
     */
    public $singleRoomCount;

    /**
     * @var int 双人房
     */
    public $doubleRoomCount;

    /**
     * @var int 三人房
     */
    public $tripleRoomCount;

    /**
     * @var int 四人房
     */
    public $quadRoomCount;


    /**
     * PostponeHotel constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->checkOut         = $data['checkOut'];
        $this->itemId           = $data['itemId'];
        $this->singleRoomCount  = $data['singleRoomCount'];
        $this->doubleRoomCount  = $data['doubleRoomCount'];
        $this->tripleRoomCount  = $data['tripleRoomCount'];
        $this->quadRoomCount    = $data['quadRoomCount'];
    }
}