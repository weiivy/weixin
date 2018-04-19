<?php

namespace lulutrip\modules\rentcar\library\booking\ShoppingData;

/**
 * Class 订单联系人信息
 * @author Justin Jia<justin.jia@ipptravel.com>
 */
class ContactInfo {

    /**
     * @var integer 区号
     */
    public $areaCode;

    /**
     * @var string 手机号码
     */
    public $phoneNumber;

    /**
     * @var string 姓名
     */
    public $fullName;

    /**
     * @var string 邮箱地址
     */
    public $emailAddress;

    /**
     * ContactInfo constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->areaCode = $data['areaCode'];
        $this->phoneNumber = $data['phoneNumber'];
        $this->fullName = $data['fullName'];
        $this->emailAddress = $data['emailAddress'];
    }
}