<?php
namespace lulutrip\library\common;

use yii\base\Component;

class History extends Component
{
    /**
     * @Summary: 获取浏览历史
     * @Author: Victor Tang<victortang@lulutrip.com>
     * @Date: 2016-7-11
     */
    public static function getHistoryData() {
        $historyData = array();
        $productBrowsingHistory = static::getBrowsingForCookie();
        if($productBrowsingHistory) {
            $productCodes = explode(',', trim($productBrowsingHistory, ','));
            $tourCodes = array();
            $actIds = array();
            $ptbIds = $pkTourcodes = array();
            $seq = array();
            for ($i = 0; $i < 5; $i++) {
                if (isset($productCodes[$i])) {
                    $productCode = $productCodes[$i];
                    $proType = static::pcodeParse($productCodes[$i]);
                    $proId = static::pcodeToId($productCodes[$i]);

                    if ($proType == 'ACT') {
                        $actIds[] = $proId;
                    } elseif ($proType == 'TOUR') {
                        $tourCodes[] = $proId;
                    } elseif ($proType == 'PBUS') {
                        //包车
                        $ptbIds[] = $proId;
                    } elseif ($proType == 'PACKAGETOUR') {
                        //包团
                        $pkTourcodes[] = $proId;
                    }
                    $seq[] = $productCode;
                }
            }

            $historyData = self::formatData($seq, $tourCodes, $actIds, $ptbIds, $pkTourcodes);
        }

        return $historyData;
    }

    private static function pcodeParse($pcode) {
        $pcode = intval($pcode);
        //ddss
        if(in_array(floor($pcode / 10000000), array(6,7,9))) {
            return 'DIY';
        }
        $type = '';
        $code = floor($pcode / 100000);
        switch($code) {
            case 3:
                $type = 'PBUS';
                break;
            case 4:
                $type = 'ACT';
                break;
            case 7:
                $type = 'HHTOUR';
                break;
            case 8:
                $type = 'PACKAGETOUR';
                break;
            case 9:
                $type = 'PBUSPACKAGE';
                break;
            case 0:
                $type = 'TOUR';
                break;
            default:
                break;
        }
        return $type;
    }

    private static function pcodeToId($pcode) {
        return $pcode > 10000000 ? intval($pcode) : intval($pcode) % 100000;

    }


    /**
     * Format data
     * @author LT<todd@lulutrip.com>
     * @copyright 2016-08-23
     * @param array $seq id先后顺序
     * @param array $tourCodes 团产品id
     * @param array $actIds 自由行产品id
     * @param array $ptbIds 包车产品id
     * @param array $pkTourcodes 包团产品id
     * @return array
     */
    public static function formatData($seq = array(), $tourCodes = array(), $actIds = array(), $ptbIds = array(), $pkTourcodes = array()) {
        $historyData = array();
        if ($tourCodes) {
            $tourList = array();
            foreach ($tourList as $v) {
                $v['subject'] = 'tour';
                $v['productid'] = $v['tourcode'];
                $historyData[$v['tourcode']] = $v;
            }
        }
        if ($actIds) {
            $actList =  $tourList = array();;
            foreach ($actList as $v) {
                $v['subject'] = 'act';
                $v['productid'] = $v['actid'];
                $historyData[400000+$v['actid']] = $v;
            }
        }

        if ($pkTourcodes) {
            foreach ($pkTourcodes as $v) {
                $ptdata = array();
                if(!$ptdata['packid']) {
                    continue;
                }
                $ptdata['subject'] = 'packagetour';
                $ptdata['productid'] = pcodeToId($ptdata['packid']);
                $ptdata['cover'] = [];
                $historyData[$ptdata['pcode']] = $ptdata;
            }
        }
        $out = array();
        foreach($seq as $sid) {
            if ($historyData[$sid]) {
                $out[] = $historyData[$sid];
            }
        }
        return $out;
    }

    /**
     * 记录cookie记录
     * @param $code
     */
    public static function writeHistoryData($code) {
        $productCodes = array();
        $productCodes = self::removeHistoryData($code);

        array_unshift($productCodes, $code);
        if (count($productCodes) > 30) {
            $productCodes = array_slice($productCodes, 0, 30);
        }

        self::setHistoryCookie($productCodes);
    }

    /**
     * 删除记录
     * @param $code
     * @return array|string
     */
    public static function removeHistoryData($code)
    {
        $productHistory = static::getBrowsingForCookie();
        if(!$productHistory) return array();
        $data   = trim($productHistory, ',');
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
     */
    public static function setHistoryCookie($data) {
        $cookie = implode(',' ,$data);
        $cookie && $cookie .= ',';
        static::saveBrowsingForCookie($cookie);
        return;
    }

    private static function saveBrowsingForCookie($data)
    {
         $cookie = \Yii::$app->response->cookies;
         $cookie->add(new \yii\web\Cookie([
            'name' => 'product_browsing_history',
            'value' => $data,
            'domain' => DOMAIN_NAME,
            'expire' => 365
         ]));

    }

    private static function getBrowsingForCookie()
    {
        return $_COOKIE['product_browsing_history'];
        //$cookies = \Yii::$app->request->cookies;
        $cookies = \Yii::$app->response->cookies;
        return $cookies->get('product_browsing_history');
    }
}