<?php
/**
 * message
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\modules\tour\library\lists;


use yii\base\Component;
use Yii;


class DealRight extends Component
{

    public $_params;
    public $_navigations;
    public function __construct($params, $navigations)
    {
        $this->_params      = $params;
        $this->_navigations = $navigations;

    }
    /**
     * 获取热门攻略信息
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-08-23
     * @return array 返回数据
     */
    public function getRecPlayList()
    {
        //判断景点或者国家或者区域是多个情况
        if(count($this->_params['regionArr']) > 2 || (isset($this->_params['scenesArr']) && count($this->_params['scenesArr']) > 1)) {
            $code[] = $this->_params['regionArr'][0];
        } elseif(isset($this->_params['scenesArr']) || isset($this->_params['id'])) {
            //单个景点
            $code = array_column($this->_navigations, 'id');
        } else {
            //单个国家或者区域
            $code = $this->_params['regionArr'];
        }

        $result = Yii::$app->helper->CurlPost(Yii::$app->params['service']['api'] . "/get-recplay-list", ['code' => $code]);
        return $result['data'];

    }

    /**
     * 轻攻略
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-08-24
     *
     * @return array 返回数据
     */
    public function getLightRaiders()
    {
        $staticData = array(
            'USWest' => [
                'name' => '美西',
                'enName' => 'WEST COAST',
                'url'   => '/special/uswest'
            ],
            'USEast' => [
                'name' => '美东',
                'enName' => 'EAST COAST',
                'url'   => '/special/useast'
            ],
            'Hawaii' => [
                'name' => '夏威夷',
                'enName' => 'HAWAII',
                'url'   => '/special/hawaii2014'
            ],
            'CA' => [
                'name' => '加拿大',
                'enName' => 'CANADA',
                'url'   => '/special/canada'
            ],
            'NP' => [
                'name' => '国家公园',
                'enName' => 'NATIONAL PARK',
                'url'   => '/theme/national_park'
            ],
            'Yellowstone' => [
                'name' => '黄石公园',
                'enName' => 'YELLOWSTONE',
                'url'   => '/special/yellowstone_2014'
            ],
            'AUS' => [
                'name' => '澳大利亚',
                'enName' => 'AUSTRALIA',
                'url'   => '/theme/au_experience'
            ]
        );

        $staticRegion = array_keys($staticData);
        if(isset($this->_params['scenesArr']) || isset($this->_params['id'])) {
            $params = array_column($this->_navigations, 'id');
        } else{
            $params = $this->_params['regionArr'];
        }
        foreach($staticRegion as $val) {
            if(in_array($val, $params)) return $staticData[$val];
        }

        return [];

    }

} 