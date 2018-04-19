<?php

namespace lulutrip\modules\llt\actions\common;


use yii\base\Action;
use Yii;

/**
 * 头部「单个」电话号码
 * @copyright (c) 2018, lulutrip.com
 * @author  Xiaopei Dou<xiaopei.dou@ipptravel.com>
 */
class GetPhone extends Action
{
    public function run()
    {
        $ipCode = Yii::$app->request->get('ipCode');
        $defaultIpCodes = ['USA', 'China', 'Taiwan', 'HongKong', 'Europe', 'Britain', 'Germany', 'Oceania'];
        if(empty($ipCode) || !in_array($ipCode, $defaultIpCodes)){
            $ipCode = 'USA';
        }
        $return = Yii::$app->helper->curlPost(Yii::$app->params['service']['api'] . '/admin/base/phone/list', ['phone' => 1]);
        if(!empty($return['data'])){
            $result = [
                'data' => $return['data'][$ipCode],
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