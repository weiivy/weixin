<?php
namespace lulutrip\modules\tour\library\lists;

use yii\base\Component;
use Yii;

class GetRequestData extends Component
{
    /**
     * @Summary:获取参数，参数过滤处理
     * @Author: Serena Liu<serena@lulutrip.com>
     * @Param:
     * @Return: array $params
     * @Data:   2015.4.3
     */
    public function getRequestData($params){
        $prmRelArr = array(
            'id' => 'poi',
            'regionArr' => 'tripLine', //continent可不传
            'daysArr' => 'duration',
            'countriesArr' => 'countries',
            'citiesArr' => 'startLocation',
            'scenesArr' => 'includeScenic',
            'noscenesArr' => 'excludeScenic',
            'featuresArr' => 'featureTag',
//            'linesArr' => 'tripLine',  暂不做
            'endpointArr' => 'endLocation',
            'saleactArr' => 'promotionTag',
            'areaplayArr' => 'lineTag',
            'serviceArr' => 'addedService',
            'start_from' => 'dateRangeStart',
            'start_to'  => 'dateRangeEnd',
//            'orderby', 注释掉的 都是不需要被unset的 勿删
//            'order',
            'icf',
            'sellable',
            'pkl',
            'tourgrade',
            'page' => 'startFrom',
//            'refresh',
//            'lang',
//            'isshowline' => 'intelligentMerge', 暂不做
            'keyword' => 'keyword',
            'isAjax',
            'minday',
            'maxday',
            'currency' => 'currency',
        );
        $data = array();
        foreach ($prmRelArr as $key => $val){
            if(!is_numeric($key) && isset($params[$key])){
                $data[$val] = $params[$key];
            }else{
                unset($params[$val]);
            }
        }
        isset($params['orderby']) && $data['sort'] = array('field' => $params['orderby'], 'order' => $params['order']);
        $data['categories'] = array('localjoin');
        //处理黄石, 区域黄石公园，需获取scene=1的数据
        if(in_array('Yellowstone', $data['tripLine'])){
            $keyTmp = array_search('Yellowstone', $data['tripLine']);
            array_splice($data['tripLine'], $keyTmp, 1);
            if(count($data['tripLine']) == 0) unset($data['tripLine']);

            if(isset($data['includeScenic'])){
                $data['includeScenic'] = array_merge(array('1'), $data['includeScenic']);
            }else{
                $data['includeScenic'] = array('1');
            }
        }


        //获取榜单产品编码
       /* $bang = RecTours::getTrCdsByRec();
        $keys = $this->getKeyFields($params);

        isset($bang[$keys['keyStr']]) && $data['productCodes'] = array_reverse(explode(',', $bang[$keys['keyStr']]));*/

        //获取当前币种
        $data['currency'] = Yii::$app->params['curCurrency'] != 'RMB' ? Yii::$app->params['curCurrency']: 'CNY';
        return $data;
    }
    /**
     * 获取key值
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @copyright 2017-07-30
     * @param array $params
     * @return array
     */
    private function getKeyFields($params)
    {
        $region = 'NA';
        if(!empty($params['region'])){
            $region = $params['region'];
        }
        //榜单相关条件
        $tmpParams = array('scenes', 'cities', 'features', 'saleact', 'days');
        $keyStr = 'area-' . $params['region'];

        foreach ($tmpParams as $pv){
            if(isset($params[$pv]) && !empty($params[$pv])){
                if($pv == 'days' && count($params['daysArr']) == 2) {
                    $dayArr = $params['daysArr'];
                    sort($dayArr);
                    $keyStr .= '_' . $pv . '-' . implode('', $dayArr);
                } else {
                    $keyStr .= '_' . $pv . '-' . $params[$pv];
                }
            }
        }

        if(isset($params['id'])){
            $keyStr .= '_scenes-' . $params['id'];
        }

        $keyStr = $this->getBangListKey($keyStr);
        return array('keyStr' => $keyStr);
    }
    /**
     * 生成列表页的推荐tourcode
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @copyright 2017-08-08
     * @return array
     */
    private function getBangListKey($kKey)
    {
        preg_match('/^area\-(?:[^\_]+)$/', $kKey, $matches);
        if(isset($matches[0]))
        {
            return $matches[0];
        }
        //北美,欧洲景点列表的推荐，也适用于区域列表页的景点选项
        preg_match('/^area\-(?:NA|EU|AU)_scenes\-([0-9]+)$/', $kKey, $matches);
        if(isset($matches[0]))
        {
            return $matches[0];
        }
        //区域&&天数，复合条件推荐
        preg_match('/^(?:area|countries)\-(?:[^\_]+)_days\-([0-9]+)$/', $kKey, $matches);
        if(isset($matches[0]))
        {
            return $matches[0];
        }
        //景点&&天数，复合条件推荐
        preg_match('/^area\-(?:NA|EU|AU)_days\-([0-9]+)_scenes\-([0-9]+)$/', $kKey, $matches);
        if(isset($matches[0]))
        {
            return $matches[0];
        }
        unset($matches);
        preg_match('/^area\-(?:[^\_]+)_([^\_]+\-[^\_]+)$/', $kKey, $matches);
        return isset($matches[1]) ? $matches[1] : '';
    }
}