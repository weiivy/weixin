<?php

namespace lulutrip\modules\tour\library\booking\shoppingData;

use yii;
/**
 * 上车地点
 * @author Serena Liu<serena.liu@ipptravel.com>
 * @package lulutrip\library\tour\shoppingData
 */
class LocalPickup {

    /**
     * @var string 上车地点跟旅行团的关联ID
     */
    public $uid;

    /**
     * @var string 上车地点编码
     */
    public $code;

    /**
     * @var string 上车时间
     */
    public $startTime;

    /**
     * @var string 上车城市
     */
    public $city;

    /**
     * @var string 上车城市
     */
    public $cityEn;

    /**
     * @var string 上车地点
     */
    public $point;

    /**
     * @var string 上车地点
     */
    public $pointEn;

    /**
     * @var string 上车地址
     */
    public $address;

    /**
     * @var string 备注
     */
    public $remark;

    /**
     * @var string 备注
     */
    public $remarkEn;

    /**
     * AdvanceHotel constructor.
     * @param $productId
     * @param $uid
     */
    public function __construct($productId, $uid)
    {
        $this->uid = $uid;
        $url = Yii::$app->params['service']['tourapi'] . '/gtravel/product/' . $productId . '/point/' . $uid;
        $result = Yii::$app->helper->curlGet($url);
        Yii::info('API-GET: ' . $url . '===' . json_encode($result), __METHOD__);
        $this->code = $result['data']['code'];
        $this->startTime = $result['data']['startTime'];
        $this->remark = $result['data']['remarkCN'];
        $this->remarkEn = $result['data']['remarkEN'];
        $this->city = empty($result['data']['info']['cityCN']) ? '' : $result['data']['info']['cityCN'];
        $this->cityEn = empty($result['data']['info']['cityCN']) ? '' : $result['data']['info']['cityEN'];
        $this->point = $result['data']['info']['locationCN'];
        $this->pointEn = $result['data']['info']['locationEN'];
        $this->address = empty($result['data']['info']['address']) ? '' : $result['data']['info']['address'];
        return $result;
    }
}