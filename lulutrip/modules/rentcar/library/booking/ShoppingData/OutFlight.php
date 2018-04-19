<?php

namespace lulutrip\modules\rentcar\library\booking\ShoppingData;

/**
 * 送机服务
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 * @package lulutrip\library\tour\shoppingData
 */
class OutFlight {

    /**
     * @var string 飞出日期
     */
    public $date;

    /**
     * @var string 航班号码
     */
    public $flight;

    /**
     * @var string 出发机场
     */
    public $deptap;

    /**
     * @var string 出发时间
     */
    public $dept;

    /**
     * ActivityGroupItem constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->date = $data['date'];
        $this->flight = $data['flight'];
        $this->deptap = $data['deptap'];
        $this->dept = $data['dept'];
    }
}