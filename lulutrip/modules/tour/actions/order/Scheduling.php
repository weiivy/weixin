<?php
/**
 * 旅行团 行程信息填写
 * @copyright (c) 2017, lulutrip.com
 * @author  Serena Liu<serena.liu@ipptravel.com>
 */
namespace lulutrip\modules\tour\actions\order;

use lulutrip\modules\tour\library\booking\api\GetBooking;
use lulutrip\modules\tour\library\booking\ShoppingData;
use lulutrip\modules\tour\library\booking\UseDiscount;
use lulutrip\modules\tour\library\booking\UsePoints;
use lulutrip\modules\tour\library\booking\UsePromotion;
use yii\base\Action;
use Yii;

class Scheduling extends Action {

    /**
     * @var array 用于GA参数
     */
    public $gaParams;
    public function run($shoppingId) {
        $shoppingData = new ShoppingData($shoppingId);

        //清除优惠
        UseDiscount::cancel($shoppingData);
        UsePromotion::cancel($shoppingData);
        UsePoints::cancel($shoppingData);
        $data = $this->dealData($shoppingData);
        Yii::$app->params['formData'] = isset($shoppingData->formData) ? $shoppingData->formData : [];

        Yii::$app->controller->pageTitle = '路路行下单页-行程安排';
        return $this->controller->render("scheduling/index.html", array('data' => $data, 'shoppingId' => $shoppingId));
    }
    /**
     * 获取自选项目
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @copyright 2017-08-17
     * @return array
     */
    private function dealData(ShoppingData $shoppingData){
        $result = GetBooking::data($shoppingData);
//        Yii::$app->params['personCount'] = $result['adCount'] + $result['kdCount'];
        Yii::$app->params['pickupType'] = $result['basic']['pickupType'];
        $activities = array();
        foreach ($result['groups'] as $groups){
            //加订酒店 无多选，必选，自选
            if(in_array($groups['subType'], array(41, 42))){
                $activities[$groups['subType']] = $groups;
            }else{
                $groups['countItems'] = count($groups['items']);
                $keyTmp = '';
                if($groups['minItems'] == 0){
                    if($groups['countItems'] <= $groups['maxItems'] || $groups['maxItems'] == 0){
                        $keyTmp = 'select';
                    }else{
                        $keyTmp = 'max-select';
                    }
                }elseif($groups['countItems'] == $groups['minItems']){
                    $keyTmp = 'must';
                }elseif($groups['countItems'] > $groups['minItems']){
                    $keyTmp = 'multi';
                }
                $activities[$groups['subType']][$keyTmp][] = $groups;
            }
        }
        $result['groups'] = $activities;
        return $result;
    }
}