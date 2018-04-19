<?php

namespace lulutrip\modules\tour\library\booking\shoppingData;

/**
 * Class UsePoints 积分使用
 * @author Victor Tang<victor.tang@ipptravel.com>
 * @package lulutrip\modules\tour\library\booking\shoppingData
 */
class UsePoints {

    /**
     * @var int 积分数量
     */
    public $points;

    /**
     * @var int 积分抵扣金额
     */
    public $discountPrice;

    /**
     * UsePoints constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->points = isset($data['points']) ? $data['points'] : 0;
        $this->discountPrice = isset($data['discountPrice']) ? $data['discountPrice'] : 0;
    }
}