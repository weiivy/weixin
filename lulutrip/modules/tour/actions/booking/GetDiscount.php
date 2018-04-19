<?php

namespace lulutrip\modules\tour\actions\booking;


use api\library\Help;
use lulutrip\models\sale\Activities;
use lulutrip\modules\tour\library\booking\api\GetAfterDiscount;
use lulutrip\modules\tour\library\booking\api\GetOffPercent;
use lulutrip\modules\tour\library\booking\Booking;
use lulutrip\modules\tour\library\booking\PromotionRule;
use lulutrip\modules\tour\library\booking\ShoppingData;
use lulutrip\modules\tour\library\detail\Discount;
use yii\base\Action;
use Yii;

/**
 * 获取秒杀折后价折扣信息(下单调取折扣)
 * @copyright (c) 2018, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
class GetDiscount extends Action
{
    public $step;
    public function run($shoppingId)
    {
        $this->step = Yii::$app->request->get('step');
        $shoppingData = new ShoppingData($shoppingId);
        Booking::saveDiscountType($shoppingData, null);
        $shoppingData->getInventory();
        $availableDiscount = $this->_getGroupBuyInfo($shoppingData);

        //获取折扣
        if(empty($availableDiscount)){
            $availableDiscount = $this->_getDiscountInfo($shoppingData);
        }

        $data['discount'] = $availableDiscount;
        $data['step'] = 1;

        //标记是否使用满减
        if($this->step == 2) {
            $data['step'] = (int)$this->step;
            $data['useFull'] = empty($availableDiscount);
            $data['fullReduceDiscount'] = $this->_getFullReduceDiscount($shoppingData);
        }
        return $data;
    }

    /**
     * 获取折扣信息
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-12-05
     * @param ShoppingData $shoppingData
     * @return mixed
     */
    private function _getDiscountInfo(ShoppingData $shoppingData)
    {
        //获取折扣
        $afterDiscount = GetAfterDiscount::data($shoppingData->pcode);
        $availableDiscount = [];
        if(!empty($afterDiscount['detailInfo'])) {
            $shoppingData->getInventory();
            $availableDiscount = $afterDiscount['detailInfo'];
            $availableDiscount->discountPrice = Help::exchangeCurrency($shoppingData->useAfterDiscount->discountPrice, $shoppingData->currency, Yii::$app->params['curCurrencies']['code'], 'ceil2');
            $availableDiscount->currency  = Yii::$app->params['curCurrencies'];
            $availableDiscount->type = 2; //折后价
        }
        return $availableDiscount;
    }

    /**
     * 秒杀信息
     * @copyright (c) 2018, lulutrip.com
     * @author  Ivy Zhang<ivyzhang@lulutrip.com>
     */
    private function _getGroupBuyInfo(ShoppingData $shoppingData)
    {
        $groupBuy = GetOffPercent::data($shoppingData->pcode);
        $availableDiscount = [];
        if($groupBuy['offPercent'] < 1 && $groupBuy['offPercent'] > 0) {
            $shoppingData->getInventory();
            $availableDiscount = $groupBuy['tagInfo'];
            $availableDiscount->discountPrice = Help::exchangeCurrency($shoppingData->usePromotion->discountPrice, $shoppingData->currency, Yii::$app->params['curCurrencies']['code'], 'ceil2');
            $availableDiscount->currency  = Yii::$app->params['curCurrencies'];
            $availableDiscount->type = 1;  //秒杀
        }
        return $availableDiscount;
    }

    /**
     * 过滤满减活动(下单第二页)
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-02-03
     * @param ShoppingData $shoppingData
     * @return array 返回数据
     */
    private function _getFullReduceDiscount(ShoppingData $shoppingData)
    {
        $post = [
            'channel'     => Activities::CHANNEL_1,
            'platform'    => Activities::PLATFORM_LUPC,
            'pid'         => $shoppingData->pcode,
            'noDiscount'  => true
        ];
        $result = Yii::$app->helper->curlPost(Yii::$app->config->api . '/saleactivity/get-discounts', $post);
        if(empty($result['data']))  return [];

        //过滤符合条件的
        $promotionRule = new PromotionRule($result['data'], $shoppingData);
        $discounts = $promotionRule->checkPromotions();
        $data = [];
        foreach($discounts as $discount) {
            $data[] = Discount::formatData((object)$discount, $shoppingData->pcode);
        }
        return $data;
    }




} 