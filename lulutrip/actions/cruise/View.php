<?php
/**
 * @copyright (c) 2017, lulutrip.com
 * @author LT<todd@lulutrip.com>
 */
namespace lulutrip\actions\cruise;
use lulutrip\components\Cookies;
use lulutrip\library\Seotdk;
use yii\base\Action;
use linslin\yii2\curl\Curl;
use Yii;


class View extends Action
{
    public function run()
    {
        $get = Yii::$app->request->get();
        $code = Yii::$app->request->get('code');
        $code = explode('-', $code);
        if (count($code) != 3 || !is_numeric($code[0]) || !is_numeric($code[1]) || !is_numeric($code[2])) {
            Yii::$app->getSession()->setFlash("error", "邮轮信息已过时，请重新选择产品");
            return $this->controller->redirect(Yii::$app->params['service']['www'] . '/cruise');
        }
        $curl = new Curl();
        $curl->setOption(CURLOPT_TIMEOUT, 300);
        $res = $curl->get(Yii::$app->params['service']['api'] . '/cruise/view?dst=' . $code[0] . '&crl=' . $code[1] . '&iti=' . $code[2] . '&dep=' . $get['dep'] . '&tod=' . $get['tod']);
        //echo $res;die;
        $res = json_decode($res, true);
        if (!$res['data']) {
            Yii::$app->getSession()->setFlash('error', '邮轮信息已过时，请重新选择产品');
            return $this->controller->redirect(Yii::$app->params['service']['www'] . '/cruise');
        }
        $cookie = new Cookies();
        $navigationtype = $cookie->getCookies('navigationtype', 'NA');
        Yii::$app->session->set('cruise_' . $code[0] . '-' . $code[1] . '-'. $code[2], $res['data']['itinerary']);
        Yii::$app->session->set('cruise_states', $res['data']['state']);
        list(\Yii::$app->controller->pageTitle, \Yii::$app->controller->pageKeywords, \Yii::$app->controller->pageDesc) = (new Seotdk())->setDynTDK('cruise', 'view', 'multiple', [
            't_pattern1' => $res['data']['itinerary']['Itinerary']['NameCN'] ? $res['data']['itinerary']['Itinerary']['NameCN'] : $res['data']['itinerary']['Itinerary']['Name'],
            'd_pattern1' => mb_substr($res['data']['ship']['tc_ship_desc'], 0, 80, 'UTF-8'),
        ]);

        //客服电话
        $staticNav = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . '/get-static-nav');

        return $this->controller->render("view", [
            'navigationtype'  => $navigationtype,
            'ship' => $res['data']['ship'],
            'amenityType' => $res['data']['amenityType'],
            'itinerary' => $res['data']['itinerary'],
            'newFilter' => $res['data']['newFilter'],
//            'dep' => $res['data']['staticFilter']['dep'],
//            'tod' => $res['data']['staticFilter']['tod'],
            'get' => $get,
            'phones' => empty($staticNav['data']['IpPhone']) ? [] : $staticNav['data']['IpPhone']
        ]);
    }
}