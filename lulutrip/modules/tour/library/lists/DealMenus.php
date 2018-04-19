<?php
namespace lulutrip\modules\tour\library\lists;

use common\library\base\Data;
use common\models\tours\Tourslist;
use yii\base\Component;
use yii;

class DealMenus extends Component
{
    public $_params = [];
    public $_www = '';
    public $regionRoot = 'NA';
    public $_reParam = array();

    /**
     * 按顺序组合url
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @copyright 2017-07-29
     * @param array $params
     * @return string
     */
    public function mergeUrl($params = array())
    {
        $this->_www = Yii::$app->params['service']['www'];
        $params = $params ? $params : $this->_params;
        $curUrl = $this->_www . '/tour';
        if(!empty($params['keyword']))
        {
            $curUrl = $this->_www . '/search/tour';
            if(!empty($params['region'])) {
                $curUrl .= '/region-' . trim($params['region'], '|');
            }
        }
        elseif(isset($params['id']))
        {
            $rUrl = '';
            if(in_array($this->regionRoot, array('EU', 'AU')))
            {
//                $rUrl = '/region-' . $this->regionRoot;
                $rUrl = '/region-' . $params['region'];
            }
            $curUrl .= '/destination' . $rUrl . '/id-' . $params['id'];
        }
        else
        {
            if($this->regionRoot == 'NA' && $params['region'] != 'CA')
            {
                $curUrl .= '/north_america/region-' . $params['region'];
            }
            else
            {
                $curUrl .= '/destination/region-' . $params['region'];
            }
        }
        $reParam = $this->_reParam;
//        var_dump($reParam);die;
        $urlArr = [];
        //为了按顺序整合url, 故用了数组形式
        foreach($reParam as $key => $val)
        {
            if(isset($params[$val]) && !empty($params[$val]))
            {
                $urlArr[] = $key . '-' . $params[$val];
            }
        }
        if(!empty($urlArr))
        {
            $url = $curUrl . '_' . implode('_', $urlArr);
        }
        else
        {
            $url = $curUrl;
        }
        //=======?问号后面的参数 组合==========
        //允许组合url的键值
        $allowPrms = array('saleact', 'service', 'areaplay', 'orderby', 'order', 'page', 'endpoint', 'keyword');
        $suParams = array();
        foreach ($allowPrms as $val){
            if(isset($params[$val]) && !empty($params[$val])){
                $suParams[$val] = $params[$val];
            }
        }
        if(isset($suParams['page']) && $suParams['page'] == 1){
            unset($suParams['page']);
        }
        if(empty($suParams)){
            return $url;
        }

        $urlArr2 = [];

        foreach($suParams as $key => $val)
        {
            $urlArr2[] = $key . '=' . $val;
        }

        if(!empty($urlArr2)){
            $url .= '?' . implode('&', $urlArr2);
        }

        return $url;
    }
    /**
     * 定义菜单
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @copyright 2017-07-29
     * @return array
     */
    private function defineMenus(){
        $menus = array(
            //产品小类
            'sub_type' => array('prmKey' => 'subType'),
            //游玩地点
            'area' => array('prmKey' => 'region'),
            //国家
            'country' => array('prmKey' => 'countries'),
            //行程天数
            'duration' => array('prmKey' => 'days'),
            //参团地点 带大写首字母
            'start_location' => array('prmKey' => 'cities'),
            //包含景区 带大写首字母
            'middle_location' => array('prmKey' => 'scenes'),
            //不玩哪些
            'exclude_scenic' => array('prmKey' => 'noscenes'),
            //离团地点 带大写首字母
            'end_location' => array('prmKey' => 'endpoint'),
            //行程特色 带大写首字母
            'feature_tag' => array('prmKey' => 'features'),
            //优惠促销
            'promotion_tag' => array('prmKey' => 'saleact'),
            //附加服务
            'added_service' => array('prmKey' => 'service'),
            //线路玩法
            'line_tag' => array('prmKey' => 'areaplay'),
        );
        return $menus;
    }
    /**
     * 处理菜单
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @copyright 2017-07-29
     * @param array $data 接口过来的菜单数据
     * @param array $params $_GET参数
     * @param array $reParam 重写的参数
     * @return array
     */
    public function dealMenus($data, $params, $reParam){
        //去除页码
        if(isset($params['page'])) unset($params['page']);
        $this->_params = $params;
        $this->_reParam = $reParam;
        $menus = $this->defineMenus();
        $return = \Yii::$app->helper->curlGet(\Yii::$app->params['service']['api'] . "/setting/get-filter-setting/ListSales");
        $items = [];
        if(!empty($return['data'])){
            foreach ((array)$return['data'] as $val){
                $arr = unserialize($val);
                $items[$arr[0]] = $arr[1];
            }
        }


        foreach ($data as $mVal){
            $capitals = array();
            $prmKey = $menus[$mVal['field']]['prmKey'];

            //选中的排在最前面
            if($mVal['field'] != 'duration') $mVal['facetItems'] = $this->selectParamsSort($this->_params, $prmKey, $mVal['facetItems']);

            foreach ($mVal['facetItems'] as $facetKey => $facetVal){
                //获取大写字母
                if(in_array($mVal['field'], array('start_location', 'middle_location', 'end_location', 'exclude_scenic'))) {
                    $capitals += $this->dealCapitals($facetVal['firstLetter']);
                }
                //设置url 带重写的参数
                if($prmKey == 'subType'){
                    $tPrms = array('region' => $params['region']);
                    isset($params['id']) && $tPrms['id'] = $params['id'];
                    $tmpUrl = $this->mergeUrl($tPrms);
                    $tmpUrl = ($facetVal['key'] == 0) ? $tmpUrl : $tmpUrl . '_cat-' . $facetVal['key'];
                }else{
                    //完全相等的情况
                    if(isset($params[$prmKey . 'Arr']) && count($params[$prmKey . 'Arr']) == 1 && in_array($facetVal['key'], $params[$prmKey . 'Arr'])){
                        $paramVal = '';
                        if($prmKey == 'region'){
                            $paramVal = $this->regionRoot;
                        }
                    //包含的情况
                    }elseif(isset($params[$prmKey . 'Arr']) && in_array($facetVal['key'], $params[$prmKey . 'Arr'])){
                        $prmTmp = $params[$prmKey . 'Arr'];
                        $keyTmp = array_search($facetVal['key'], $prmTmp);
                        array_splice($prmTmp, $keyTmp, 1);
                        $paramVal = implode('|', $prmTmp);
                    //该菜单被选中 但不等于的情况
                    }elseif(isset($params[$prmKey . 'Arr'])){
                        $paramVal = empty($params[$prmKey]) ? $facetVal['key'] : $params[$prmKey] . '|' . $facetVal['key'];
                        //处理非大洲时，不带大洲参数
                        $first = $params[$prmKey . 'Arr'][0];
                        if($prmKey == 'region' && in_array($first, ['NA', 'EU', 'AU'])) {
                            $paramVal = $facetVal['key'];
                        }

                    } else {
                        $paramVal = $facetVal['key'];
                    }
                    //组合url
                    $prmTmp = $this->_params;
                    $prmTmp[$prmKey] = $paramVal;
                    if(isset($params['keyword']) && empty($params['regionArr'])) $prmTmp['regionArr'][] = $facetVal['key'];
                    $tmpUrl = $this->mergeUrl($prmTmp);
                    if($prmKey == 'saleact'){
                        if(!empty($items[$facetVal['displayName']])) $mVal['facetItems'][$facetKey]['title'] = $items[$facetVal['displayName']];
                    }
                }


                $mVal['facetItems'][$facetKey]['url'] = $tmpUrl;
            }

            if(!empty($capitals)){
                $menus[$mVal['field']]['capitals'] = $capitals;
            }
            $menus[$mVal['field']]['facetItems'] = $mVal['facetItems'];

        }
        return $menus;
    }
    /**
     * 处理大写字母
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @copyright 2017-07-29
     * @param array $fChar 大写字母
     * @return array
     */
    private function dealCapitals($fChar){
        $capitals = array();
        if($fChar >= 'A' && $fChar <= 'Z') {
            $capitals[$fChar] = 1;
        } else {
            $capitals['other'] = 1;
        }
        return $capitals;
    }


    /**
     * 处理其他菜单路由
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-08-03
     * @param $params
     * @return array 返回数据
     */
    public function setOtherMenuUrl($params)
    {
        $region = $params['regionArr'][0];
        $id     = isset($params['id']) ? $params['id'] : '';
        $carUrl = 'https://diy.lulutrip.com/car';
        if($params['region'] == 'USWest' || in_array('USWest', $params['regionArr'])){
            $carUrl = $this->_www . '/themes/self_driving';
        }

        //当地游玩
        $data['activity']= [
            'name' => '当地玩乐',
            'url'  =>  '/activity/entry'
        ];
        $data['activity']['url'] = $this->mergeOtherUrl($data['activity']['url'], 'region-', array_pop($params['regionArr']));
        $data['activity']['url'] =  $id ? $this->mergeOtherUrl($data['activity']['url'], 's-', $id, "_") : $data['activity']['url'];

        
        //包车旅游
        $data['bus']= [
            'name' => '中文包车',
            'url'  =>  '/private/bus'
        ];
        $data['bus']['url'] = $this->mergeOtherUrl($data['bus']['url'], 'region-', in_array($region, ['NA', 'EU', 'AU']) ? $region : 'NA');
        $data['bus']['url'] =  $id ? $this->mergeOtherUrl($data['bus']['url'], 'scene=', $id, "?") : $data['bus']['url'];

        //接送服务
        $data['transfer'] = [
            'name' => '接送服务',
            'url'  => 'https://diy.lulutrip.com/transfer'
        ];

        return $data;

    }


    /**
     * 拼接路由
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-08-03
     * @param $url
     * @param $field
     * @param $value
     * @param string $connectFlag
     * @return string
     */
    public function mergeOtherUrl($url, $field, $value, $connectFlag = '/')
    {
        return $url . $connectFlag . "{$field}" . $value;
    }

    /**
     * 筛选项选中值排序
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-08-08
     * @param $params
     * @param $field
     * @param $data
     * @return array 返回数据
     */
    public function selectParamsSort($params, $field, $data)
    {
        if(!isset($params[$field. 'Arr'])) return $data;
        $fieldArr = $params[$field. 'Arr'];
        $temp = [];
        foreach($data as $key => $value) {
            if(in_array($value['key'], $fieldArr)) {
                $temp[] = $value;
                unset($data[$key]);
            }
        }
        return array_merge($temp, $data);
    }
}