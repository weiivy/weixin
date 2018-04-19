<?php

/**
 * 个性化定制产品列表页
 * @copyright (c) 2017, lulutrip.com
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\customized\actions\customized;

use lulutrip\library\common\ListPage;
use lulutrip\library\Seotdk;
use linslin\yii2\curl\Curl;
use yii\base\Action;
use yii;

class Entry extends Action
{
    public $_baseUrl;

    public function run () {
        $region     = Yii::$app->request->get('region') ? Yii::$app->request->get('region') : '';
        $days       = Yii::$app->request->get('days') ? Yii::$app->request->get('days') : '';
        $startcity  = Yii::$app->request->get('startcity') ? Yii::$app->request->get('startcity') : '';
        $selectParam = [
            'region'    => $region,
            'days'      => $days,
            'startcity' => $startcity,
        ];
        $this->_baseUrl = '/customized/entry';
        //筛选条件
        $data['filters'] = $this->getFilter($selectParam);
        //分页相关数据
        $page = \Yii::$app->request->get('page', 1);
        $pageSize = 10;
        $curl = new Curl();
        $curl->reset()->setOption(CURLOPT_POSTFIELDS, http_build_query($selectParam))
                ->post(\Yii::$app->params['service']['api'] . "/customized/get-list/" . implode('/', array($page, $pageSize)));
        $return = json_decode($curl->response, true);

        if(!empty($return['data']['products'])){
            //分页
            $selectParam['page'] = $page;
            $selectParam = $this->sortFilter($selectParam);
            $link = $this->_baseUrl . \Yii::$app->helper->mergeUrl($selectParam);
            $link = str_replace('page-' . $page, 'page-{{page}}', $link);
            $listpage = new ListPage($page, $pageSize, $return['data']['count'], $link);
            $data['pageData'] =  $listpage->getPageDots();
        }
        $data['products'] = $return['data']['products'];
        foreach ($data['products'] as $key => $pt) {
            $data['products'][$key]['link'] = '/privatetour/ptourcode-' . $pt['ptourcode'];
        }

        //客服电话
        $staticNav = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . '/get-static-nav');
        $data['phones'] = $staticNav['data']['IpPhone'];
        return $this->controller->render('@lulutrip/modules/customized/views/customized/entry', $data);
    }

    /**
     * 获取筛选数据
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-08-09
     * @param $selectParam
     * @return mixed
     */
    public function getFilter($selectParam) {
        $curl = new Curl();
        $curl->reset()->setOption(CURLOPT_POSTFIELDS, http_build_query($selectParam))
            ->post(\Yii::$app->params['service']['api'] . "/customized/get-head");
        $return = json_decode($curl->response, true);

        // 游玩区域 region
        $regions = $return['data']['region'];
        $filters['region']['all'] = array('name' => '全部', 'url' => $this->_baseUrl);
        foreach ($regions as $key => $value) {
            $filters['region'][$key] = array('name' => $value, 'url' => $this->_baseUrl . Yii::$app->helper->mergeUrl(['region' => $key]));
        }

        //行程天数  days
        $filters['days'] = array('r1' => '1-3天', 'r2' => '4-6天', 'r3' => '7-10天', 'r4' => '10天以上');
        $filters['days'] = $this->getUrl($filters['days'], $selectParam, 'days');

        //出发城市  startcity
        $startcity = $return['data']['startcity'];
        $filters['startcity'] = $this->getUrl($startcity, $selectParam, 'startcity');

        //tdk
        static::setSeo($filters);

        return $filters;
    }

    /**
     * 重组URL
     * @copyright (c) 2017, lulutrip.com
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @param $filter
     * @param $selectParams
     * @param $filterType
     * @return mixed
     */
    public function getUrl ($filter, $selectParams, $filterType) {
        $allParams = $selectParams;
        unset($allParams[$filterType]);
        $temp['all'] = array('name' => '全部', 'url' => $this->_baseUrl . Yii::$app->helper->mergeUrl($allParams));
        foreach ($filter as $key => $value) {
            $tempParams = $selectParams;
            if (!empty($tempParams[$filterType])) {
                unset($tempParams[$filterType]);
                if ($selectParams[$filterType] !== $key) $tempParams[$filterType] = $key;
            } else {
                $tempParams[$filterType] = $key;
            }

            //重新生成路由
            $tempParams = $this->sortFilter($tempParams);
            $temp[$key] = array('name' => $value, 'url' => $this->_baseUrl . Yii::$app->helper->mergeUrl($tempParams));
        }
        return $temp;
    }

    /**
     * 对参数排序
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-08-09
     * @param $tempParams
     * @return array
     */
    public function sortFilter($tempParams){
        $temp = array();
        foreach(array('region', 'days', 'startcity', 'page') as $value) {
            if(!isset($tempParams[$value])) {
                continue;
            }
            $temp[$value] = $tempParams[$value];
        }
        return $temp;
    }

    /**
     * 设置SEO
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-08-09
     * @param $filters
     */
    private static function setSeo($filters) {
        $region = Yii::$app->request->get('region');
        $days   = Yii::$app->request->get('days');

        $tdk_pattern['t_pattern1'] = '';
        $tdk_pattern['t_pattern2'] = '';
        $tdk_pattern['t_pattern3'] = '';
        if( empty($region) ) {
            $tdk_pattern['t_pattern1'] = '';
        } else {
            $tdk_pattern['t_pattern1'] = $filters['region'][$region]['name'];
        }
        if( empty($days) ) {
            $tdk_pattern['t_pattern2'] = '';
        } else {
            foreach($filters['days'] as $k => $v) {
                if($days == $k) {
                    $tdk_pattern['t_pattern2'] = $v['name'];
                }
            }
        }
        $seoDtk = new Seotdk();
        list(\Yii::$app->controller->pageTitle, \Yii::$app->controller->pageKeywords, \Yii::$app->controller->pageDesc) = $seoDtk->setDynTDK('privatetour', 'entry', 'multiple', $tdk_pattern);

    }
}