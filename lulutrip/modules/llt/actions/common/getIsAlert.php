<?php
/**
 * 获取是否出现提示框
 * @copyright (c) 2017, lulutrip.com
 * @author  Serena Liu<serena@lulutrip.com>
 */
namespace lulutrip\modules\llt\actions\common;

use yii\base\Action;
use Yii;

class getIsAlert extends Action
{
    public function run()
    {
        if($_COOKIE['crystal_ball_alert'] == 1) {
            $result = 1;
        } else {
            $result = 0;
        }

        $callback = $_GET['callback'];
        echo $callback.'('.json_encode(array('code' => 200, 'message' => 'success', 'data' => $result)).')';
        exit;
    }
}