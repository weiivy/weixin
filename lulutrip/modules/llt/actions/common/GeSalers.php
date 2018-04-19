<?php
/**
 * 底部销售
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\modules\llt\actions\common;


use yii\base\Action;
use Yii;

class GeSalers extends Action
{
    public function run()
    {
        $result = Yii::$app->helper->curlGet(\Yii::$app->params['service']['api'] . "/get-ads");
        echo json_encode($result);
        die;
    }
} 