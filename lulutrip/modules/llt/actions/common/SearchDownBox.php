<?php
/**
 * 切换繁简
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\modules\llt\actions\common;

use yii\base\Action;
use Yii;

class SearchDownBox extends Action
{
    public function run()
    {
        //获取静态配置数据
        $url = Yii::$app->params['service']['api'] . '/get-static-nav';
        $staticNav = Yii::$app->helper->curlGet($url);

        $data = array('searchHotThemes' => $staticNav['data']['search301'], 'searchHotRecommend' => $staticNav['data']['searchNav']);
        unset($data['searchHotRecommend']['keyword'], $data['searchHotRecommend']['startcity'], $data['searchHotRecommend']['daylen']);
        //url重组
        $data['searchHotThemes'] = $this->formatThemesData($data['searchHotThemes']);
        //重组结构
        foreach($data['searchHotRecommend'] as &$typeData) {
            foreach($typeData as &$value) {
                $value['atom'] = $this->formatData($value['atom']);
            }

        }
        echo json_encode($data);
        die;
    }

    /**
     * 重组结构
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-07-08
     * @param $data
     * @return array 返回数据
     */
    public function formatData($data)
    {
        $temp = [];
        foreach($data as $key => $value) {
            $url = '';
            if(!preg_match('/^\d+$/', $key)) $url = $key;
            $temp[] = [
                'title' => $value,
                'url'   => $url
            ];

        }
        return $temp;
    }
    /**
     * 重组结构
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @copyright 2017-07-08
     * @param $data
     * @return array 返回数据
     */
    public function formatThemesData($data){
        foreach ($data as $key => $value){
            $data[$key] = Yii::$app->params['service']['www'] . '/search/tour?keyword=' . $key . '&s=r_search';
        }
        return $data;
    }
}