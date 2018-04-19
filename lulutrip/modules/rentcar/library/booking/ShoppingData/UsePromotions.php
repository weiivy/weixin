<?php

/**
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\library\booking\shoppingData;

class UsePromotions
{
    /**
     * @var int 优惠券Id
     */
    public $promotionId;

    /**
     * @var string 优惠券Code
     */
    public $promotionCode;

    /**
     * @var int 折扣金额
     */
    public $discountPrice;

    /**
     * UsePromotion constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->promotionId = isset($data['promotionId']) ? $data['promotionId'] : 0;
        $this->promotionCode = isset($data['promotionCode']) ? $data['promotionCode'] : null;
        $this->discountPrice = isset($data['discountPrice']) ? $data['discountPrice'] : 0;
    }
}