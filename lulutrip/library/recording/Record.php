<?php

/**
 * @copyright (c) 2017, lulutrip.com
 * @author  martin ren<martin@lulutrip.com>
 */

namespace lulutrip\library\recording;

use lulutrip\components\Cookies;
use Yii;
use yii\base\Exception;

class Record extends \yii\base\Component
{
    /**
     * @var ApiLogs $_api
     */
    private $_api;

    public function init()
    {
        $this->_api = new ApiLogs;
    }

    /**
     * @Summary: 保存浏览历史
     * @Author: Victor Tang<victortang@lulutrip.com>
     * @Date: 2016-7-11
     * @param $code integer 旅行团、自由行产品编号
     */
    public static function writeHistoryData($code)
    {
        $productCodes = self::removeHistoryData($code);
        array_unshift($productCodes, $code);
        if (count($productCodes) > 30) {
            $productCodes = array_slice($productCodes, 0, 30);
        }

        self::setHistoryCookie($productCodes);
    }

    /**
     * remove cookie
     * @author LT<todd@lulutrip.com>
     * @copyright 2016-01-01
     * @param $code
     * @return array|string
     */
    public static function removeHistoryData($code)
    {
        if(!isset($_COOKIE['product_browsing_history'])) return array();
        $data   = trim($_COOKIE['product_browsing_history'], ',');
        $data   = explode(',', $data);
        $data   = array_flip($data);
        unset($data[$code]);
        $data   = array_flip($data);
        return $data;
    }


    /**
     * setcookie
     * @author LT<todd@lulutrip.com>
     * @copyright 2016-01-01
     * @param $data
     * @return bool
     */
    public static function setHistoryCookie($data) {
        $cookie = implode(',' ,$data);
        $cookie && $cookie .= ',';
        Yii::$app->cookies->setcookies("product_browsing_history", $cookie, 365);
        return true;
    }


    /**
     * 向mdc添加记录
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2016-11-08
     * @param $members
     * @param $code
     * @return array
     */
    public  function writeDataForMdc($members, $code)
    {
        $cookie = new Cookies();
        $uUid = $cookie->getCookies('uUiD', 0);

        //获取数据类型
        $proType = strtolower(Yii::$app->helper->pcodeParse($code));
        $params = array(
            'cookieid' => $uUid,
            'itemsource' => "pc",
            'itemtype' => $proType,
            'itemid' => $code
        );
        if(!empty($members)) {
            $params['userid'] = $members['memberid'];
            $params['key'] = self::generateKey();
        }

        try{
            $this->_api->update('mdc', 'scan_record/create_record', $params);
        } catch (Exception $e) {}

        return true;
    }


    /**
     * 关联数据
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2016-11-08
     * @param $members
     *
     */
    public function attributeWriteForMdc($members)
    {
        $cookie = new Cookies();
        $uUid = $cookie->getCookies('uUiD', 0);

        //获取当前cookieid没有关联用户的信息
        $params = array(
            'cookieid' => $uUid,
        );
        $result = $this->_api->update('mdc', 'scan_record/view_records', $params);

        //获取对应的PHPSESSID的未标记的数据
        $insertData = $result['data'];
        if($insertData) {
            foreach($insertData as $value) {
                $updateParams = array(
                    'cookieid' => $uUid,
                    'key' => self::generateKey(),
                    'itemid' => $value['itemid'],
                    'userid' => $members['memberid']
                );
                $this->_api->update('mdc', 'scan_record/update_record', $updateParams);
            }
        }
    }


    /**
     * 生成唯一秘钥
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2016-11-08
     *
     * @return string
     */
    public static function generateKey()
    {
        return empty($_COOKIE['Lulutrip_LSM']) ? '' : $_COOKIE['Lulutrip_LSM'];
    }
}