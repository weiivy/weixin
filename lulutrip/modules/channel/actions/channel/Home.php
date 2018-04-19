<?php
/**
 * 大首页
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\modules\channel\actions\channel;


use common\event\Language;
use lulutrip\components\Cookies;
use \yii\base\Action;
use Yii;
use yii\base\Exception;

class Home extends Action
{
    public function init()
    {
        //获取cookie参数
        $cookies = new Cookies();
        $navigationType = $cookies->getCookies('navigationtype');
        $visitHomePage = $cookies->getCookies('visitHomePage');

        //老客户访问首页时自动跳转，最后访问的频道页
        if(!empty($navigationType) and empty($visitHomePage) and in_array($navigationType, ['EU','AU'])) {
            //Sonic SEM投放UTM代码传递至跳转后页面
            $params = Yii::$app->params['service']['www'] . '/'. Yii::$app->controller->page[$navigationType];
            $urlTemp = explode("?", $_SERVER['REQUEST_URI']);
            if(count($urlTemp) > 1) {
                array_shift($urlTemp);
                $params .= "?". $urlTemp[0];
            }

            header("Location: $params", true, 301);
            exit;
        }

        //欧洲 澳新第一次来的用户会根据IP跳转至对应频道页
        if(empty($navigationType)) {
            //根据Ip获取当前的语言获取区域
            $location = Yii::$app->ip->matchArea(Yii::$app->ip->realIP());
            if(in_array($location['countrycode'], ['NZ', 'AU'])) {
                header("Location: ".Yii::$app->params['service']['www'] . '/australia_newzealand', true, 302);
                exit;
            } elseif(in_array($location['countrycode'], ['FR', 'GB', 'DE'])) {
                header("Location: ".Yii::$app->params['service']['www'] . '/europe', true, 302);
                exit;
            }
        }
    }


    public function run()
    {
        //设置
        $cookies = new Cookies();
        $cookies->setCookies('navigationtype', Yii::$app->controller->regionRoot);
        $api = Yii::$app->params['service']['api'];
        $lang = (new Language())->get();
        try{
            $data = Yii::$app->cache->get('cache_home_' . $lang);
        } catch (Exception $e) {
            $data = [];
        }

        if(empty($data) || Yii::$app->controller->_refresh == 1) {
            //广告
            $banners = Yii::$app->helper->curlGet($api.'/channel/common/get-banner/'.Yii::$app->controller->regionRoot);
            $data = $banners['data'];

            //公告
            $notice = Yii::$app->helper->curlGet($api.'/channel/common/get-notice/NA/1');
            $data['notice'] = $notice['data'];

            //本月赞品
            $result = Yii::$app->helper->curlGet($api . "/channel/common/get-month-rec/" . Yii::$app->controller->regionRoot);
            $data['monthRec'] = $result['data'];

            //秒杀
            $result = Yii::$app->helper->curlGet($api . "/channel/common/get-purchase/" . Yii::$app->controller->regionRoot);
            $data['purchases'] = $result['data'];

            //热门目的地
            $result = Yii::$app->helper->curlGet($api . "/channel/home/get-destination");
            $data['hotDestinations'] = $result['data'];

            //热门推荐
            $result = Yii::$app->helper->curlGet($api . "/channel/home/get-recommended");
            $data['recommendeds'] = $result['data'];

            //路路小众
            $result = Yii::$app->helper->curlGet($api . "/channel/common/get-destination/" . Yii::$app->controller->regionRoot . "/5");
            $data['destinations'] = $result['data'];

            //精选攻略
            $result = Yii::$app->helper->curlGet($api . "/channel/common/get-article/" . Yii::$app->controller->regionRoot . "/6");
            $data['articles'] = $result['data'];

            //行程管家
            $result = Yii::$app->helper->curlGet($api . "/channel/home/get-evaluation");
            $data['evaluations'] = $result['data'];

            //路路结伴
            //$result = Yii::$app->helper->curlGet($api . "/channel/home/get-topics");
            //$data['topics'] = $result['data'];

            //路路资讯+路路问答+路路结伴
            $result = Yii::$app->helper->curlGet($api . "/channel/common/get-message/" . Yii::$app->controller->regionRoot);
            $data['messages'] = $result['data'];

            Yii::$app->cache->set('cache_home_' . $lang, $data, 3600);
        }

        $scenes = \Yii::$app->controller->_sceneData;
        $data['sceneAll'] = $scenes['scenes'];
        $data['sceneAll']['0'] = "精选";

        return $this->controller->render("home", $data);

    }
} 