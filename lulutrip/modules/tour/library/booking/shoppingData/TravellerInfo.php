<?php

namespace lulutrip\modules\tour\library\booking\shoppingData;

/**
 * 旅客信息
 * @author Victor Tang<victor.tang@ipptravel.com>
 * @package lulutrip\library\tour\shoppingData
 */
class TravellerInfo {
    /**
     * @var boolean 房间编号
     */
    public $roomIndex;

    /**
     * @var boolean 成人游客
     */
    public $isAdult;

    /**
     * @var integer 区号
     */
    public $areaCode;

    /**
     * @var string 手机号码
     */
    public $phoneNumber;

    /**
     * @var string 名
     */
    public $firstName;

    /**
     * @var string 姓
     */
    public $lastName;

    /**
     * @var string 出生年月
     */
    public $birthday;

    /**
     * @var string 性别
     */
    public $sex;

    /**
     * @var string 国籍
     */
    public $nationality;

    /**
     * @var string 护照号码
     */
    public $passportNumber;

    /**
     * TravellerInfo constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->roomIndex = $data['roomIndex'];
        $this->isAdult = $data['isAdult'];
        $this->areaCode = isset($data['areaCode']) ? $data['areaCode'] : null;
        $this->phoneNumber = isset($data['phoneNumber']) ? $data['phoneNumber'] : null;
        $this->firstName = $data['firstName'];
        $this->lastName = $data['lastName'];
        isset($data['birthday']) && $this->birthday = $data['birthday'];
        $this->sex = $data['sex'];
        isset($data['nationality']) && $this->nationality = $data['nationality'];
        isset($data['passportNumber']) && $this->passportNumber = $data['passportNumber'];
    }
}