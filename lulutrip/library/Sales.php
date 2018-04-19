<?php
/**
 * 路路客服类
 * @copyright (c) 2017, lulutrip.com
 * @author  xiaopei Dou<xiaopei.dou@ipptravel.com>
 */
namespace lulutrip\library;

use yii\base\Component;
use linslin\yii2\curl\Curl;
use Yii;

class Sales extends Component
{

    /**
     * 根据区域获取随机客服
     * @author xiaopei Dou<xiaopei.dou@ipptravel.com>
     * @copyright 2017-07-28
     * @param string $area
     * @return array
     */
    public function getRightSaler($area, $areas = array())
    {
        $curl = new Curl();
        if(empty($areas)){
            $areas = array(
                'NA'=>array('美国','美國'),
                'EU'=>array('英国','英國'),
                'AU'=>array('英国','英國','美国','美國'),
            );
        }

        $areasByurl = array(
            'tour/north_america' => $areas['NA'],
            'region-EU' => $areas['EU'],
            'region-AU' => $areas['AU'],
        );
        $referer = $_SERVER['REQUEST_URI'];
        $area = $areas[$area];
        if ($referer) {
            foreach ($areasByurl as $auk=>$auv) {
                if (strstr($referer, $auk)) {
                    $area = $auv;
                    break;
                }
            }
        }

        $curl->get(\Yii::$app->params['service']['api'] . "/saler/list");
        $adviserInfos = json_decode($curl->response, true)['data'];
        foreach ($adviserInfos as $adk=>$adv) {
            $adv['address_live'] = $adv['address_live'] && unserialize($adv['address_live']) ? unserialize($adv['address_live']) : array();
            if (in_array($adv['address_live']['country'], $area) && $adv['avatar_3']) {
                $advisers[] = array(
                    'id' => $adv['id'],
                    'name_en' => $adv['name_en'],
                    'avatar_3' => $adv['avatar_3'],
                    'country' => $adv['address_live']['country'],
                );
            }
        }

        unset($adviserInfos);
        $adviser = array();
        if ($advisers) {
            $adviser = $advisers[array_rand($advisers,1)];
        }

        return $adviser;
    }

    /**
     * 获取所有客服
     * @author xiaopei Dou<xiaopei.dou@ipptravel.com>
     * @copyright 2018-02-08
     * @param array $areas
     * @param array $areaAlisa
     * @return array
     */
    public function getSalerList($areas = [], $areaAlisa = [])
    {
        $curl = new Curl();
        if(empty($areas)){
            $areas = array(
                'NA'=>array('美国','美國'),
                'EU'=>array('英国','英國'),
                'AU'=>array('英国','英國','美国','美國'),
            );
        }

        $curl->get(Yii::$app->params['service']['api'] . "/saler/list");
        $adviserInfos = json_decode($curl->response, true)['data'];

        foreach ($adviserInfos as $adk=>$adv) {
            $adv['address_live'] = $adv['address_live'] && unserialize($adv['address_live']) ? unserialize($adv['address_live']) : array();
            if(!empty($adv['avatar_3']) && !empty($adv['address_live']['country'])){
                $key = Yii::$app->helper->arrayMultiSearch($adv['address_live']['country'], $areas);
                if($key == 'AU'){
                    $advisers['Asia'][] = array(
                        'id' => $adv['id'],
                        'name' => $adv['name_en'],
                        'avatar' => Yii::$app->helper->getImgDomain() . '/' . $adv['avatar_3'],
                        'country' => "亚洲",
                        'identity' =>  "当地顾问",
                        'link' => Yii::$app->params['service']['www'] . '/adviser/home/id-' . $adv['id'],
                    );
                }
                $advisers[$key][] = array(
                    'id' => $adv['id'],
                    'name' => $adv['name_en'],
                    'avatar' => Yii::$app->helper->getImgDomain() . '/' . $adv['avatar_3'],
                    'country' => empty($areaAlisa[$key])? $adv['address_live']['country'] : $areaAlisa[$key],
                    'identity' => in_array($key, ['NA', 'EU']) ? "当地顾问" : "旅游专家",
                    'link' => Yii::$app->params['service']['www'] . '/adviser/home/id-' . $adv['id'],
                );
            }
        }
        
        unset($adviserInfos);
        return $advisers;
    }
}