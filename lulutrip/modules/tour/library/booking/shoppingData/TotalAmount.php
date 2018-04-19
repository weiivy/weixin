<?php

namespace lulutrip\modules\tour\library\booking\shoppingData;

/**
 * 所有币种价格
 * @author Victor Tang<victor.tang@ipptravel.com>
 * @package lulutrip\library\tour\shoppingData
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