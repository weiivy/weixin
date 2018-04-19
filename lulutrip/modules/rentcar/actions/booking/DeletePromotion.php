<?php
/**
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\actions\booking;
use lulutrip\modules\rentcar\library\booking\ShoppingData;
use lulutrip\modules\rentcar\library\booking\UsePromotions;
use yii\base\Action;
use Yii;

class DeletePromotion extends Action
{
    public function run() {
        $request = json_decode(Yii::$app->request->getRawBody(), true);

        if (empty($request['shoppingId'])) {
            Yii::$app->response->statusCode = 400;
            return ['code' => 400, 'message' => '缺少参数'];
        }

        $shoppingId = $request['shoppingId'];
        $shoppingData = new ShoppingData($shoppingId);
        $shoppingData->getInventory();

        $usePromotions = new UsePromotions('', $shoppingData);
        $usePromotions::cancel($shoppingData);

        return $usePromotions->_returnData($shoppingData, 0);
    }
}