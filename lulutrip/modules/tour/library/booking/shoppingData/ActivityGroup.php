<?php

namespace lulutrip\modules\tour\library\booking\shoppingData;

/**
 * 自选套餐信息
 * @author Victor Tang<victor.tang@ipptravel.com>
 * @package lulutrip\library\tour\shoppingData
 */
class ActivityGroup {

    /**
     * @var integer 套餐id
     */
    public $groupId;

    /**
     * @var ActivityGroupItem[] 用户选择的选项集合
     */
    public $items;

    /**
     * ActivityGroup constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->groupId = $data['groupId'];
        if (is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                $this->items[] = new ActivityGroupItem($item);
            }
        }
    }
}