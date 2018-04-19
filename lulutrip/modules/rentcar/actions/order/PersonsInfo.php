<?php
/**
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\actions\order;
use Yii;
use yii\base\Action;
use lulutrip\modules\rentcar\library\booking\ShoppingData;

class PersonsInfo extends Action
{
    public function run($shoppingId) {
        $shoppingData = new ShoppingData($shoppingId);
        $phoneAreaCodes = Yii::$app->helper->curlGet(\Yii::$app->params['service']['api'] . "/data/phoneAreaCodes")['data']['phoneAreaCodes'];

        Yii::$app->controller->pageTitle = '路路行下单页-填写资料';
        return $this->controller->render("personsInfo/index.html", [
            'shoppingId' => $shoppingId,
            'phoneAreaCodes' => $phoneAreaCodes,
            'members' => Yii::$app->user->getCurrentUser(),
        ]);
    }
}