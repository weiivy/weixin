<?php
/**
 * @copyright (c) 2017, lulutrip.com
 * @author LT<todd@lulutrip.com>
 */
namespace lulutrip\actions\cruise;

use lulutrip\components\Cookies;
use lulutrip\components\WebUser;
use yii\base\Action;
use Yii;
use yii\base\InvalidParamException;
use yii\web\NotAcceptableHttpException;

class AddToCart extends Action
{
    public function run()
    {
        $get = Yii::$app->request->get();
        $out = [];
        $cabinCat = Yii::$app->session->get('cruiseCabincat_' . $get['CruiseDestinationID'] . '-' . $get['CruiseLineID'] . '-' . $get['SailingID']);
        $ship = Yii::$app->session->get('cruise_' . $get['CruiseDestinationID'] . '-' . $get['CruiseLineID'] . '-' . $get['ItineraryID']);
        if (!$cabinCat || !$ship) {
            Yii::$app->getSession()->setFlash('error', '邮轮信息已过时，请重新选择产品');
            return $this->controller->redirect(Yii::$app->params['service']['www'] . '/cruise');
        }
        foreach ($cabinCat['CabinCategoriesList']['CabinCategory'] as $catList) {
            foreach ($catList as $cat){
                foreach ($cat['Prices']['CabinCategoryPrice'] as $price) {
                    if ($price['ProductID'] == $get['ProductID']) {
                        unset($cat['Prices']);
                        $out['cabinCat'] = $cat;
                        $out['cabinCat']['price'] = $price;
                        $out['CLXPolicyText'] = $cabinCat['CLXPolicyText'];
                        $out['diningSeating'] = $cabinCat['DiningSeatingList']['DiningSeating'];
                        break;
                    }
                }
            }
        }
        if ($out == null) {
            Yii::$app->getSession()->setFlash('error', '邮轮信息已过时，请重新选择产品');
            return $this->controller->redirect(Yii::$app->params['service']['www'] . '/cruise');
        }
        foreach ($ship['SailingDates']['Sailing'] as $sail) {
            if ($sail['SailingID'] == $get['SailingID']) {
                unset($ship['SailingDates']);
                $out['info'] = $ship;
                $out['info']['sailing'] = $sail;
            }
        }
        unset($get['url']);
        $out['param'] = $get;
        $user = (new WebUser())->getCurrentUser();
        if (isset($user['memberid']) && $user['memberid']) {
            $key = 'cruiseOrder_' . $user['memberid'];
        } else {
            $cookie = new Cookies();
            $lsm = $cookie->getCookies('Lulutrip_LSM');
            if (!$lsm) {
                $lsm = md5('cruiseuser_' . time());
                $cookie->setCookies('Lulutrip_LSM', $lsm);
            }
            $key = 'cruiseOrder_' . $lsm;
        }
        Yii::$app->redisShared->set($key, $out, 15 * 60);
        //Yii::$app->cache->set($key, $out, 15 * 60);
        $this->controller->redirect(Yii::$app->params['service']['ssl'] . '/cart/view');
        return;
    }
}