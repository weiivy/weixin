<?php
/**
 * 头部
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\modules\channel\widgets;


use lulutrip\components\Cookies;
use lulutrip\components\WebUser;
use yii\base\Widget;
use Yii;
class HeaderWidgets extends Widget
{
    public function run()
    {
        $user = new WebUser();
        //$navigationtype = isset(Yii::$app->controller->regionRoot) ? Yii::$app->controller->regionRoot : 'NA';
        $navigationtype = 'NA';
        if(!empty(Yii::$app->controller->regionRoot) && in_array(Yii::$app->controller->regionRoot, array('NA','EU','AU'))){
            $navigationtype = Yii::$app->controller->regionRoot;
        }
        if($navigationtype != NULL) {
            $cookie = new Cookies();
            $cookie->setCookies('navigationtype', $navigationtype);
        }

        //头部广告
        $region = $navigationtype === null ? "NA" : $navigationtype;
        $banner  = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . "/get-sub-banner/" . $region);

        //右侧导航条
        $url = Yii::$app->params['service']['api'] . '/get-navigation/' . $navigationtype;
        $navigation = Yii::$app->helper->curlGet($url);

        //静态配置数据
        $url = Yii::$app->params['service']['api'] . '/get-static-nav';
        $staticNav = Yii::$app->helper->curlGet($url);

        //预览
        $preview = Yii::$app->request->get('preview', 0);
        $key = Yii::$app->request->get('key', 0);
        $controller = Yii::$app->controller->id;
        $return = Yii::$app->helper->curlPost(\Yii::$app->params['service']['api'] . "/channel/common/get-nav-sub-list", ['region' => $region, 'preview' => $preview, 'key' => $key, 'controller' => $controller]);
        $subNavData = $return['data'];

        //客服电话
        $tel = Yii::$app->helper->curlPost(Yii::$app->params['service']['api'] . '/admin/base/phone/list');

        //获取导航数据
        $refresh = intval($_GET['refresh']);
        $params = '?region=' . $region;
        $params .= empty($refresh)? '' : '&refresh=' . $refresh;
        $return = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . '/channel/common/get-nav-list' . $params);
        $MainNavigationPlate = $return['data'];

        return $this->render('@lulutrip/modules/channel/views/widgets/header', [
            'members'            => $user->getCurrentUser(),
            'navigationtype'     => $navigationtype,
            'navigation'         => !empty($navigation['data']) ? $navigation['data'] : array(),
            'regionRoot'         => Yii::$app->controller->regionRoot,
            'topHover'           => $staticNav['data']['topHover'],
            'banner'             => empty($banner['data']) ? [] : $banner['data'],
            'phones'             => $staticNav['data']['IpPhone'],
            'topData'            => empty($productData['data']) ? [] : $productData['data'],
            'checkNavigationNum' => 'homeNew',
            'tel'                => empty($tel['data']) ? [] : $tel['data'],
            'ChannelSubNavPlate' => $subNavData,
            'MainNavigationPlate'        => $MainNavigationPlate,
        ]);
    }
} 