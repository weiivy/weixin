<?php
/**
 * @copyright (c) 2017, lulutrip.com
 * @author LT<todd@lulutrip.com>
 */
namespace lulutrip\actions\cruise;

use lulutrip\library\Seotdk;
use yii\base\Action;
use linslin\yii2\curl\Curl;
use Yii;
use lulutrip\components\Cookies;

class SearchCruise extends Action
{
    public function run()
    {
        $curl = new Curl();
        $get = $param = Yii::$app->request->get();
        unset($get['url']);
        $get = http_build_query($get);
        $curl->setOption(CURLOPT_TIMEOUT, 60);
        $search = $curl->get(Yii::$app->params['service']['api'] . '/cruise/search-cruise?' . $get);
        //echo $search;die;
        $search = json_decode($search, true);
        $cookie = new Cookies();
        $navigationtype = $cookie->getCookies('navigationtype', 'NA');
        list(\Yii::$app->controller->pageTitle, \Yii::$app->controller->pageKeywords, \Yii::$app->controller->pageDesc) = (new Seotdk())->setDynTDK('cruise', 'search', 'multiple', [
            't_pattern1' => $search['data']['selected']['dst'],
            't_pattern2' => $param['prt'] ? "（{$search['data']['selected']['prt']}出发）" : "",
            't_pattern3' => $param['crl'] ? $search['data']['selected']['crl'] : "",
        ]);
//        print_r($search['data']['newFilter']);
//        echo "<br>".count($search['data']['staticFilter']['dst'])."<br>";
//        print_r($search['data']['filter']['prt']);
//        echo "<br>".count($search['data']['filter']['prt'])."<br>";
//        print_r($search['data']['selectedFilter']['prt']);
//        var_dump(in_array('1-2', $search['data']['selectedFilter']['dep']));
//        var_dump($search['data']['staticFilter']['destination'], $search['data']['filter'], $search['data']['selectedFilter']);//die;

        return $this->controller->render("destination", [
            'navigationtype'  => $navigationtype,
            'destination' => $search['data']['staticFilter']['destination'],
            'line' => $search['data']['staticFilter']['line'],
            'port' => $search['data']['staticFilter']['port'],
            'dep' => $search['data']['staticFilter']['dep'],
            'tod' => $search['data']['staticFilter']['tod'],
            'length' => $search['data']['staticFilter']['length'],
            'cruise' => $search['data']['item'],
            'num' => $search['data']['num'],
            'selected' => $search['data']['selected'],
            'param' => $search['data']['param'],
            'filter' => $search['data']['filter'],
            'newFilter' => $search['data']['newFilter'],
            'selectedFilter' => $search['data']['selectedFilter'],
            'naviPage' => $search['data']['naviPage'],
            'sort' => $search['data']['sort'],
        ]);
    }
}