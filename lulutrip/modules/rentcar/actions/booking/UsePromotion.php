<?php
/**
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\actions\booking;

use lulutrip\modules\rentcar\library\booking\ShoppingData;
use lulutrip\modules\rentcar\library\booking\UsePromotions;
use common\models\Promotion;
use yii\base\Action;
use Yii;

class UsePromotion extends Action
{
    public function run() {
        $request = json_decode(Yii::$app->request->getRawBody(), true);

        if (empty($request['shoppingId']) || empty($request['promotionCode'])) {
            Yii::$app->response->statusCode = 400;
            return ['code' => 400, 'message' => '缺少参数'];
        }

        $promotionCode = $request['promotionCode'];
        $shoppingId = $request['shoppingId'];

        if($promotionCode) {
            try {
                $promotion = Promotion::find()->where(['promocode' => $promotionCode])->one();
                $shoppingData = new ShoppingData($shoppingId);
                $shoppingData->getInventory();
                $usePromotion = new UsePromotions($promotion, $shoppingData);

                if (!$usePromotion->check()) {
                    Yii::$app->response->statusCode = 400;
                    return ['code' => 400, 'message' => '无法使用该优惠券'];
                }

                $discountPrice = $usePromotion->apply();
                $return = $usePromotion->_returnData($shoppingData, $discountPrice);

                if ($promotion['type'] == 7) {
                    $return += [
                        'discountTitle' => $promotion['name'],
                        'discountMsg' => $promotion['promotext']
                    ];
                }

                return $return;
            } catch (\Exception $e) {
                Yii::$app->response->statusCode = 400;
                return ['code' => 400, 'message' => $e->getMessage()];
            }
        } else {
            Yii::$app->response->statusCode = 400;
            return ['code' => 400, 'message' => '请输入正确的优惠码'];
        }
    }
}