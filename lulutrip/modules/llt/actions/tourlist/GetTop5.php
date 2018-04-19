<?php
/**
 * top5
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\modules\llt\actions\tourlist;


use yii\base\Action;
use Yii;

class GetTop5 extends Action
{
    public function run()
    {
        $categories = Yii::$app->request->post('categories', ['localjoin']);
        $continent = Yii::$app->request->post('continent');
        $currency = Yii::$app->params['curCurrency'] != 'RMB' ? Yii::$app->params['curCurrency'] : 'CNY';

        $apiUrl = Yii::$app->params['service']['tourapi'] . "/search/lulutrip/top";
        $data = ['categories' => $categories, 'currency' => $currency, "continent" => $continent];
        $result = Yii::$app->helper->curlJson($apiUrl, $data);
        Yii::info('API-POST: ' . $apiUrl . '===' . json_encode($data) . '===' . json_encode($result), __METHOD__);

        foreach($result['data'] as $key => $value) {
            $result['data'][$key]['link'] = Yii::$app->params['service']['www'] . "/tour/view/tourcode-" . $value['id'] . "#list_top5";
            $result['data'][$key]['sign'] = Yii::$app->params['curCurrencies']['sign'];

            //向上取整
            $result['data'][$key]['price'] = ceil($value['price']);
            $result['data'][$key]['marketPrice'] = ceil($value['marketPrice']);
        }

        return json_encode($result);
    }
} 