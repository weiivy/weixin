<?php
namespace lulutrip\modules\tour\library\lists;

use common\library\base\Data;
use common\models\tours\Tourslist;
use yii\base\Component;

class RecTours extends Component
{
    /**
     * 生成列表页的推荐tourcode
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @copyright 2017-08-01
     * @return array
     */
    public static function getTrCdsByRec()
    {
        $kyToField = array(
            'region' => 'area',
            'euarea' => 'area',
            'sceneidus' => 'area-NA_scenes',
            'sceneideu' => 'area-EU_scenes',
            'sceneidau' => 'area-AU_scenes',
            'eustate' => 'countries',
            'citycode' => 'cities',
            'sceneid' => 'scenes',
            'feature' => 'features',
            'sale' => 'saleact',
            'areaplay' => 'areaplay',
            'region&&days' => 'area-$v1_days',
            'euarea&&days' => 'area-$v1_days',
            'eustate&&days' => 'countries-$v1_days',
            'sceneidus&&days' => 'area-NA_days-$v1_scenes',
            'sceneideu&&days' => 'area-EU_days-$v1_scenes',
            'sceneidau&&days' => 'area-AU_days-$v1_scenes',
            'minor_scene' => 'scenes',
        );
        $list = array();
        $rows = Tourslist::find()
            ->select('tourslist_index, tourslist_code, tourslist_contents')
            ->where(['tourslist_type' => 1])
            ->groupBy('tourslist_index, tourslist_code')
            ->orderBy('tourslist_id desc')
            ->asArray()
            ->all();

        $data = Data::getTourTags();
        $tagsCdIds = $data['tourTagsCdIds'];
        foreach($rows as $val)
        {
            $minday = '';
            $fPrm = isset($kyToField[$val['tourslist_index']]) ? $kyToField[$val['tourslist_index']] : '';
            $code = $val['tourslist_code'];
            if(in_array($val['tourslist_index'], array('region&&days', 'euarea&&days', 'eustate&&days')))
            {
                list($v1, $code) = explode('&&', $code);
                $fPrm = str_replace('$v1', $v1, $fPrm);
                if(strstr($code, 'diy')) {
                    $diy = explode('diy', $code);
                    $code = 'minday-'.$diy[0].'_'.$diy[1];
                }

                $fPrm = str_replace('$v1', $v1, $fPrm);
            }
            elseif(in_array($val['tourslist_index'], array('sceneidus&&days', 'sceneideu&&days', 'sceneidau&&days')))
            {
                list($code, $v1) = explode('&&', $code);
                if(strstr($v1, 'diy')) {
                    $diy = explode('diy', $v1);
                    $minday = '_minday-'.$diy[0].'_'.$diy[1];
                    $v1 = '';
                }

                $fPrm = str_replace('$v1', $v1, $fPrm);
            }

            if(in_array($fPrm, array('features', 'saleact', 'areaplay'))) {
                isset($tagsCdIds[$code]) && $code = $tagsCdIds[$code];
            }

            $key        = $fPrm . '-' . $code . $minday;
            if(strstr($key, 'minday-')) {
                if($minday) {
                    $key = str_replace('days-_', '', $key);
                } else {
                    $key = str_replace('days-', '', $key);
                }
            }

            $tourCodes  = array_reverse(explode(',', $val['tourslist_contents']));
            $list[$key] = implode(',', $tourCodes);
        }
        return $list;
    }
}