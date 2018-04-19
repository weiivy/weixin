<?php
/**
 * 旅行团 行程信息填写
 * @copyright (c) 2017, lulutrip.com
 * @author  Serena Liu<serena.liu@ipptravel.com>
 */
namespace lulutrip\modules\tour\actions\order;

use lulutrip\modules\tour\library\booking\ShoppingData;
use yii\base\Action;
use Yii;

class SchedulingStep1 extends Action {

    public function run() {
        $this->getData();
    }
    /**
     * 未选中的，但里面的表单被选中了，做清除处理
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @copyright 2017-08-17
     * @return array
     */
    private function dealData($formData){
        //未选中的，但里面的表单被选中了，是否不保存？不保存
        //免费接送机 接机服务
        if(!isset($formData['feePickupAccept'])){
            unset($formData['inflight']);
        }
        //免费接送机 送机服务
        if(!isset($formData['feePickupSend'])){
            unset($formData['outflight']);
        }
        //自选项目
        if(isset($formData['activityGroups'])){
            foreach($formData['activityGroups'] as $groupId => $groups){
                foreach($groups as $itemId => $item){
                    if(!isset($item['itemId'])){
                        unset($formData['activityGroups'][$groupId][$itemId]);
                    }
                }
            }
        }
        //酒店加订 行前
        if(!isset($formData['hotelAddonFront'])){
            unset($formData['advanceHotel']);
        }
        //酒店加订 行后
        if(!isset($formData['hotelAddonBack'])){
            unset($formData['postponeHotel']);
        }
        //行程顾问
        if(!isset($formData['adviserSaler'])){
            unset($formData['adviser']);
        }
        return $formData;
    }
    /**
     * 获取价格清单
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @copyright 2017-08-17
     */
    private function getData(){
        // 检查第 1 步 "行程 自选" 表单数据
        $request = Yii::$app->request->post();
        $shoppingId = $request['shoppingId'];
        $shoppingData = new ShoppingData($shoppingId);
        $shoppingData->formData = $this->dealData($request);
        $shoppingData->save();
    }
}