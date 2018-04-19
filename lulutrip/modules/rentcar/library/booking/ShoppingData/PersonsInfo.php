<?php
/**
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\library\booking\shoppingData;

class PersonsInfo
{
    /**
     * @var string 区号
     */
    public $areaCode;

    /**
     * @var string 手机号
     */
    public $phoneNumber;

    /**
     * @var string 姓
     */
    public $lastName;

    /**
     * @var string 名
     */
    public $firstName;

    /**
     * @var integer 年龄
     */
    public $age;

    /**
     * @var string 驾照类型
     */
    public $type;

    /**
     * PersonsInfo constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->areaCode = $data['areaCode'];
        $this->phoneNumber = $data['phoneNumber'];
        $this->firstName = $data['firstName'];
        $this->lastName = $data['lastName'];
        $this->age = $data['age'];
        $this->type = $data['type'];
    }
}