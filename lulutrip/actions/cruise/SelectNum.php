<?php
/**
 * @copyright (c) 2017, lulutrip.com
 * @author LT<todd@lulutrip.com>
 */
namespace lulutrip\actions\cruise;

use lulutrip\components\Cookies;
use yii\base\Action;
use Yii;
class SelectNum extends Action
{
    public function run()
    {
        $get = Yii::$app->request->get();
        $itinerary = Yii::$app->session->get('cruise_' . $get['dst'] . '-' . $get['crl'] . '-' . $get['iti']);
        //print_r($itinerary);die;
        if (!$itinerary) {
            Yii::$app->getSession()->setFlash('error', '邮轮信息已过时，请重新选择产品');
            return $this->controller->redirect(Yii::$app->params['service']['www'] . '/cruise');
        }
        $states = Yii::$app->session->get('cruise_states');
        $cookie = new Cookies();
        $navigationtype = $cookie->getCookies('navigationtype', 'NA');

        //客服信息
        $staticNav = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . '/get-static-nav');

        return $this->controller->render('selected_people_num', [
            'navigationtype'  => $navigationtype,
            'itinerary' => $itinerary,
            'param' => $get,
            'states' => $states,
            'phones' => empty($staticNav['data']['IpPhone'])
        ]);
    }
}