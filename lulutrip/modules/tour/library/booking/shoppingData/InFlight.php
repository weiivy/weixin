<?php
/**
 * 接机服务
 * @copyright (c) 2017, lulutrip.com
 * @author  Serena Liu<serena.liu@ipptravel.com>
 */
namespace lulutrip\modules\tour\library\booking\shoppingData;

/**
 * 接机服务
 * @author Victor Tang<victor.tang@ipptravel.com>
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