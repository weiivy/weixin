<?php
/**
 * 旅行团 信息人填写
 * @copyright (c) 2017, lulutrip.com
 * @author  Serena Liu<serena.liu@ipptravel.com>
 */
namespace lulutrip\modules\tour\actions\order;

use lulutrip\modules\tour\library\booking\api\GetBooking;
use lulutrip\modules\tour\library\booking\api\GetProductInfo;
use lulutrip\modules\tour\library\booking\api\GetSupplierInfo;
use lulutrip\modules\tour\library\booking\Booking;
use lulutrip\modules\tour\library\booking\ShoppingData;
use yii\base\Action;
use Yii;
use common\models\AdviserSalers;


class PersonsInfo extends Action {
    public function run($shoppingId) {
        $shoppingData = new ShoppingData($shoppingId);
        Booking::saveDiscountType($shoppingData, null);

        try {
            $shoppingData->checkStep1();
        } catch (\Exception $e) {
            return "<script>alert('{$e->getMessage()}');window.location.href='/tour/booking/{$shoppingId}';</script>";
        }

        // Get Supplier Code
        $supplierInfo = GetSupplierInfo::data($shoppingData);

        $adults = $children = [];
        foreach ($shoppingData->roomInfos as $roomIndex => $roomInfo) {
            for ($i = 1; $i <= $roomInfo->adNum; $i++) {
                $adults[] = ['roomIndex' => $roomIndex, 'isAdult' => 1, 'pf' => $roomInfo->pf];
            }
            for ($i = 1; $i <= $roomInfo->kdNum; $i++) {
                $children[] = ['roomIndex' => $roomIndex, 'isAdult' => 0, 'pf' => $roomInfo->pf];
            }
        }

        $result = Yii::$app->helper->curlGet(\Yii::$app->params['service']['api'] . "/data/phoneAreaCodes");
        $phoneAreaCodes = $result['data']['phoneAreaCodes'];

        $productInfo = GetProductInfo::data($shoppingData);

        //获取顾问数据
        $advisers = AdviserSalers::find()->select('id, cart_no, name_en')->where("`status` = 0 AND order_service = 1")->orderBy('cart_no')->asArray()->all();
        Yii::$app->controller->pageTitle = '路路行下单页-填写资料';
        return $this->controller->render("fill-contactsinfo/index.html", [
            'shoppingId' => $shoppingId,
            'travellers' => array_merge($adults, $children),
            'members' => Yii::$app->user->getCurrentUser(),
            'phoneAreaCodes' => $phoneAreaCodes,
            'advisers' => $advisers,
            'roomSex' => $productInfo['basic']['roomSex'],
            'birthdayIsRequired' => $supplierInfo['basic']['birthday'],
            'nationalityIsRequired' => $supplierInfo['basic']['nationality'],
            'passportNumberIsRequired' => $supplierInfo['basic']['passportNumber']
        ]);
    }
}