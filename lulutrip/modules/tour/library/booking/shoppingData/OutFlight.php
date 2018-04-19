<?php
/**
 * 送机服务
 * @copyright (c) 2017, lulutrip.com
 * @author  Serena Liu<serena.liu@ipptravel.com>
 */
namespace lulutrip\modules\tour\library\booking\shoppingData;

/**
 * 送机服务
 * @author Victor Tang<victor.tang@ipptravel.com>
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