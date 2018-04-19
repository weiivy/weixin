<?php
/**
 * @copyright (c) 2017, lulutrip.com
 * @author LT<todd@lulutrip.com>
 */
namespace lulutrip\actions\cruise;
use api\library\cruise\Tourico;
use linslin\yii2\curl\Curl;
use lulutrip\components\Cookies;
use yii\base\Action;
use Yii;
use yii\helpers\Url;

class SelectCabincat extends Action
{
    public function run()
    {
        $cookie = new Cookies();
        $navigationtype = $cookie->getCookies('navigationtype', 'NA');
        $get = Yii::$app->request->get();
        $itinerary = Yii::$app->session->get('cruise_' . $get['CruiseDestinationID'] . '-' . $get['CruiseLineID'] . '-' . $get['ItineraryID']);
        if (!$itinerary) {
            Yii::$app->getSession()->setFlash('error', '邮轮信息已过时，请重新选择产品');
            return $this->controller->redirect(Yii::$app->params['service']['www'] . '/cruise');
        }
        unset($get['url']);
        $get['ShipId'] = $itinerary['ShipId'];
        $param = http_build_query($get);
        $curl = new Curl();
        $curl->setOption(CURLOPT_TIMEOUT, 300);
        $res = $curl->get(Yii::$app->params['service']['api'] . '/cruise/select-cabincat?' . $param);
        $data = json_decode($res, true);
        if (!$data['data']) {
            Yii::$app->getSession()->setFlash('error', '未能查询到客舱类型，请稍后重试或重新选择出发日');
            return $this->controller->redirect(Yii::$app->params['service']['www'] . '/cruise/view/' . $itinerary['viewCode']);
        }
        Yii::$app->session->set('cruiseCabincat_' . $get['CruiseDestinationID'] . '-' . $get['CruiseLineID'] . '-' . $get['SailingID'], $data['data']);
        return $this->controller->render('selected_berth_grade', [
            'navigationtype'  => $navigationtype,
            'itinerary' => $itinerary,
            'param' => $get,
            'cabincat' => $data['data']['CabinCategoriesList']['CabinCategory'],
            'CLXPolicyText' => $data['data']['CLXPolicyText'],
            'NavigationBar' => $data['data']['CabinCategoriesList']['NavigationBar'],
        ]);
    }
}