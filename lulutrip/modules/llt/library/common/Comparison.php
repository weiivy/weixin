<?php

/**
 * 产品比较类
 * @copyright (c) 2017, lulutrip.com
 * @author  martin ren<martin@lulutrip.com>
 */

namespace lulutrip\modules\llt\library\common;

use linslin\yii2\curl\Curl;
use yii\base\Exception;
use yii\helpers\Json;

class Comparison extends \yii\base\Component
{
    /**
     * @var Curl $_curl
     */
    private $_curl;

    public function init()
    {
        $this->_curl = new Curl;
    }
    /**
     * 添加对比
     * @author martin ren<martin@lulutrip.com>
     * @copyright 2017-02-12
     * @param $tourCode
     * @param $currency
     * @return array|null|\yii\db\ActiveRecord
     * @throws \yii\base\Exception
     */
    public function addComparison($tourCode, $currency)
    {
        $this->_curl->get(API_BASE.'/tour/comparison/' . $tourCode . '/' . $currency);
        $data = Json::decode($this->_curl->response);
        if($data['status'] != 200) {
            throw new Exception($data['message'], $data['status']);
        }

        $CompareIDs = isset($_COOKIE['CompareIDs']) && !empty($_COOKIE['CompareIDs']) ? explode(',', $_COOKIE['CompareIDs']) : [];
        if(count($CompareIDs) > 2) {
            throw new Exception('PRODUCT_MORE_THAN_3', 102);
        }

        if(in_array($tourCode, $CompareIDs)){
            throw new Exception('TOURCODE_REPEATE', 101);
        }

        $data = $data['data'];

        //记录对比ID
        $CompareIDs = empty($CompareIDs) ? $tourCode : implode(',', $CompareIDs) . ",". $tourCode;
        setcookie('CompareIDs', $CompareIDs, time()+3600*24,'/');
        return $data;
    }

}