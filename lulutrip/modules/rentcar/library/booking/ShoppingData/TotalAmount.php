<?php

namespace lulutrip\modules\rentcar\library\booking\shoppingData;

/**
 * 所有币种价格
 * Class TotalAmount
 * @package lulutrip\modules\rentcar\library\booking\shoppingData
 */
class TotalAmount {

    /**
     * @var string 币种（USD、EUR、CAD、RMB、GBP、AUD、NZD）
     */
    public $currency;

    /**
     * @var integer 价格
     */
    public $amount;

    /**
     * TotalAmount constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->currency = $data['currency'];
        $this->amount = $data['amount'];
    }
}