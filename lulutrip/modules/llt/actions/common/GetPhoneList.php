<?php

namespace lulutrip\modules\llt\actions\common;


use yii\base\Action;
use Yii;

/**
 * 底部电话号码接口
 * @copyright (c) 2018, lulutrip.com
 * @author  Xiaopei Dou<xiaopei.dou@ipptravel.com>
 */
class GetPhoneList extends Action
{
    public function run()
    {
        $return = Yii::$app->helper->curlPost(Yii::$app->params['service']['api'] . '/admin/base/phone/list');
        if(!empty($return['data'])){
            $result = [
                'data' => $return['data'],
                'msg' => 'success',
                'rs' => 1
            ];
        }else{
            $result = [
                'msg' => 'fail',
                'rs' => 0
            ];
        }
        echo json_encode($result);
        die;
    }
} 