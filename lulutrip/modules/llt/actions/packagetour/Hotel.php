<?php
/**
 *  获取酒店信息
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\modules\llt\actions\packagetour;
use yii\base\Action;
use Yii;
class Hotel extends Action
{
    public function run()
    {
        $hotelCode = Yii::$app->request->get('hotelCode', 0);
        $result = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . '/get-hotel/' . $hotelCode);
        return json_encode(array('content' =>  $this->controller->renderPartial('_hotel', $result['data'])));
    }
} 