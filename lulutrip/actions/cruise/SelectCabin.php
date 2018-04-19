<?php
/**
 * @copyright (c) 2017, lulutrip.com
 * @author LT<todd@lulutrip.com>
 */
namespace lulutrip\actions\cruise;
use linslin\yii2\curl\Curl;
use lulutrip\components\Cookies;
use yii\base\Action;
use Yii;
use yii\helpers\Url;

class SelectCabin extends Action
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
        $param = http_build_query($get);
        $curl = new Curl();
        $curl->setOption(CURLOPT_TIMEOUT, 300);
        $res = $curl->get(Yii::$app->params['service']['api'] . '/cruise/select-cabin?' . $param);
        //echo $res;die;
        $data = json_decode($res, true);
        if (!$data['data']) {
            Yii::$app->getSession()->setFlash('error', '您选择的客舱无客舱号码信息，请稍后重试或重新选择客舱类别');
            return $this->controller->redirect(Yii::$app->params['service']['www'] . '/cruise/cabincat?' . Url::current(['url' => null, 'ProductID' => null]));
        }
        //var_dump($data);die;

        if ($data['data']['DiningSeatingList'] != null) {
            $cabinCat = Yii::$app->session->get('cruiseCabincat_' . $get['CruiseDestinationID'] . '-' . $get['CruiseLineID'] . '-' . $get['SailingID']);
            $cabinCat['DiningSeatingList'] = $data['data']['DiningSeatingList'];
            Yii::$app->session->set('cruiseCabincat_' . $get['CruiseDestinationID'] . '-' . $get['CruiseLineID'] . '-' . $get['SailingID'], $cabinCat);
        }
        $cat = $this->getCat($get);
        return $this->controller->render('selected_berth_num', [
            'navigationtype'  => $navigationtype,
            'itinerary' => $itinerary,
            'param' => $get,
            'totalPrice' => $cat['TotalPrice'],
            'cabins' => $data['data'],
            'cat' => $cat['cat'],
        ]);
    }

    public function getCat($get)
    {
        $total = 0;
        $cabinCat = Yii::$app->session->get('cruiseCabincat_' . $get['CruiseDestinationID'] . '-' . $get['CruiseLineID'] . '-' . $get['SailingID']);
        foreach ($cabinCat['CabinCategoriesList']['CabinCategory'] as $catList) {
            foreach ($catList as $cat){
                foreach ($cat['Prices']['CabinCategoryPrice'] as $price) {
                    if ($price['ProductID'] == $get['ProductID']) {
                        $price['TotalPrice']['NCF'] = $price['NCF'];
                        return [
                            'TotalPrice' => $price['TotalPrice'],
                            'cat' => $cat,
                            'DiningSeating' => $cabinCat['DiningSeatingList']['DiningSeating']
                        ];
                    }
                }
            }
        }
    }
}