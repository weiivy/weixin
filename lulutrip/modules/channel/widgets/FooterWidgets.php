<?php
/**
 * 底部
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\modules\channel\widgets;

use yii\base\Widget;
use Yii;
class FooterWidgets extends Widget
{
    public function run()
    {
        $result = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . "/get-ads");

        //客服电话
        $tel = Yii::$app->helper->curlPost(Yii::$app->params['service']['api'] . '/admin/base/phone/list');

        return $this->render('@lulutrip/modules/channel/views/widgets/footer', [
                'adviserSaler' => $result['data'],
                'cartNum'      => Yii::$app->params['cartNum'],
                'tel'          => empty($tel['data']) ? [] : $tel['data']
        ]);
    }
} 