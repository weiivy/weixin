<?php
/**
 * 标准化包团列表页action
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\actions\packagetour;

use common\library\base\Data;
use linslin\yii2\curl\Curl;
use lulutrip\library\common\ListPage;
use lulutrip\library\Seotdk;
use yii\base\Action;
use yii\helpers\Url;
use Yii;

class Entry extends Action
{
    public $cities;
    public $_baseUrl;
    public $productIds;

    public function run()
    {
        $get = \Yii::$app->request->get();
        unset($get['url']);
        $this->_baseUrl = '/privatetour/entry';
        //分页相关数据
        $page = \Yii::$app->request->get('page', 1);
        $pageSize = 10;

        $data['themesData'] = \Yii::$app->controller->_themeData;

        $curl = new Curl();
        //获取城市数据
        $this->cities = Data::getCities()['cities'];
        $data['filters'] = $this->getFilter($curl, $get);
        //游玩主题
        foreach ($data['filters']['theme'] as $key => $val){
            if(array_key_exists($key, $data['themesData'])){
                $data['filters']['theme'][$key]['name'] = $data['themesData'][$key];
            }
        }

        //获取包团数据
        $post = $get;
        if(isset($post['days'])) {
            $post['tourlen'] = $post['days'];

            unset($post['days']);
        }
        $curl->reset()->setOption(
            CURLOPT_POSTFIELDS,
            http_build_query($post))->post(\Yii::$app->params['service']['api'] . "/package-tour/list/" . implode('/', array($page, $pageSize)));
        $return = json_decode($curl->response, true);
        $data['packagetours'] = $return['data']['data'];
        foreach ($data['packagetours'] as $k => $v) {
            $this->productIds[] = (int)$v['packid'] + 800000;
        }

        if(!empty($return['data']['data'])){
            //分页
            $get['page'] = $page;
            $get = $this->sortFilter($get);
            $link = $this->_baseUrl . \Yii::$app->helper->mergeUrl($get);
            $link = str_replace('page-' . $page, 'page-{{page}}', $link);
            $listpage = new ListPage($page, $pageSize, $return['data']['count'], $link);
            $data['pageData'] =  $listpage->getPageDots();
            $data['cities'] = $this->cities;
        }

        $region = $get['region'];
        if(!in_array($get['region'], array('EU', 'AU')))
        {
            $region = 'NA';
        }
        \Yii::$app->controller->callmenowRegion = $region;
        \Yii::$app->controller->regionRoot = $region;

        return $this->controller->render('@lulutrip/views/package-tour/entry', $data);
    }


    /**
     * 获取筛选数据
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-02-08
     * @param Curl $curl
     * @param $selectParams
     * @return mixed
     */
    public  function getFilter(Curl $curl, $selectParams)
    {
        //游玩区域和行程天数默认显示所有
        $filters['region'] = array(
            'all'  => array('name' => '全部', 'url' => '/privatetour/entry'),
            'USWest'  => array('name' => '美国西部', 'url' => $this->_baseUrl . \Yii::$app->helper->mergeUrl(['region' => 'USWest'])),
            'USEast'  => array('name' => '美国东部', 'url' => $this->_baseUrl . \Yii::$app->helper->mergeUrl(['region' => 'USEast'])),
            'EU'      => array('name' => '欧洲', 'url' => $this->_baseUrl . \Yii::$app->helper->mergeUrl(['region' => 'EU'])),
            'AU'      => array('name' => '澳新', 'url' => $this->_baseUrl . \Yii::$app->helper->mergeUrl(['region' => 'AU'])),
            'Canada'      => array('name' => '加拿大', 'url' => $this->_baseUrl . \Yii::$app->helper->mergeUrl(['region' => 'Canada']))
        );
        $filters['days'] = array('r1' => '1-3天', 'r2' => '4-6天', 'r3' => '7-10天', 'r4' => '10天以上', );



        //获取主题及城市数据
        $post = $selectParams;

        if(isset($post['days'])) {
            $post['tourlen'] = $post['days'];

            unset($post['days']);
        }
        $result = $curl->reset()->setOption(
            CURLOPT_POSTFIELDS,
            http_build_query($post))->post(\Yii::$app->params['service']['api'] . "/package-tour/head");
        $return = json_decode($curl->response, true);
        $filters['theme'] = $return['data']['theme'];
        $filters['startcity'] = $return['data']['city'];

        //seo
        static::setSeo($filters);

        //处理个参数路由
        foreach($filters as $key => $filter) {
            switch($key)
            {
                case 'days':
                    $filters['days'] =$this->getUrl($filter, $selectParams, 'days');
                    break;
                case 'theme':
                    $filters['theme'] =$this->getUrl($filter, $selectParams, 'theme');;
                    break;
                case 'startcity':
                    $filters['startcity'] =$this->getUrl($filter, $selectParams, 'startcity');
                    break;
            }

        }

        return $filters;
    }

    /**
     * 获取筛选路由
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-02-08
     * @param $filter
     * @param $selectParams
     * @param $filterType
     * @return array
     */
    public  function getUrl($filter, $selectParams, $filterType)
    {
        $temp = array();

        //去除page
        if(isset($selectParams['page'])) {
            unset($selectParams['page']);
        }

        //处理全部
        $allTemp = $selectParams;
        if(isset($allTemp[$filterType])) {
            unset($allTemp[$filterType]);
        }

        $temp['all'] = array('name' => "全部", 'url' =>  $this->_baseUrl . \Yii::$app->helper->mergeUrl($allTemp));

        foreach($filter as $key => $value) {
            $tempParams = $selectParams;
            $urlParams = array();
            //将选中的数据过滤
            if($filterType == 'days') {
                if(!empty($tempParams[$filterType])) {
                    unset($tempParams[$filterType]);
                    if($selectParams[$filterType] != $key) $tempParams[$filterType] = $key;
                } else{
                    $tempParams[$filterType] = $key;
                }
            } else {
                if(!empty($tempParams[$filterType])) unset($tempParams[$filterType]);
                if(empty($selectParams[$filterType])){
                    $tempParams[$filterType] = $value;
                }
            }


            //重新生成路由
            $tempParams = $this->sortFilter($tempParams);
            $urlParams = array_merge($urlParams, $tempParams);
            $url = $this->_baseUrl . \Yii::$app->helper->mergeUrl($urlParams);

            $temp[in_array($filterType, array('theme', 'startcity')) ? $value : $key] = array('name' => $filterType == 'startcity' ? $this->cities[$value] : $value, 'url' => $url);
        }

        return $temp;
    }


    /**
     * 对参数排序
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-02-08
     * @param $tempParams
     * @return array
     */
    public function sortFilter($tempParams)
    {
        $temp = array();
       foreach(array('region', 'days', 'theme', 'startcity', 'page') as $value) {
           if(!isset($tempParams[$value])) {
               continue;
           }
           $temp[$value] = $tempParams[$value];
       }
       return $temp;
    }


    /**
     * 设置seo
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-02-08
     * @param $filters
     */
    private static function setSeo($filters)
    {
        $region = \Yii::$app->request->get('region', '');
        $days = \Yii::$app->request->get('days', '');
        $theme = \Yii::$app->request->get('theme', '');
        $tdk_pattern['t_pattern1'] = '';
        $tdk_pattern['t_pattern2'] = '';
        $tdk_pattern['t_pattern3'] = '';
        if( empty($region) ) {
            $tdk_pattern['t_pattern1'] = '';
        } else {
            $regions = array('USWest'  => '美国西部', 'USEast'  => '美国东部', 'Hawaii'  => '夏威夷', 'Canada'  => '加拿大', 'EU'  => '欧洲', 'AU'  => '澳新');
            $tdk_pattern['t_pattern1'] = $regions[$region];
        }
        if( empty($days) ) {
            $tdk_pattern['t_pattern2'] = '';
        } else {
            foreach($filters['days'] as $k => $v) {
                if($days == $k) {
                    $tdk_pattern['t_pattern2'] = $v;
                }
            }
        }

        if( empty($theme) ) {
            $tdk_pattern['t_pattern3'] = '';
        } else {
            foreach($filters['theme'] as $k => $v) {
                if($theme == $v) {
                    $tdk_pattern['t_pattern3'] = '(' . \Yii::$app->controller->_themeData[$v] . ')';
                }
            }
        }
        $seoDtk = new Seotdk();
        list(\Yii::$app->controller->pageTitle, \Yii::$app->controller->pageKeywords, \Yii::$app->controller->pageDesc) = $seoDtk->setDynTDK('privatetour', 'entry', 'multiple', $tdk_pattern);

    }

}