<?php
/**
 * 获取优惠券
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\actions\booking;
use lulutrip\modules\rentcar\library\booking\ShoppingData;
use yii\base\Action;
use Yii;
use common\models\Promotion;
use lulutrip\modules\rentcar\library\booking\UsePromotions;

class GetPromotions extends Action
{
    public function run($shoppingId) {
        $availablePromotions = [];

        $shoppingData = new ShoppingData($shoppingId);
        $promotions = Promotion::find()->alias('p')
                        ->innerJoin('promotion_discount pd', 'pd.promotion_id = p.promoid')
                        ->where(['pd.discount_product' => 5, 'pd.discount_product_id' => $shoppingData->carid])->all();

        foreach ($promotions as $promotion) {
            try {
                $usePromotion = new UsePromotions($promotion, $shoppingData);
                if ($usePromotion->check()) {
                    $availablePromotions[] = ['promotionId' => $promotion['promoid'], 'promotionCode' => $promotion['promocode']];
                }
            } catch (\Exception $e) {
                // noting to do
            }
        }
        return [
            'promotions' => $availablePromotions,
        ];
    }
}