<?php
/**
 * 获取电话区域
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\modules\llt\actions\common;


use common\library\base\Data;
use yii\base\Action;

class GetPhoneAreaCode extends Action
{
    public function run()
    {
        echo json_encode([
            'status'  => 200,
            'message' => 'success',
            'data'    => ['PhoneAreaCode' => Data::getPhoneAreaCode()]
        ]);exit;
    }
} 