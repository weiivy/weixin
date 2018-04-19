<?php

namespace lulutrip\modules\tour\library\booking\shoppingData;

/**
 * 用户选择的选项
 * @author Victor Tang<victor.tang@ipptravel.com>
 * @package lulutrip\library\tour\shoppingData
 */
class ActivityGroupItem {

    /**
     * @var integer 套餐项id
     */
    public $itemId;

    /**
     * @var integer 份数
     */
    public $unitCount;

    /**
     * ActivityGroupItem constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->itemId = $data['itemId'];
        if (isset($data['unitCount'])) {
            $this->unitCount = $data['unitCount'];
        }
    }
}