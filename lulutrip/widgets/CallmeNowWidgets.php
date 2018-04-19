<?php
/**
 * 路路回电小部件
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\widgets;

use yii\base\Widget;
use linslin\yii2\curl\Curl;

class CallmeNowWidgets extends Widget
{
    public function run()
    {
        $curl = new Curl();
        $controller = \Yii::$app->controller->id;
        $action = \Yii::$app->controller->action->id;
        if((($controller == 'tour' || $controller == 'activity') && $action == 'view') || $controller == 'package-tour' || ($controller == 'private' && ($action == 'bus' || $action == 'bus_book' || $action == 'tour_book' || $action == 'tour_itinerary'))){
            $data['right'] = 'right';
        }
        if ($controller == 'package-tour'  || ($controller == 'private' && in_array($action, array('bus_book', 'bus', 'tour_book', 'tour_itinerary'))))
        {
            $data['isWeixin'] = 1;
        }
        $data['callmenowRegion'] = isset(\Yii::$app->controller->callmenowRegion) ? \Yii::$app->controller->callmenowRegion : '';
        $curl->get(\Yii::$app->params['service']['api'] . "/data/phoneAreaCodes");
        $data['phoneAreaCodes'] = json_decode($curl->response, true)['data']['phoneAreaCodes'];
        return $this->render('@lulutrip/views/widgets/_callmenow', $data);
    }
}