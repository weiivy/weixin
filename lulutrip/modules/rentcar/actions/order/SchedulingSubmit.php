<?php
/**
 * @Summary 自选项目填写
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\actions\order;
use Yii;
use yii\base\Action;
use lulutrip\modules\rentcar\library\booking\ShoppingData;
use lulutrip\modules\rentcar\library\booking\OptionalProject;

class SchedulingSubmit extends Action
{
    public function run() {
        $request = Yii::$app->request->post();
        $shoppingId = Yii::$app->request->post('shoppingId');
        $shoppingData = new ShoppingData($shoppingId);
        $shoppingData->formData = $this->dealData($request);
        $shoppingData->save();
        return json_encode([
            'op' => $shoppingData->optionalids,
            'status' => 0,
            'message' => 'success',
        ]);
    }

    /**
     * 未选中的，但里面的表单被选中了，做清除处理
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-12-11
     * @param $formData
     * @return mixed
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

        //处理自选项目
        $optionalids = '';
        if (!empty($formData['optional'])) {
            $optionalids = implode(',', $formData['optional']);
            unset($formData['optional']);
        }
        $formData['optionalids'] = $optionalids;
        return $formData;
    }
}