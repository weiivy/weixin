<?php
/**
 * 简易 - 头部
 * @copyright (c) 2017, lulutrip.com
 * @author  Serena Liu<serena.liu@ipptravel.com>
 */

namespace lulutrip\modules\order\widgets;

use lulutrip\components\WebUser;
use yii\base\Widget;
use Yii;
class HeaderWidgets extends Widget
{
    public function run()
    {
        //静态配置数据 待查
        $url = Yii::$app->params['service']['api'] . '/get-static-nav';
        $staticNav = Yii::$app->helper->curlGet($url);

        //客服电话
        $serviceTel = Yii::$app->helper->curlPost(Yii::$app->params['service']['api'] . '/admin/base/phone/list');

        return $this->render('@orderModule/views/widgets/header.html', [
            'members'            => Yii::$app->user->getCurrentUser(),
            //'phones'             => $staticNav['data']['IpPhone'],
            'serviceTel'         => !empty($serviceTel['data']) ? $serviceTel['data'] : array()
        ]);
    }
} 