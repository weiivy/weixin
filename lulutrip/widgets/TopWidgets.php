<?php
/**
 * 头部小部件
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\widgets;

use lulutrip\components\Cookies;
use lulutrip\components\WebUser;
use yii\base\Widget;
use Yii;

class TopWidgets extends Widget
{
    public function run()
    {
        $user = new WebUser();
        //$navigationtype = isset(Yii::$app->controller->regionRoot) ? Yii::$app->controller->regionRoot : 'NA';
        $navigationtype = 'NA';
        if(!empty(Yii::$app->controller->regionRoot) && in_array(Yii::$app->controller->regionRoot, array('NA','EU','AU'))){
            $navigationtype = Yii::$app->controller->regionRoot;
        }
        if($navigationtype != NULL)
        {
            $cookie = new Cookies();
            $cookie->setCookies('navigationtype', $navigationtype);
        }

        //搜索框部分
        $currentUrl = Yii::$app->request->getUrl();

        //获取广告
        $region = $navigationtype === null ? "NA" : $navigationtype;
        $banner  = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . "/get-sub-banner/" . $region);

        $url = Yii::$app->params['service']['api'] . '/get-navigation/' . $navigationtype;
        $navigation = Yii::$app->helper->curlGet($url);

        //获取静态配置数据
        $url = Yii::$app->params['service']['api'] . '/get-static-nav';
        $staticNav = Yii::$app->helper->curlGet($url);

        //三区导航
        $controller = Yii::$app->controller->id;
        $return = Yii::$app->helper->curlPost(\Yii::$app->params['service']['api'] . "/channel/common/get-nav-sub-list", ['region' => $region, 'controller' => $controller]);
        $subNavData = $return['data'];

        //获取美加导航包团定制产品信息
        $url = Yii::$app->params['service']['api'] . '/get-package-hover';
        $productData = Yii::$app->helper->curlGet($url);

        //获取客服电话
        $url = Yii::$app->params['service']['api'] . '/admin/base/phone/list';
        $serviceTel = Yii::$app->helper->curlPost($url);

        //获取导航数据
        $refresh = intval($_GET['refresh']);
        $params = '?region=' . $region;
        $params .= empty($refresh)? '' : '&refresh=' . $refresh;
        $return = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . '/channel/common/get-nav-list' . $params);
        $MainNavigationPlate = $return['data'];

        return $this->render('@lulutrip/views/widgets/_top', [
            'members'            => $user->getCurrentUser(),
            'navigationtype'     => $navigationtype,
            'navigation'         => !empty($navigation['data']) ? $navigation['data'] : array(),
            'checkNavigationNum' => 'packagetour',
            'search301'          => $staticNav['data']['search301'],
            'searchNav'          => $staticNav['data']['searchNav'],
            'topHover'           => $staticNav['data']['topHover'],
            'searchFlag'         => strpos($currentUrl, '/search/') !== 0,
            'regionRoot'         => Yii::$app->controller->regionRoot,
            'banner'             => empty($banner['data']) ? [] : $banner['data'],
            //'phones'             => $staticNav['data']['IpPhone'],
            'topData'            => empty($productData['data']) ? [] : $productData['data'],
            'serviceTel'         => empty($serviceTel['data']) ? [] : $serviceTel['data'],
            'ChannelSubNavPlate' => $subNavData,
            'MainNavigationPlate'        => $MainNavigationPlate,
        ]);
    }
}