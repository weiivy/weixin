<?php

namespace lulutrip\modules\llt\actions\test;
use yii\base\Action;
use Yii;

/**
 * 配置文件导入三区导航数据表
 * @copyright (c) 2017, lulutrip
 * @author Xiaopei Dou<xiaopei.dou@ipptravel.com>
 */
class BatchData extends Action
{
    public function run() {
        return false;
        //return $this->setTopHover();
    }

    public function setTopHover(){
        $return = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . '/get-static-nav');
        if(!empty($return['data']['topHover']['categoryNav'])){
            $topHover = $return['data']['topHover']['categoryNav'];
            foreach ((array)$topHover as $region => $value){
                $i = 1;
                foreach ($value as $key => $val){
                    $res = Yii::$app->helper->curlPost(Yii::$app->params['service']['api'] . "/admin/base/navigation/nav-sub-list", ['region' => $region, 'keyword' => $key]);
                    $params = $content = [];
                    $params['region'] = $region;
                    $params['title'] = $key;
                    //如果存在在该code下保存记录，如果不存在，重新创建code
                    if(!empty($res['data'])){
                        $item = current($res['data']);
                        $params['code'] = $item['code'];
                        $content['seq'] = $item['seq'];
                        $content['html'] = $item['html'];
                    }else{
                        $params['code'] = $region . '_' . (time() + $i);//防止出现重复的code
                        $content['seq'] = $i;
                    }
                    $i++;
                    $content['link'] = $val['url'];
                    $content['tag'] = $val['tag'];
                    foreach ($val['main'] as $k => $main){
                        $temp = [];
                        if(!empty($main['name'])){
                            $temp['name'] = $main['name'];
                            $temp['url'] = $main['url'];
                            $temp['seq'] = count($val['main']) - $k;
                            if(!empty($main['class'])){
                                $temp['red'] = 1;
                            }else{
                                $temp['red'] = 0;
                            }
                            $content['a_rec'][] = $temp;
                        }
                    }
                    $content['banner_link'] = $val['images']['url'];
                    $content['bannerImg'] = $val['images']['src'];
                    $params['content'] = json_encode($content);
                    $params['operator'] = 0;
                    $return = Yii::$app->helper->curlPost(Yii::$app->params['service']['api'] . '/admin/base/navigation/nav-sub-save', $params);
                    if($return['status'] != 200){
                        die($return['msg']);
                    }
                }
            }
        }
    }
}