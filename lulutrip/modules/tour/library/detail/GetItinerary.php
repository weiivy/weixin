<?php
/**
 * 行程部分支持展示景点链接
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\modules\tour\library\detail;


use lulutrip\models\TourScene;
use yii\base\Component;
use Yii;

class GetItinerary extends Component
{
    /**
     * 行程部分支持展示景点链接
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-10-10
     * @param $datas
     * @param $tourCode
     * @return mixed
     */
    public function dealIti(&$datas, $tourCode)
    {
        $scenes = self::getScenes($tourCode);
        foreach($scenes as $scene) {
            $flag = 0;
            foreach($datas as $parKey => $data) {

                //activities
                if(!empty($data['activitys'])) {
                    foreach($data['activitys'] as $key => $activity) {
                        if($flag || preg_match('/target="_blank">' . $scene['scenename_cn'] . '/', $activity['descCN']) || preg_match('/target="_blank">' . $scene['scenename_cn'] . '/', $activity['titleCN'])) {
                            break 2;
                        }
                        if( !$flag && preg_match('/' . $scene['scenename_cn'] . '/', $activity['titleCN']) ) {
                            $replace = '<a href="' . Yii::$app->params["service"]['www'] . '/scene/view/id-' . $scene['sceneid'] . '" target="_blank">' . $scene['scenename_cn'] . '</a>';
                            $datas[$parKey]['activitys'][$key]['titleCN'] = $this->str_replace_once($scene['scenename_cn'], $replace, $activity['titleCN']);
                            $flag = 1;
                        }
                        if( !$flag && preg_match('/' . $scene['scenename_cn'] . '/', $activity['descCN']) ) {
                            $replace = '<a href="' . Yii::$app->params["service"]['www'] . '/scene/view/id-' . $scene['sceneid'] . '" target="_blank">' . $scene['scenename_cn'] . '</a>';
                            $datas[$parKey]['activitys'][$key]['descCN'] = $this->str_replace_once($scene['scenename_cn'], $replace, $activity['descCN']);
                            $flag = 1;
                        }
                    }
                }

            }

        }
        return $datas;

    }

    /**
     * 获取旅行团关联景点
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-10-10
     * @param $tourCode
     * @return array|\yii\db\ActiveRecord[]
     */
    private  static function getScenes($tourCode)
    {
        return TourScene::find()->alias('ts')
            ->select('ts.sceneid, s.scenename_cn')
            ->joinWith('scene s', false)
            ->where(['tourcode' => $tourCode])
            ->orderBy('LENGTH(scenename_cn) DESC')
            ->asArray()
            ->all();
    }


    /**
     * 仅替换首次匹配的字符串
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-10-10
     * @param $needle
     * @param $replace
     * @param $haystack
     * @return mixed
     */
    private  function str_replace_once($needle, $replace, $haystack)
    {
        $pos = strpos($haystack, $needle);
        if ($pos === false) {
            return $haystack;
        }

        return substr_replace($haystack, $replace, $pos, strlen($needle));
    }

} 