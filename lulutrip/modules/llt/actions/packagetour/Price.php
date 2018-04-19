<?php
/**
 * 标准化包团详情页计算价格action
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\modules\llt\actions\packagetour;
use linslin\yii2\curl\Curl;
use yii\base\Action;
use Yii;
class Price extends Action
{
    public function run()
    {
        $post = \Yii::$app->request->post(null, array());
        $packId = empty($post['packid']) ? 0 : $post['packid'];
        $curl = new Curl();
        $result = $curl->reset()->setOption(
            CURLOPT_POSTFIELDS,
            http_build_query($post))->post(\Yii::$app->params['service']['api'] . "/package-tour/prices/". $packId);
        $data = json_decode($curl->response, true)['data'];
        $sign = Yii::$app->params['curCurrencies']['sign'];
        $res = array(
            'price' =>  $sign . $data['price'][Yii::$app->params['curCurrency']],
            'perPrice' => $sign .$data['perPrice'][Yii::$app->params['curCurrency']],
            'basePrice' =>  $sign .$data['basePrice'][Yii::$app->params['curCurrency']],
        );
        return json_encode($res);
    }
}