<?php

namespace lulutrip\modules\llt\actions\common;


use yii\base\Action;
use Yii;

/**
 * 旅行团搜索
 * @copyright (c) 2018, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
class SearchTour extends Action
{
    public function run()
    {
        $keyword = Yii::$app->request->post('keyword');
        if(empty($keyword)) return json_encode(['status' => 0, 'message' => '请输入关键字']);

        //纯数字
        if(preg_match('/^\d*$/',$keyword)) {
            //旅行团
            if(($actId = $keyword - 400000) > 0){
                return json_encode(['status' => 1, 'data' => Yii::$app->config->www . "/activity/view/id-{$actId}"]);
            }
            return json_encode(['status' => 1, 'data' => Yii::$app->config->www . "/tour/view/tourcode-{$keyword}"]);
        }


        $result = Yii::$app->helper->curlPost(Yii::$app->config->api . '/channel/common/search-tour', ["keyword" => $keyword]);
        return json_encode($result);
    }
} 