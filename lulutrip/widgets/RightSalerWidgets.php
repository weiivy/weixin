<?php

/**
 * 右侧销售小部件
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\widgets;

use yii\base\Widget;
use linslin\yii2\curl\Curl;
use lulutrip\library\Sales;

class RightSalerWidgets extends Widget
{
    public function run()
    {
        $model = new Sales();
        $rightSaler = $model->getRightSaler('NA');;
        return $this->render('@lulutrip/views/widgets/_rightSaler', ['rightSaler' => $rightSaler]);
    }
}