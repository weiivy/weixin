<?php

namespace lulutrip\models;

class Invoices extends \common\models\Invoices {

    /**
     * 获取items值
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @param $type
     * @return array
     */
    public function getItems($type) {
        $items = $this->items;

        if (isset($items->{$type}->items)) {
            return $items->{$type}->items;
        } else {
            return [];
        }
    }

}