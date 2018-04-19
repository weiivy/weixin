<?php
/**
 * 客服列表action
 * @copyright (c) 2017, lulutrip.com
 * @author  xiaopei Dou<xiaopei.dou@ipptravel.com>
 */
namespace lulutrip\modules\llt\actions\tourlist;

use lulutrip\library\Sales;
use yii\base\Action;
use Yii;

class GetSales extends Action
{
    public function run()
    {
        $area = \Yii::$app->request->get('area');
        $model = new Sales();
        $areasData = array(
            'NA'=>array('美国','美國'),
            'EU'=>array('英国','英國'),
            'AU'=>array('中国','中國'),
        );
        $areaAlisa = ['NA' => '美国', 'EU' => '英国', 'AU' => '澳洲'];
        $sales = $model->getRightSaler($area, $areasData);

        $data['avatar'] = $sales['avatar_3'];
        $data['name'] = $sales['name_en'];
        $data['country'] = $areaAlisa[$area];
        $data['identity'] = in_array($area, ['NA', 'EU']) ? "当地顾问" : "旅游专家";
        $data['link'] = Yii::$app->params['service']['www'] . '/adviser/home/id-' . $sales['id'];

        return json_encode(array(
            'data' => $data,
            'rs' => '1')
        );
    }

}