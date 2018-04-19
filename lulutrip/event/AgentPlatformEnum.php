<?php
/**
 * 跳转到app
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\event;


use yii\base\Event;

use Yii;

class AgentPlatformEnum extends Event
{
    const Mobile    = 'M';     // 移动端
    const Desktop   = 'PC';    // 桌面端

    /**
     * 检查客户端，如果是手机端，则跳转到相应的触屏页面
     * @author Laurence CHEN <laurence@lulutrip.com>
     * @date 2017-05-26
     */
    public static  function checkClient() {
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);

        $agentParma = static::Desktop;
        if (preg_match("/iphone/", $agent)) {
            $agentParma = static::Mobile;
        }

        if (preg_match("/android/", $agent) && preg_match("/mobile/", $agent)) {
            $agentParma = static::Mobile;
        }
        switch ($agentParma) {
            case static::Mobile:
                static::_mobileClientRedirect();
                break;
            default:
                break;
        }
    }

    /**
     * 处理woqu平台页面跳转逻辑
     * @author Laurence CHEN <laurence@lulutrip.com>
     * @date 2017-05-26
     */
    private static  function _mobileClientRedirect() {
        $appDomain = Yii::$app->config->app;
        $toConfig['tour']['tour-list']['list'] = 1;  //跟团游 列表页跳转
        $toConfig['tour']['detail']['view'] = 1;     //跟团游 详情页跳转

        //首页跳转
        if (\Yii::$app->controller->id == 'channel') {
            return Yii::$app->controller->redirect("{$appDomain}/", 301);
        }

        if(isset($toConfig[Yii::$app->controller->module->id][Yii::$app->controller->id][Yii::$app->controller->action->id])){
            return Yii::$app->controller->redirect("{$appDomain}" . Yii::$app->request->url, 301);
        }

        // app 没有对应链接，跳到首页
        return Yii::$app->controller->redirect("{$appDomain}/", 301);
    }
} 