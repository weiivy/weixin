<?php
/**
 * 标准化包团频道页action
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\actions\packagetour;

use linslin\yii2\curl\Curl;

use lulutrip\components\Helper;
use yii\base\Action;

class Home extends Action
{
    public $productIds;

    public function run()
    {
        $data['themesData'] = \Yii::$app->controller->_themeData;
        Helper::setSeo('privatetour', 'home');
        $curl = new Curl();

        //获取包团数据
        $curl->get(\Yii::$app->params['service']['api'] . "/package-tour/home/10");
        $return = json_decode($curl->response, true);
        $data['packagetours'] = $return['data']['data'];
        foreach ($data['packagetours'] as $k => $v) {
            $this->productIds[] = (int)$v['packid'] + 800000;
        }

        $data['params'] = \Yii::$app->params;
        $curl->get(\Yii::$app->params['service']['api'] . "/data/cities");
        $return = json_decode($curl->response, true);
        $data['cities'] = $return['data']['cities']['cities'];
        return $this->controller->render('@lulutrip/views/package-tour/home', $data);
    }
}