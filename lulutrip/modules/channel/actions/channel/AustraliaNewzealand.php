<?php
/**
 * 澳新频道页
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\modules\channel\actions\channel;


use common\event\Language;
use lulutrip\components\Cookies;
use yii\base\Action;
use Yii;
use yii\base\Exception;

class AustraliaNewzealand extends Action
{
    public function run()
    {
        Yii::$app->controller->regionRoot = 'AU';
        $cookies = new Cookies();
        $cookies->setCookies('navigationtype', Yii::$app->controller->regionRoot);
        $api = Yii::$app->params['service']['api'];
        $lang = (new Language())->get();
        try{
            $data = Yii::$app->cache->get('cache_australia_newzealand_' . $lang);
        } catch (Exception $e) {
            $data = [];
        }

        if(empty($data) || Yii::$app->controller->_refresh == 1) {
            //广告
            $banners = Yii::$app->helper->curlGet($api.'/channel/common/get-banner/'.Yii::$app->controller->regionRoot);
            $data = $banners['data'];

            //公告
            $notice = Yii::$app->helper->curlGet($api.'/channel/common/get-notice/AU/1');
            $data['notice'] = $notice['data'];

            //目的地推荐
            $result = Yii::$app->helper->curlGet($api . "/channel/common/get-pagecont/" . Yii::$app->controller->regionRoot);
            $data = $data + $result['data'];
            //澳新频道页首个tab 6个产品标签写死 Jennifer需求
//            $array = ['澳大利亚', '澳大利亚', '澳新连线', '新西兰', '新西兰', '新西兰'];
//            foreach ($data['pagecontsProduct'] as $key => &$value){
//                if($key == 0){
//                    foreach ($value['pagecontstag'] as $kkey => $val){
//                        $value['pagecontstag'][$kkey]['title'] = $array[$kkey];
//                    }
//                }
//            }

            //新奇目的地
            $result = Yii::$app->helper->curlGet($api . "/channel/common/get-destination/" . Yii::$app->controller->regionRoot . "/3");
            $data['destinations'] = $result['data'];

            //本月赞品
            $result = Yii::$app->helper->curlGet($api . "/channel/common/get-month-rec/AU");
            $data['monthRec'] = $result['data'];

            //精选攻略
            $result = Yii::$app->helper->curlGet($api . "/channel/common/get-article/" . Yii::$app->controller->regionRoot . "/6");
            $data['articles'] = $result['data'];

            //路路资讯+路路问答+路路结伴
            $result = Yii::$app->helper->curlGet($api . "/channel/common/get-message/" . Yii::$app->controller->regionRoot);
            $data['messages'] = $result['data'];

            //亲友小团
            $tourCodes = '11713,13588,12402,11887';
            $result = Yii::$app->helper->curlGet($api . "/channel/common/get-small-tour/" . $tourCodes);
            $data['smallTour'] = $result['data'];

            Yii::$app->cache->set('cache_australia_newzealand_' . $lang, $data, 3600);
        }

        //三条线路玩透新西兰南岛
        $tourCodes = [5947,8591,3950];
        $result = Yii::$app->helper->curlPost($api . "/tour/get-tour-more", ['tourCodes' => $tourCodes, 'currency' => Yii::$app->params['curCurrency']]);
        $data['monthRec'] = $result['data'];


        $scenes = \Yii::$app->controller->_sceneData;
        $data['sceneAll'] = $scenes['scenes'];

        return $this->controller->render("australia", $data);
    }
} 