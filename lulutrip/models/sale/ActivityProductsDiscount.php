<?php

namespace lulutrip\models\sale;

/**
 * Model ActivityProductsDiscount
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
class ActivityProductsDiscount extends \common\models\sale\ActivityProductsDiscount
{
    //折扣类型 1 折扣  2 减价
    const TYPE_DISCOUNT = 1;
    const TYPE_REDUCE   = 2;

    //是否显示折后价 2 不显示 1 显示
    const IS_DISCOUNT_TRUE = 1;
    const IS_DISCOUNT_FALSE = 2;

    /**
     * 力度设置限制别名
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-11-13
     * @param $type
     * @return mixed
     */
    public static function discountLimit($type)
    {
        $alisa =  [
            1 => '每单'
        ];
        return isset($alisa[$type]) ? $alisa[$type] : $type;
    }
} 