<?php

namespace lulutrip\modules\tour\controllers;

use api\library\Help;
use Curl\Curl;
use lulutrip\models\sale\Activities;
use lulutrip\modules\tour\library\booking\api\GetAfterDiscount;
use lulutrip\modules\tour\library\booking\api\GetInventory;
use lulutrip\modules\tour\library\booking\api\GetOffPercent;
use lulutrip\modules\tour\library\booking\Booking;
use lulutrip\modules\tour\library\booking\ShoppingData;
use lulutrip\modules\tour\library\booking\UseDiscount;
use lulutrip\modules\tour\library\booking\UsePromotion;
use lulutrip\modules\tour\library\booking\UsePoints;
use common\models\Promotion;
use yii\rest\Controller;
use Yii;

/**
 * Class BookingController
 * @author Victor Tang<victor.tang@ipptravel.com>
 * @copyright (c) 2017, lulutrip.com
 */
class BookingController extends Controller {

    public function actions()
    {
        return [
            'get-discount'       => 'lulutrip\modules\tour\actions\booking\GetDiscount',
            'full-reduce'        => 'lulutrip\modules\tour\actions\booking\UseFullReduce',
            'delete-full-reduce' => 'lulutrip\modules\tour\actions\booking\DeleteFullReduce',
            'use-group-buy'      => 'lulutrip\modules\tour\actions\booking\UseGroupBuy',
        ];
    }
    /**
     * 获取优惠券列表 & 可用积分接口
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     * @param $shoppingId string 订购Id
     * @return array
     */
    public function actionGetPromotions($shoppingId) {
        $shoppingData = new ShoppingData($shoppingId);
        $shoppingData->getInventory();

        /*$availableDiscount = [];
        if ($shoppingData->offPercent > 0 && $shoppingData->offPercent < 1) {
            $availablePromotions = false;
            $promotionTips = '您当前正在参与秒杀活动，无法使用优惠';


            //获取折扣
            if($shoppingData->usePromotion->promotionId == 0){
                $promotionTips = '当前参加的活动不支持使用优惠券';
               $availableDiscount = $this->_getDiscountInfo($shoppingData);
            }
        } else if ($shoppingData->participateCouponAmount == 0) {
            $availablePromotions = false;
            $promotionTips = '您的订单不满足活动条件，无法享受优惠';
        } else {
            $availablePromotions = [];
            $promotionTips = '';

            $promotions = Promotion::find()->innerJoin('promotion_discount', 'promotion_discount.promotion_id = promotion.promoid')->where(['promotion.promo_useplatform' => [0, 1], 'promotion.usage' => 1, 'promotion_discount.discount_product_id' => $shoppingData->pcode])->all();
            foreach ($promotions as $promotion) {
                try {
                    $usePromotion = new UsePromotion($promotion, $shoppingData);
                    if ($usePromotion->check()) {
                        $availablePromotions[] = ['promotionId' => $promotion['promoid'], 'promotionCode' => $promotion['promocode']];
                    }
                } catch (\Exception $e) {
                    // noting to do
                }
            }
        }*/

        $usePoints = new UsePoints($shoppingData);
        $availablePoints = $usePoints->getAvailablePoints();

        return [
//            'promotions' => $availablePromotions,
            'points' => $availablePoints,
//            'promotionTips' => $promotionTips,
//            'discount'  => $availableDiscount
        ];
    }

    /**
     * 使用优惠券接口
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     * @return array
     */
    public function actionUsePromotion() {
        $request = json_decode(Yii::$app->request->getRawBody(), true);

        if (empty($request['shoppingId']) || empty($request['promotionCode'])) {
            Yii::$app->response->statusCode = 400;
            return ['code' => 400, 'message' => '缺少参数'];
        }

        $promotionCode = $request['promotionCode'];
        $shoppingId = $request['shoppingId'];

        if($promotionCode) {
            try {
                $promotion = Promotion::find()->where(['promocode' => $promotionCode, 'promo_useplatform' => [0, 1]])->one();
                $shoppingData = new ShoppingData($shoppingId);
                $shoppingData->getInventory();

                //旧优惠券
                if($promotion) {
                    $usePromotion = new UsePromotion($promotion, $shoppingData);
                    if (!$usePromotion->check()) {
                        Yii::$app->response->statusCode = 400;
                        return ['code' => 400, 'message' => '优惠码不可用'];
                    }
                    $discountPrice = $usePromotion->apply();
                    UseDiscount::cancel($shoppingData);
                    Booking::saveDiscountType($shoppingData, 4);
                } else {
                    //获取最优惠的一个并使用
                    $discount = Booking::getCouponByCode($shoppingData, $promotionCode);
                    if(empty($discount)) {
                        Yii::$app->response->statusCode = 400;
                        return ['code' => 400, 'message' => '优惠码不可用'];
                    }

                    $useDiscount = new UseDiscount($discount, $shoppingData);
                    $discountPrice = $useDiscount->apply();
                    UsePromotion::cancel($shoppingData);
                    Booking::saveDiscountType($shoppingData, 3);
                }
                UsePoints::cancel($shoppingData);
                return Booking::_returnData($shoppingData, $discountPrice);
            } catch (\Exception $e) {
                Yii::$app->response->statusCode = 400;
                return ['code' => 400, 'message' => $e->getMessage()];
            }
        } else {
            Yii::$app->response->statusCode = 400;
            return ['code' => 400, 'message' => '请输入正确的优惠码'];
        }
    }

    /**
     * 取消使用优惠券接口
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     * @return array
     */
    public function actionDeletePromotion() {
        $request = json_decode(Yii::$app->request->getRawBody(), true);

        if (empty($request['shoppingId'])) {
            Yii::$app->response->statusCode = 400;
            return ['code' => 400, 'message' => '缺少参数'];
        }

        $shoppingId = $request['shoppingId'];
        $shoppingData = new ShoppingData($shoppingId);
        $shoppingData->getInventory();

        UsePromotion::cancel($shoppingData);
        UseDiscount::cancel($shoppingData);
        Booking::saveDiscountType($shoppingData, 5);
        return Booking::_returnData($shoppingData, 0);
    }

    /**
     * 使用积分接口
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     * @return array
     */
    public function actionUsePoints() {
        $request = json_decode(Yii::$app->request->getRawBody(), true);

        if (empty($request['shoppingId']) || empty($request['points'])) {
            Yii::$app->response->statusCode = 400;
            return ['code' => 400, 'message' => '缺少参数'];
        }

        $points = $request['points'];
        $shoppingId = $request['shoppingId'];

        try {
            $shoppingData = new ShoppingData($shoppingId);
            $shoppingData->getInventory();
            $usePoints = new UsePoints($shoppingData);

            if (!$usePoints->check($points)) {
                Yii::$app->response->statusCode = 400;
                return ['code' => 400, 'message' => '无法使用积分'];
            }

            $discountPrice = $usePoints->apply($points);
            return Booking::_returnData($shoppingData, $discountPrice);
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 400;
            return ['code' => 400, 'message' => $e->getMessage()];
        }
    }

    /**
     * 取消使用积分接口
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     * @return array
     */
    public function actionDeletePoints() {
        $request = json_decode(Yii::$app->request->getRawBody(), true);

        if (empty($request['shoppingId'])) {
            Yii::$app->response->statusCode = 400;
            return ['code' => 400, 'message' => '缺少参数'];
        }

        $shoppingId = $request['shoppingId'];
        $shoppingData = new ShoppingData($shoppingId);
        $shoppingData->getInventory();

        UsePoints::cancel($shoppingData);

        return Booking::_returnData($shoppingData, 0);
    }



    /**
     * 获取产品价格清单接口
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     * @param $shoppingId string 订购Id
     * @param $check boolean 下单检查
     * @return array
     */
    public function actionCountPrice($shoppingId, $check = false)
    {
        try {
            $shoppingData = new ShoppingData($shoppingId);
            $result = GetInventory::data($shoppingData, $check);

            // 计算秒杀价格
            $offPercent = GetOffPercent::data($shoppingData->pcode);

            //折后价
            if($offPercent['offPercent'] == 1) $offPercent = GetAfterDiscount::data($shoppingData->pcode);
            $result['totalAmount'] = Yii::$app->helper->ceil2($result['totalAmount'] - $result['participateCouponAmount'] * (1 - $offPercent['offPercent']));

            foreach ($result['totalAmounts'] as &$totalAmount) {
                $totalAmount['amount'] = Help::exchangeCurrency($result['totalAmount'], $result['currency'], $totalAmount['currency'], 'ceil2');
                $totalAmount['currency'] = Yii::$app->params['currencies'][$totalAmount['currency']];
            }

            $result['currency'] = Yii::$app->params['currencies'][$result['currency']];

            return ['rs' => 1, 'data' => $result, 'url' => Yii::$app->config->bookingUrl . '/tour/order/' .  $shoppingId];
        } catch (\Exception $e) {
            return ['rs' => 0, 'code' => $e->getCode(), 'msg' => $e->getMessage()];
        }
    }


    /**
     * 检查上车地点信息
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2018-01-16
     * @param $shoppingId string 订购Id
     * @return bool
     */
    public function actionCheck($shoppingId) {
        try {
            $shoppingData = new ShoppingData($shoppingId);
            if ($shoppingData->checkStep1()) {
                return ['code' => 200];
            }
        } catch (\Exception $e) {
            return ['code' => 400, 'message' => $e->getMessage()];
        }
    }
}