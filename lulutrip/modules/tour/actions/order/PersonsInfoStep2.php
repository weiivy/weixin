<?php
/**
 * 旅行团 信息人填写
 * @copyright (c) 2017, lulutrip.com
 * @author  Victor Tang<victor.tang@ipptravel.com>
 */
namespace lulutrip\modules\tour\actions\order;

use common\models\Promotion;
use lulutrip\modules\tour\library\booking\api\GetDiscount;
use lulutrip\modules\tour\library\booking\api\BCSoft;
use lulutrip\modules\tour\library\booking\Order;
use lulutrip\modules\tour\library\booking\ShoppingData;
use lulutrip\modules\tour\library\booking\shoppingData\ContactInfo;
use lulutrip\modules\tour\library\booking\shoppingData\TravellerInfo;
use lulutrip\modules\tour\library\booking\UseDiscount;
use lulutrip\modules\tour\library\booking\UsePromotion;
use lulutrip\modules\tour\library\booking\UsePoints;
use lulutrip\library\Users;
use yii\rest\Action;
use Curl\Curl;
use Yii;

class PersonsInfoStep2 extends Action {

    public $modelClass = false;

    public function run() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->submit();
    }
    /**
     * 第 2 步 "资料填写"
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-27
     * @return array
     */
    private function submit()
    {
        try {
            // 检查第 2 步 "资料填写" 表单数据
            $request = Yii::$app->request->post();
            $shopping = new ShoppingData($request['shoppingId']);

            // 检查必填字段
            if (empty($request['shoppingId']) || empty($request['travellerInfo']) || empty($request['contactInfo']['areaCode']) || empty($request['contactInfo']['phoneNumber']) || empty($request['contactInfo']['fullName']) || empty($request['contactInfo']['emailAddress'])) {
                throw new \Exception('缺少参数', 400);
            }
            // 检查旅客信息
            if (empty($request['travellerInfo'][1]['areaCode']) || empty($request['travellerInfo'][1]['phoneNumber'])) {
                throw new \Exception("第一位旅客默认为联系人，请填写手机号码以方便联系。", 400);
            }
            foreach ($request['travellerInfo'] as $travelInfo) {
                if (empty($travelInfo['firstName']) or empty($travelInfo['lastName'])) {
                    throw new \Exception("请填写旅客信息。", 400);
                }
            }
            //判断邮箱格式
            if(!Yii::$app->helper->ce($request['contactInfo']['emailAddress'])){
                throw new \Exception('邮箱地址格式不正确', 400);
            }

            // 保存第 2 步 "资料填写" 表单数据
            foreach ($request['travellerInfo'] as $travelInfo) {
                $shopping->travellerInfo[] = new TravellerInfo($travelInfo);
            }
            $shopping->contactInfo = new ContactInfo($request['contactInfo']);

            //备注
            $shopping->remarks = $request['remarks'];

            //处理客服信息
            if(isset($request['adviser']))  $shopping->adviser = $request['adviser'];

            // 计算价格 & 使用优惠券 & 积分
            $costDetail = $shopping->getInventory(true);
            if ($promotionCode = $shopping->usePromotion->promotionCode) {
                $promotion = Promotion::find()->where(['promocode' => $promotionCode])->one();
                $usePromotion = new UsePromotion($promotion, $shopping);

                if (!$usePromotion->check()) {
                    Yii::$app->response->statusCode = 400;
                    return ['code' => 400, 'message' => '无法使用当前优惠'];
                }

                $usePromotion->apply();
            }

            if($shopping->useAfterDiscount->id) {
                $discount = GetDiscount::data($shopping->pcode, $shopping->useAfterDiscount->id);
                $discountInfo = json_decode(json_encode($discount['discountInfo']), true);
                $useDiscount = new UseDiscount($discountInfo, $shopping);
                if (!$useDiscount->_check()) {
                    Yii::$app->response->statusCode = 400;
                    return ['code' => 400, 'message' => '无法使用当前优惠'];
                }
                $useDiscount->apply();
                UsePromotion::cancel($shopping);
            }

            if ($points = $shopping->usePoints->points) {
                $usePoints = new UsePoints($shopping);

                if (!$usePoints->check($points)) {
                    Yii::$app->response->statusCode = 400;
                    return ['code' => 400, 'message' => '无法使用积分'];
                }

                $usePoints->apply($points);
            }

            $shopping->getTotalAmount();

            // 获取供应商信息
            $url = Yii::$app->config->tourapi . '/gtravel/lulu/product/' . $shopping->pcode . '/pinfo';
            $result = Yii::$app->helper->curlGet($url);
            if ($result['rs'] == 1) {
                Yii::info('API-GET: ' . $url . '===' . json_encode($result), __METHOD__);
                $shopping->supplier = $result['data']['supplyInfo']['supplierLuluCode'];
                $shopping->supplierProductCode = $result['data']['supplyInfo']['codeOfSupplier'];
                $shopping->supplierProductTitle = $result['data']['supplyInfo']['titleOfSupplier'];
            } else {
                Yii::error('API-GET: ' . $url . '===' . json_encode($result), __METHOD__);
                throw new \Exception($url . "接口错误");
            }

            //获取产品信息
            $curl = new Curl();
            $curl->setHeader('currency', Yii::$app->params['curCurrency']);
            $url = Yii::$app->config->tourapi . "/gtravel/lulu/product/{$shopping->pcode}";
            $curl->get($url);
            $result = json_decode(json_encode($curl->response), true);
            if ($result['rs'] == 1) {
                Yii::info('API-GET: ' . $url . '===' . json_encode($result), __METHOD__);
                $shopping->productTitle = $result['data']['translation']['title'];
                $shopping->tourlen = $result['data']['basic']['duration'];
                $shopping->returnDate = date('Y-m-d', strtotime("+" . ($shopping->tourlen - 1) . " days", strtotime($shopping->sdate)));
                $shopping->pickupType = $result['data']['basic']['pickupType']['code'];
                $shopping->itineraries = $result['data']['itinerarys'];
//                $shopping->priceIncludes = $result['data']['basic']['priceIncludeLuluCN'];
//                $shopping->priceExcludes = $result['data']['basic']['priceExcludeLuluCN'];
                $shopping->basic = $result['data']['basic'];
//                $shopping->importantNotice = json_encode($result['data']['translation']['needToKnow']);
                $shopping->translation = $result['data']['translation'];
            } else {
                Yii::error('API-GET: ' . $url . '===' . json_encode($result), __METHOD__);
                throw new \Exception("接口错误");
            }

            //获取酒店加订 价格及其他信息
            $hotelAdds = [];
            if (isset($costDetail['inventors']['hotel_add']['items'])) {
                foreach ($costDetail['inventors']['hotel_add']['items'] as $val) {
                    $hotelAdds[$val['itemId']] = $val;
                }
            }
            $shopping->hotelAdds = $hotelAdds;

            //获取自选项目 详情信息
            $activities = [];
            foreach($costDetail['inventors'] as $groups){
                foreach($groups['items'] as $activity){
                    $activities[$activity['itemId']] = $activity;
                }
            }
            $shopping->activities = $activities;
            // 用户 Id
            if (isset(Yii::$app->user->current_user['memberid'])) {
                $memberId = Yii::$app->user->current_user['memberid'];
            } else {
                //未登录情况（包括无注册订购）
                $user = new Users();
                $memberId = $user->noRegisterBuy($request, ['pcode' => $shopping->pcode, 'title' => $shopping->productTitle]);
            }
            $shopping->memberId = $memberId;
            // 黑猫检查库存接口
            (new BCSoft())->productInventory($shopping);

            // 下单
            $order = (new Order())->create($shopping);

            return ['orderId' => $order->orderid];
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 400;
            $data = ['code' => $e->getCode(), 'message' => $e->getMessage()];
            return $data;
        }
    }
}