<?php
/**
 * 旅行团Tdk
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\modules\tour\library\lists;


use yii\base\Component;
use yii\base\Exception;

class GetTdk extends Component
{
    private $_listTitle;
    private $_listDescription;
    private $_listKeyword;

    private $tdk = [
        0 => [
            'title' => "{area}{areaplay_serviceT}{area_sid}{cityT}{countries_scenes}{days}{features}{saleact}旅游团,华人旅行社,当地参团线路推荐_路路行旅游网",
            'description' => "路路行旅游网（www.lulutrip.com）为全球华人提供最佳的{scene_id}{areas_countries}旅游线路,包括{scene_id}{areas_countries}旅游最新线路报价、热门景点、旅游团、评价,并提供酒店预订、包车租车、预售活动门票等服务。",
            'keywords' => '',
        ],
        1 => [
            'title' => '{area}{areaplay_serviceT}{area_sid}{cityT}{countries_scenes}{days}跟团游{features},跟团游价格,跟团游线路,地接社_路路行旅游网',
            'description' => '路路行旅游网为您提供{area}{areaplay_serviceT}{area_sid}{cityT}{countries_scenes}{days}跟团游{features}线路报价与预订,当地跟团游、自由行当地玩乐、一日游、包车私家团等旅游订购服务,为您的旅行度假提供最专业高效的服务！',
            'keywords' => '出境跟团游,出境跟团游线路,路路行旅游网',
        ]
    ];

    /**
     * 获取列表页TDK
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-08-02
     * @param $reParams
     * @param $params
     * @param $breadData
     * @return array 返回数据
     */
    public function getListTdk($reParams, $params, $breadData)
    {
        if(!isset($reParams['subType'])) $reParams['subType'] = 0;
        $params = $this->formatParams($reParams, $params);

        $params['id'] = isset($params['id']) ? $params['id'] : '';
        if(!empty($params['regionArr'])) $params['region'] = implode('', array_slice($params['regionArr'], 0, 3));
        $flag = 0;
        foreach($reParams as $key => $value) {
            if(in_array($key, ['poi', 'region'])) {
                if(count($params['regionArr']) == 1) $flag = 1;
            } elseif(in_array($key, ['cities', 'features', 'saleact', 'scenes', 'days'])) {
                if($flag > 0) $flag--;
            }
        }
        //处理特殊区域title
        if ($flag == 1 && $reParams['subType'] == 0) {
            $this->_listTitle = "{area}{areaplay_serviceT}{area_sid}{cityT}{countries_scenes}旅游团_{area}{areaplay_serviceT}{area_sid}{cityT}{countries_scenes}旅游多少钱_{area}{areaplay_serviceT}{area_sid}{cityT}{countries_scenes}当地参团华人旅行社_路路行旅游网";
            if ($reParams['region'] == 'NA' && isset($reParams['id']) && $reParams['id']<= 0) {
                $this->_listTitle = '美洲旅游团_美洲旅游多少钱_美洲当地参团华人旅行社_路路行旅游网';
            } else if($reParams['region'] == 'USEast') {
                $this->_listTitle = '美东旅游团_美东旅游多少钱_美东当地参团华人旅行社_路路行旅游网';
            } else if($reParams['region'] == 'EU' && isset($reParams['id']) && $reParams['id'] <= 0) {
                $this->_listTitle = "欧洲旅游团_欧洲旅游多少钱_欧洲当地参团华人旅行社_路路行旅游网";
            } else if($reParams['region'] == 'EUWest') {
                $this->_listTitle = "西欧旅游团_西欧旅游多少钱_西欧当地参团华人旅行社_路路行旅游网";
            }
        }

        if(empty($this->_listTitle)) $this->_listTitle = $this->tdk[$reParams['subType']]['title'];
        if(empty($this->_listDescription)) $this->_listDescription = $this->tdk[$reParams['subType']]['description'];
        if(empty($this->_listKeyword)) $this->_listKeyword = $this->tdk[$reParams['subType']]['keywords'];


        $counScene = [];
        $params['countriesArr'] = isset($params['countriesArr']) ? $params['countriesArr'] : [];
        $params['scenesArr'] = isset($params['scenesArr']) ? $params['scenesArr'] : [];
        $params['citiesArr'] = isset($params['citiesArr']) ? $params['citiesArr'] : [];

        //处理多景点
        if(isset($reParams['scenes']) || isset($reParams['id'])) {
            $counScene = array_filter(array_merge((array)$params['id'], (array)$params['scenesArr']));
        }elseif(count($reParams['regionArr']) > 1) {
            $counScene = array_filter(array_merge((array)$params['regionArr'], (array)$params['scenesArr']));
        }
        $counScene = array_slice(array_unique($counScene), 0, 3);

        //特殊区域名称
        $tDArr = [
            'area' => '',
            'areaplay_serviceT' => '',
            'area_sid' => '',
            'cityT' => '',
            'countries_scenes' => '',
            'days' => '',
            'features' => '',
            'saleact' => '',
            'scene_id' => '',
            'areas_countries' => '',
        ];
        $tDArr['areas_countries'] = $tDArr['region'] = $params['region'];
        if($reParams['region'] == 'EUWest') {
            $tDArr['region'] = '西欧';
        }

        //出发城市、国家存在 不取区域
        if(!empty($params['cities']) || !empty($params['countries'])) {
            $tDArr['region'] = '';
        }

        $sName = $aName = '';
        //处理数据开始
        $tDArr['countries_scenes'] = implode('', $counScene);
        if(!empty( $tDArr['countries_scenes'])) {
            $tDArr['region'] = '';
        }
        $areaServ =  array_slice(array_filter((isset($params['areaplayArr']) ? (array)$params['areaplayArr'] : [])), 0, 2);
        if(!empty($areaServ)) {
            $tDArr['areaplay_serviceT'] = implode('_', $areaServ) . '_';
        } else {
            $tDArr['areaplay_serviceT'] = $tDArr['areaplay_serviceD'] = '';
        }

        //出发
        $tDArr['cityT'] = '';
        if(!empty($params['cities']))  {
            $tDArr['cityT'] = implode('', $params['citiesArr']) . '出发';
            $coSc = array_filter(array_merge($params['countriesArr'], $params['scenesArr'], (array)$params['id']));
            if(!empty($coSc)) {
                $tDArr['cityT'] = $tDArr['cityT'] . '去';
            }
        }

        //天数
        if(!empty($reParams['days'])) {
            $minDay = min($params['daysArr']);

            if(count($reParams['daysArr']) == 1){
                $tDArr['days'] = $minDay . "日";
            } else {
                $maxDay = max($params['daysArr']);
                $tDArr['days'] = $maxDay < 10 ? $minDay . "到" . $maxDay . "日" : "10日以上";
            }
        }

        //features
        if(!empty($params['featuresArr'])) {
            $tDArr['features'] = '(' . implode('、',$params['featuresArr']) . ')';
        }

        //saleact
        if(!empty($params['saleactArr'])) {
            $tDArr['saleact'] = implode('、',$params['saleactArr']);
        }

        //判断是景点列表还是区域列表
        if(!empty($params['id'])) {
            $tDArr['scene_id'] = $tDArr['area_sid'] = $sName = $params['id'];

            //countries_scenes 和 area_sid相等时 取countries_scenes
            if($tDArr['area_sid'] == $tDArr['countries_scenes'] || $tDArr['area_sid'] == $params['id']) {
                $tDArr['area_sid'] = '';
            }
            $tDArr['areas_countries'] = '';

        } else {
            $aName = $tDArr['region'];
            $tDArr['area_sid'] = $aName;
        }
        $params['area_sid'] = $tDArr['area_sid'];
        //基于serena tdk基础上，判断如果{days}前 {areaplay_serviceT}{area_sid}{cityT}{countries_scenes} 均为空，则显示{area}字段
        $tDArr['areaD'] = $tDArr['area'] = '';
        if (! ($tDArr['areaplay_serviceT'] || $tDArr['area_sid'] || $tDArr['cityT'] || $tDArr['countries_scenes'])) {
            if(!empty($reParams['suffix']['keyword'])) {
                $tDArr['area'] = $reParams['suffix']['keyword'];
            } else {
                $tDArr['area'] = $params['region'];
            }
            if (empty($tDArr['area'])) $tDArr['area'] = $params['region'];
            if ($reParams['id']) $tDArr['area'] = $params['id'];
        }
        if (empty($tDArr['area_sid_city_countries_scenes'])) {
            $tDArr['areaD'] = $tDArr['area'];
        }

        // 2016-01-26 欧洲旅行团通过id访问列表 title中显示的是国家【应为城市名称】 北美、澳新无此Bug
        if ($reParams['region'] == 'EU' && !empty($params['id'])) {
            if (empty($params['countries']) && empty($params['cities']) && empty($params['scenes'])) {
                $tDArr['countries_scenes'] = $sName;
            }
        } elseif(!empty($params['cities']) && empty($tDArr['countries_scenes'])) {
            //欧洲区域外的去哪里
            $tDArr['countries_scenes'] = $params['id'] ? $params['id'] : ($tDArr['area_sid'] ? $tDArr['area_sid'] : '');
            if($tDArr['countries_scenes'] == $tDArr['area_sid']) {
                $tDArr['area_sid'] = '';
            }
        }

        //统一替换title, description
        $arr_key = ['area', 'areaplay_serviceT', 'area_sid', 'cityT', 'countries_scenes', 'id', 'scene_id', 'areas_countries'];
        foreach($tDArr as $key => $val) {
            if(in_array($key, $arr_key) && empty($val)) $val = '';
            $this->_listTitle = str_replace('{' . $key . '}', $val, $this->_listTitle);
            $this->_listDescription = str_replace('{' . $key . '}', $val, $this->_listDescription);
            $this->_listKeyword = str_replace('{' . $key . '}', $val, $this->_listKeyword);

        }

        $breadData = array_column($breadData, 'displayName');
        return [
            'title' => $this->_listTitle,
            'keywords' => empty($this->_listKeyword) ? implode('旅游团,', array_reverse($breadData)) . '旅游团' : $this->_listKeyword,
            'description' => $this->_listDescription,
        ];
    }


    /**
     * 参数处理
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-08-03
     * @param $reParams
     * @param $params
     * @return array 返回数据
     */
    private function formatParams($reParams, $params)
    {
        $alisaInfo = $data = $poiTemp = [];

        //获取id-name参数对
        foreach($params as $key => $value) {
            if($key == 'poi') {
                $poiTemp[$value['id']] = trim($value['displayName']);
                $alisaInfo = $alisaInfo + $poiTemp;
                continue;
            }
            $temp = !empty($value) ? array_column($value, 'displayName', 'id') : [];
            $alisaInfo = $alisaInfo + $temp + $poiTemp;
        }

        //翻译参数
        foreach($reParams as $char => $paramChild) {
            if(in_array($char, ['daysArr', 'page'])) {
                $data[$char] = $paramChild;
                continue;
            }
            if(!is_array($paramChild)) {
                $data[$char] = isset($alisaInfo[$paramChild]) ? trim($alisaInfo[$paramChild]) : ($paramChild == 'Yellowstone' && $char== 'region'  ? $alisaInfo[1] : $paramChild);
                continue;
            }

            foreach($paramChild as $value) {
                $data[$char][] = isset($alisaInfo[$value]) ? trim($alisaInfo[$value]) : ($value== 'Yellowstone' && $char== 'regionArr' ? $alisaInfo[1] : $value);
            }
        }


        return $data;
    }
}