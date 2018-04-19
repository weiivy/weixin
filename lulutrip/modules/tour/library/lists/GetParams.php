<?php
namespace lulutrip\modules\tour\library\lists;

use common\library\base\Data;
use common\models\tours\Tourslist;
use yii\base\Component;

class GetParams extends Component
{
    /**
     * 获取参数，参数过滤处理
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @copyright 2017-07-30
     * @return array
     */
    public static function getParams()
    {
        $params           = array();
        isset($_GET['id']) && $params['id'] = intval($_GET['id']);
        $params['region']   = isset($_GET['region']) ? trim($_GET['region']) : 'NA';
        isset($params['region']) && $params['regionArr'] = explode('|', $params['region']);
        isset($_GET['subType']) && $params['subType']   = trim($_GET['subType']);
        isset($_GET['days']) && $params['days']   = trim($_GET['days']);
        isset($params['days']) && $params['daysArr'] = explode('|', $params['days']);
        isset($_GET['countries']) && $params['countries'] = trim($_GET['countries']); //针对欧洲
        isset($params['countries']) && $params['countriesArr'] = explode('|', $params['countries']);
        isset($_GET['cities']) && $params['cities'] = trim($_GET['cities']);
        isset($params['cities']) && $params['citiesArr'] = explode('|', $params['cities']);
        isset($_GET['scenes']) && $params['scenes'] = trim($_GET['scenes']);
        isset($params['scenes']) && $params['scenesArr'] = explode('|', $params['scenes']);
        isset($_GET['features']) && $params['features'] = trim($_GET['features']);
        isset($params['features']) && $params['featuresArr'] = explode('|', $params['features']);
//        isset($_GET['lines']) && $params['lines'] = trim($_GET['lines']);     //暂不做
//        isset($params['lines']) && $params['linesArr'] = explode('||', $params['lines']);     //暂不做
        isset($_GET['noscenes']) && $params['noscenes'] = trim($_GET['noscenes']);
        isset($params['noscenes']) && $params['noscenesArr'] = explode('|', $params['noscenes']);

        //获取问号后的参数
        $semPrms = explode('?', $_SERVER['REQUEST_URI']);
        if(!isset($semPrms[1])){
            $_GET['page'] = $params['page'] = 1;
            return $params;
        }
        $dyParams = urldecode($semPrms[1]);
        $dyParams && $dyParams = explode('&', $dyParams);
        //参数进行过滤
        $allowParams = array('endpoint','saleact', 'areaplay', 'service', 'start_from', 'start_to', 'orderby', 'order', 'icf', 'sellable', 'pkl', 'tourgrade', 'page', 'refresh', 'isshowline', 'keyword', 'isAjax', 'minday', 'maxday');//, 'lang'
        if(!empty($dyParams))
        {
            foreach($dyParams as $val)
            {
                $dyParam = explode('=', $val);
                if(!in_array($dyParam[0], $allowParams))
                {
                    continue;
                }
                elseif(in_array($dyParam[0], array('start_from', 'start_to', 'orderby', 'keyword')))
                {
                    $suPrmVl = trim(htmlspecialchars(strip_tags($dyParam[1])));
                    if($dyParam[0] == 'keyword' && count($params['regionArr']) == 1 && in_array($params['regionArr'][0], ['NA', 'EU', 'AU'])) {
                        $params['regionArr'] = [];
                        unset($params['region']);
                    }
                }
                elseif($dyParam[0] == 'order')
                {
                    $suPrmVl = trim(htmlspecialchars(strip_tags($dyParam[1])));
                    $suPrmVl = $suPrmVl ? $suPrmVl : 'DESC';
                }
                elseif(in_array($dyParam[0], array('page', 'minday', 'maxday')))
                {
                    $suPrmVl = intval($dyParam[1]) ? intval($dyParam[1]) : '1';
                }
                elseif($dyParam[0] == 'saleact')
                {
                    $suPrmVl = trim(htmlspecialchars(strip_tags($dyParam[1])));
                    $params['saleactArr'] = explode('|', $suPrmVl);
                }
                elseif($dyParam[0] == 'service')
                {
                    $suPrmVl = trim(htmlspecialchars(strip_tags($dyParam[1])));
                    $params['serviceArr'] = explode('|', $suPrmVl);
                }
                elseif($dyParam[0] == 'areaplay')
                {
                    $suPrmVl = trim(htmlspecialchars(strip_tags($dyParam[1])));
                    $params['areaplayArr'] = explode('|', $suPrmVl);
                }
                elseif($dyParam[0] == 'endpoint'){
                    $suPrmVl = trim(htmlspecialchars(strip_tags($dyParam[1])));
                    $params['endpointArr'] = explode('|', $suPrmVl);
                }
                else
                {
                    $suPrmVl = trim(htmlspecialchars(strip_tags($dyParam[1])));
                }
                $params[$dyParam[0]] = $suPrmVl;
            }
        }
        $_GET['page'] = $params['page'] = isset($params['page']) ? intval($params['page']) : 1;
        return $params;
    }
    /**
     * url 解析
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @copyright 2017-07-31
     * @param $url
     * @param $reParam
     * @param string $separator
     * @return array
     */
    public static function parseUrl($url, $reParam, $separator = '_'){
        $params = array();
        $uArr = explode($separator, $url);
        if(!isset($uArr[1]) && empty($uArr[0])){
            return $params;
        }

        //解析有ID值的
        preg_match('/^(?:region-([^\/]+)\/)?id-([0-9]+)$/', $uArr[0], $matches);
        if(count($matches) == 3){
            $params['region'] = empty($matches[1]) ? 'NA' : $matches[1];
            $params['id'] = $matches[2];
            unset($uArr[0]);
        }

        foreach ($uArr as $uVal){
            $tmpArr = explode('-', $uVal);
            $pKey = !empty($reParam[$tmpArr[0]]) ? $reParam[$tmpArr[0]] : $tmpArr[0];
            $params[$pKey] = $tmpArr[1];
        }
        return $params;
    }
}