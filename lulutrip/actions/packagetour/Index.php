<?php
/**
 * 包团聚合页
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\actions\packagetour;

use lulutrip\library\common\ListPage;
use lulutrip\components\Cookies;
use lulutrip\components\Helper;
use yii\base\Action;
use Yii;
class Index extends Action
{
    public function run()
    {
        Helper::setSeo('privatetour', 'home');
        $this->controller->layout = 'privatetour';
        //获取客服信息
        $advister = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . "/get-rand-saler");

        //获取产品信息
        $tours = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . "/get-tours");
        $cookie = new Cookies();
        //获取用户反馈信息
        $page = Yii::$app->request->get('page', 1);
        $feedback = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . "/get-feedback/" . $page);
        //分页
        $link = "/privatetour/page-{{page}}";
        $listpage = new ListPage($page, 4, $feedback['data']['count'], $link);
        $pageData =  $listpage->getPageDots();
        //固定产品名称
        $tourNames = [
            9343 => '<亲友小团>美东品质六日游',
            9443 => '<亲友小团>美西五大国家公园七日',
            10607 => '<亲友小团>羚羊彩穴、马蹄湾一日',
            9483 => '<亲友小团>迈阿密、西锁岛品质五日'
        ];
        $navigationtype = $cookie->getCookies('navigationtype', 'NA');
        return $this->controller->render('index', [
            'advister'        => (empty($advister['data']) ? [] : $advister['data']),
            'tours'           => (empty($tours['data']) ? [] : $tours['data']),
            'navigationtype'  => $navigationtype,
            'tourNames'      => $tourNames,
            'feedback'        => (empty($feedback['data']['feedback']) ? [] : $feedback['data']['feedback']),
            'pageData'        => $pageData,
        ]);
    }
} 