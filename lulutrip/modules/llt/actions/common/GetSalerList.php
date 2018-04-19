<?php

namespace lulutrip\modules\llt\actions\common;

use lulutrip\library\Sales;
use yii\base\Action;
use Yii;

/**
 * 所有客服列表
 * @copyright (c) 2018, lulutrip.com
 * @author  xiaopei Dou<xiaopei.dou@ipptravel.com>
 */
class GetSalerList extends Action
{
    public function run()
    {
        $model = new Sales();
        $areasData = array(
            'NA'   => array('美国','美國'),
            'EU'   => array('英国','英國'),
            'AU'   => array('中国','中國'),
        );
        $areaAlisa = ['NA' => '美国', 'EU' => '英国', 'AU' => '澳洲', 'Asia' => '亚洲'];
        $data = $model->getSalerList($areasData,$areaAlisa);

        return json_encode(array(
            'data' => $data,
            'rs' => '1')
        );
    }

}