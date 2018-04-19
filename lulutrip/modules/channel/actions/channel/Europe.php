<?php
/**
 * 欧洲频道页
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\modules\channel\actions\channel;


use common\event\Language;
use lulutrip\components\Cookies;
use yii\base\Action;
use Yii;
use yii\base\Exception;

class Europe extends Action
{
    public function run()
    {
        Yii::$app->controller->regionRoot = 'EU';
        $cookies = new Cookies();
        $cookies->setCookies('navigationtype', Yii::$app->controller->regionRoot);
        $api = Yii::$app->params['service']['api'];
        $lang = (new Language())->get();
        try{
            $data = Yii::$app->cache->get('cache_europe_' . $lang);
        } catch (Exception $e) {
            $data = [];
        }

        if(empty($data) || Yii::$app->controller->_refresh == 1) {
            //广告
            $banners = Yii::$app->helper->curlGet($api.'/channel/common/get-banner/'.Yii::$app->controller->regionRoot);
            $data = $banners['data'];

            //公告
            $notice = Yii::$app->helper->curlGet($api.'/channel/common/get-notice/EU/1');
            $data['notice'] = $notice['data'];

            //目的地推荐
            $result = Yii::$app->helper->curlGet($api . "/channel/common/get-pagecont/" . Yii::$app->controller->regionRoot);
            $data = $data + $result['data'];

            //新奇目的地
            $result = Yii::$app->helper->curlGet($api . "/channel/common/get-destination/" . Yii::$app->controller->regionRoot . "/5");
            $data['destinations'] = $result['data'];

            //融入当地
            //$result = Yii::$app->helper->curlGet($api . "/channel/europe/get-festivals");
            //$data['festivals'] = $result['data'];

            //本月赞品
            $result = Yii::$app->helper->curlGet($api . "/channel/common/get-month-rec/EU");
            $data['monthRec'] = $result['data'];

            //自助游精选目的地
            $result = Yii::$app->helper->curlGet($api . "/channel/europe/get-activity-rec");
            $data['activityRec'] = $result['data'];

            //更当地的欧洲
            $result = Yii::$app->helper->curlGet($api . "/channel/common/get-article/" . Yii::$app->controller->regionRoot . "/4");
            $data['articles'] =  $result['data'];

            //路路资讯+路路问答+路路结伴
            $result = Yii::$app->helper->curlGet($api . "/channel/common/get-message/" . Yii::$app->controller->regionRoot);
            $data['messages'] = $result['data'];

            Yii::$app->cache->set('cache_europe_' . $lang, $data, 3600);
        }

        $scenes = \Yii::$app->controller->_sceneData;
        $data['sceneAll'] = $scenes['scenes'];

        return $this->controller->render("europe", $data);
    }
} 