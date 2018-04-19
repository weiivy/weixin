<?php

namespace lulutrip\modules\tour\library\booking\shoppingData;

/**
 * 酒店数据 待优化 参考shopping->getHotelAddPrice();
 * @author Serena Liu<serena.liu@ipptravel.com>
 * @package lulutrip\library\tour\shoppingData
 */
class HotelAdds {

    /**
     * @var integer 选择的酒店套餐项
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
     * AdvanceHotel constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->checkIn = $data['checkIn'];
        $this->itemId = $data['itemId'];
    }
}