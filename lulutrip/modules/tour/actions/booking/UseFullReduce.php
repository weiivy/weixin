<?php


namespace lulutrip\modules\tour\actions\booking;


use lulutrip\modules\tour\library\booking\api\GetDiscount;
use lulutrip\modules\tour\library\booking\Booking;
use lulutrip\modules\tour\library\booking\ShoppingData;
use lulutrip\modules\tour\library\booking\UseDiscount;
use lulutrip\modules\tour\library\booking\UsePoints;
use lulutrip\modules\tour\library\booking\UsePromotion;
use yii\base\Action;
use Yii;

/**
 * 使用满减活动
 * @copyright (c) 2018, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
class UseFullReduce extends Action
{
    public function run()
    {
        $request = json_decode(Yii::$app->request->getRawBody(), true);

        if (empty($request['shoppingId']) || empty($request['discountId'])) {
            Yii::$app->response->statusCode = 400;
            return ['code' => 400, 'message' => '缺少参数'];
        }

        $discountId = $request['discountId'];
        $shoppingId = $request['shoppingId'];

        if($discountId) {

            try {
                $shoppingData = new ShoppingData($shoppingId);
                $shoppingData->getInventory();
                $discount = GetDiscount::data($shoppingData->pcode, $discountId);

                //验证
                $useDiscount = new UseDiscount(json_decode(json_encode($discount['discountInfo']), true), $shoppingData);
                if ($shoppingData->offPercent > 0 && $shoppingData->offPercent < 1) {
                    Yii::$app->response->statusCode = 400;
                    return ['code' => 400, 'message' => '该产品已享受秒杀折扣，无法叠加使用满减'];
                }

                if (!$useDiscount->_check()) {
                    Yii::$app->response->statusCode = 400;
                    return ['code' => 400, 'message' => '无法叠加使用满减'];
                }

                $discountPrice = $useDiscount->apply();

                //取消使用优惠券
                UsePoints::cancel($shoppingData);
                UsePromotion::cancel($shoppingData);
                Booking::saveDiscountType($shoppingData, 3);
                return Booking::_returnData($shoppingData, $discountPrice);
            } catch (\Exception $e) {
                Yii::$app->response->statusCode = 400;
                return ['code' => 400, 'message' => $e->getMessage()];
            }
        } else {
            Yii::$app->response->statusCode = 400;
            return ['code' => 400, 'message' => '请选择优惠'];
        }
    }
} 