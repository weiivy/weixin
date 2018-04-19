<?php
/**
 * 根据关键词获取提示
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\modules\llt\actions\common;

use common\library\base\Data;
use Yii;
use yii\base\Action;

class GetKeyword extends Action
{
    private  $sources;
    public function run()
    {

        $keyword = Yii::$app->request->post('keyword');
        $sourceType = Yii::$app->request->post('sourceType');
        $typeAlisa = [
            '1' => ['key' => 0, 'name' => 'tour'],
            '4' => ['key' => 1, 'name' => 'activity'],
            '5' => ['key' => 3, 'name' => 'tickets'],
            '6' => ['key' => 2, 'name' => 'traffic']
        ];

        $data = [];
        if(isset($typeAlisa[$sourceType])) {
            $this->sources = Data::getParticiples();
            $data = $this->getDataByKeyword($keyword, $typeAlisa[$sourceType], $data);
        }

        return json_encode([
            'data'    => $data,
            'status'  => 200,
            'message' => 'success',
        ]);
    }

    /**
     * 根据关键词获取搜索提示
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-07-08
     * @param $keyword
     * @param $type
     * @return array 返回数据
     */
    public function getDataByKeyword($keyword, $type)
    {
        $data = [];
        if($type['key'] == 0) {
            $data = $this->getMainSearch($keyword, $type);
            $this->tourSearch($keyword, $type, $data);
        } else {
            $this->actSearch($keyword, $type, $data);
            $data = array_merge($this->getMainSearch($keyword, $type), $data);
        }

        //链接处理
        foreach($data as &$value) {
            $value['link'] =  Yii::$app->params['service']['www'] . '/search/' . $type['name'] . '?keyword=' . urlencode($value['value']);
        }
        return $data;
    }

    /**
     * 匹配主区域
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-07－07
     * @param $keyword
     * @param $type
     * @return array 返回数据
     */
    public function getMainSearch($keyword, $type)
    {
        //处理关键词数据
        $data = [];
        foreach($this->sources  as $value) {
            if(preg_match('/^'.$keyword.'&/i', $value['cnn']) || $value['cnn'] == $keyword){
                $amount = explode(',', $value['amount']);
                if(($value['dicttype'] != 1 && $type['key'] == 0) || ($value['dicttype'] != 2 && $type['key'] > 0) || ($amount[$type['key']] == 0)) continue;
                $data[] = [
                    'label' => $value['cnn'],
                    'value' => $value['cnn'],
                    'id' => $value['id'],
                    'type' => $type['name'],
                    'count' => $amount[$type['key']],
                    'amount' => $amount[$type['key']],
                    'name' => '<span class="search-text-hl">'.$value["cn"].'</span>',
                ];
            }
        }
        return $data;

    }

    /**
     * 处理旅行团提示信息
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-07-06
     * @param $keyword
     * @param $type
     * @param $data
     * @return array 返回数据
     */
    public function tourSearch($keyword, $type, &$data)
    {
        $temp = [];
        foreach($this->sources as $value) {
            $already = array_column($data,'value');
            if(in_array($value['cnn'], $already))  continue;

            //有10条记录
            if(count($data) >= 10) {
                return $data;
            }

            //验证数量和类型
            $amount = explode(',', $value['amount']);
            if($value['dicttype'] != 1 || $amount[$type['key']] == 0) continue;

            //匹配city类型景点分词
            if(isset($value['parstate']) && isset($value['scenetype']) && $value['scenetype'] == 1 && preg_match('/,'.$keyword.',/i', $value['parstate'])) {
                $data[] = [
                    'label' => $value['cnn'],
                    'value' => $value['cnn'],
                    'id' => $value['id'],
                    'type' => $type['name'],
                    'count' => $amount[$type['key']],
                    'amount' => $amount[$type['key']],
                    'name' => $value["cn"],
                ];
            }

            //匹配分词中文名
            if((count($data) + count($temp) < 11) && preg_match('/('.$keyword.')/i', $value['cnn'])) {
                $temp[] = [
                    'label' => $value['cnn'],
                    'value' => $value['cnn'],
                    'id' => $value['id'],
                    'type' => $type['name'],
                    'count' => $amount[$type['key']],
                    'amount' => $amount[$type['key']],
                    'name' => str_replace($keyword, '<span class="search-text-hl">'.$keyword.'</span>', $value['cn']),
                ];
            }
        }
        $data = array_merge($data, $temp);
    }


    /**
     * 处理自由行提示信息
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-07-08
     * @param $keyword
     * @param $type
     * @param $data
     * @return array 返回数据
     */
    public function actSearch($keyword, $type, &$data)
    {
        $temp = $naturalMinor=[];
        foreach($this->sources  as $value) {

            //验证数量和类型
            $amount = explode(',', $value['amount']);
            if($value['dicttype'] != 2 || $amount[$type['key']] == 0) continue;

            //匹配除city类型景点分词
            if(isset($value['parstate2']) && isset($value['scenetype']) && $value['scenetype'] > 1 && preg_match('/,'.$keyword.',/i', $value['parstate2'])) {
                $data[] = [
                    'label' => $value['cnn'],
                    'value' => $value['cnn'],
                    'id' => $value['id'],
                    'type' => $type['name'],
                    'count' => $amount[$type['key']],
                    'amount' => $amount[$type['key']],
                    'name' => $value['cn'],
                    'clickamount' => isset($value['actclick']) ? $value['actclick'] : '',
                    'parcity' => isset($value['parcity']) ? $value['parcity'] : '',
                ];
            }

            //匹配分词中文名
            if(count($temp) < 10 && preg_match('/('.$keyword.')/i', $value['cnn']) && ((isset($value['scenetype']) && $value['scenetype'] == 1)  || in_array($value['type'], ['country', 'state']))) {
                $temp[] = [
                    'label' => $value['cnn'],
                    'value' => $value['cnn'],
                    'id' => $value['id'],
                    'type' => $type['name'],
                    'count' => $amount[$type['key']],
                    'amount' => $amount[$type['key']],
                    'name' => str_replace($keyword, '<span class="search-text-hl">'.$keyword.'</span>', $value['cn']),
                ];
            }


            //获取自然景点数据
            if(count($naturalMinor) < 10  && preg_match('/('.$keyword.')/i', $value['cnn']) && isset($value['scenetype']) && $value['scenetype'] > 1) {
                $naturalMinor[] = [
                    'label' => $value['cnn'],
                    'value' => $value['cnn'],
                    'id' => $value['id'],
                    'type' => $type['name'],
                    'count' => $amount[$type['key']],
                    'amount' => $amount[$type['key']],
                    'name' => str_replace($keyword, '<span class="search-text-hl">'.$keyword.'</span>', $value['cn']),
                    'clickamount' => isset($value['actclick']) ? $value['actclick'] : 0,
                    'parcity' => isset($value['parcity']) ? $value['parcity'] : '',
                ];
            }
        }
        //重组数据
        if(count($data) <= 2) {
            $data = $data + $temp;

            //拼接自然景点数据
            $east = array_slice($data, 4, 6);
            $data = array_slice($data, 0, 4);
            if(count($naturalMinor) < 6) {
                $data = $data + array_slice($east, 0, 6-count($naturalMinor));
            }
            array_multisort(array_column($naturalMinor, 'clickamount'), SORT_DESC, $naturalMinor);
            $data = array_merge($data, array_slice($naturalMinor, 0 , 10-count($data)));
        } else {
            array_multisort(array_column($data, 'clickamount'), SORT_DESC, $data);
            $data = array_slice($data, 0, 9);
        }
        return $data;

    }
}