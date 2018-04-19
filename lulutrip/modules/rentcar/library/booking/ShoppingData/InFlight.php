<?php

namespace lulutrip\modules\rentcar\library\booking\ShoppingData;

/**
 * 接机服务
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 * @package lulutrip\library\tour\shoppingData
 */
class InFlight {

    /**
     * @var string 飞抵日期
     */
    public $date;

    /**
     * @var string 航班号码
     */
    public $flight;

    /**
     * @var string 抵达机场
     */
    public $arrivalap;

    /**
     * @var string 抵达时间
     */
    public $arrival;

    /**
     * ActivityGroupItem constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->date = $data['date'];
        $this->flight = $data['flight'];
        $this->arrivalap = $data['arrivalap'];
        $this->arrival = $data['arrival'];
    }
} 