<?php
/**
 * @copyright (c) 2017-09-08
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\actions\order;
use Yii;
use yii\rest\Action;
use lulutrip\modules\rentcar\library\booking\ShoppingData;
use lulutrip\library\Users;
use lulutrip\modules\rentcar\library\booking\ShoppingData\PersonsInfo;
use lulutrip\modules\rentcar\library\booking\ShoppingData\ContactInfo;
use common\models\Promotion;
use lulutrip\modules\rentcar\library\booking\UsePromotions;
use lulutrip\modules\rentcar\library\booking\Order;

class PersonsInfoSubmit extends Action
{
    public $modelClass = false;

    public function run() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        try {
            // 检查第 2 步 "资料填写" 表单数据
            $request = Yii::$app->request->post();

            if (empty($request['shoppingId']) || empty($request['personsInfo']['areaCode']) || empty($request['personsInfo']['phoneNumber']) || empty($request['personsInfo']['lastName']) || empty($request['personsInfo']['firstName']) || empty($request['personsInfo']['age']) || empty($request['personsInfo']['type'])) {
                throw new \Exception('缺少参数', 400);
            }

            if (empty($request['contactInfo']['areaCode']) || empty($request['contactInfo']['phoneNumber']) || empty($request['contactInfo']['fullName']) || empty($request['contactInfo']['emailAddress'])) {
                throw new \Exception('请填写订单联系人信息', 400);
            }
            if(!Yii::$app->helper->ce($request['contactInfo']['emailAddress'])){
                throw new \Exception('缺少参数2', 400);
            }
            $shoppingData = new ShoppingData($request['shoppingId']);

            if (isset(Yii::$app->user->current_user['memberid'])) {
                $memberId = Yii::$app->user->current_user['memberid'];
            } else {
                //未登录情况（包括无注册订购）
                $user = new Users();
                $memberId = $user->noRegisterBuy($request, ['carid' => $shoppingData->carid, 'title' => $shoppingData->cars['title']]);
            }

            // 保存第 2 步 "资料填写" 表单数据
            $shoppingData->memberId = $memberId;
            $shoppingData->personsInfo = new PersonsInfo($request['personsInfo']);
            $shoppingData->remarks = $request['remarks'];
            $shoppingData->contactInfo = new ContactInfo($request['contactInfo']);
            // 计算价格
            $shoppingData->getInventory();

            // 优惠券
            $promotionCode = !empty($shoppingData->usePromotion->promotionCode) ? $shoppingData->usePromotion->promotionCode : 0;
            if ($promotionCode != 0) {
                $promotion = Promotion::find()->where(['promocode' => $promotionCode])->one();
                $usePromotion = new UsePromotions($promotion, $shoppingData);

                if (!$usePromotion->check()) {
                    Yii::$app->response->statusCode = 400;
                    return ['code' => 400, 'message' => '无法使用该优惠券'];
                }

                $usePromotion->apply();
            }

            $shoppingData->getTotalAmount();
            // 下单
            $order = new Order();
            return $order->create($shoppingData);
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 400;
            $data = ['code' => $e->getCode(), 'message' => $e->getMessage(), 'trace' => $e->getTraceAsString()];
            return $data;
        }
    }
}