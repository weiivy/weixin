<?php

namespace lulutrip\modules\tour\library\booking\shoppingData;

/**
 * Class RoomInfo 房间信息
 * @author Victor Tang<victor.tang@ipptravel.com>
 * @package lulutrip\modules\tour\library\booking\shoppingData
 */
class RoomInfo {

    public $adNum;

    public $kdNum;

    public $pf;

    public function __construct($data)
    {
        $this->adNum = $data['adNum'];
        $this->kdNum = $data['kdNum'];
        $this->pf = $data['pf'];
    }
}