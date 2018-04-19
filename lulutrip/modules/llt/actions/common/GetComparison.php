<?php
/**
 * 获取对比数据
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\modules\llt\actions\common;


use yii\base\Action;
use Yii;
class GetComparison extends Action
{
    public function run()
    {
        $tourCodes = Yii::$app->request->post("tourCodes");
        $tourCodes = empty($tourCodes) ? [] : explode(',', $tourCodes);
        $data = [];
        $currency = Yii::$app->params['curCurrencies']['code'];

        foreach($tourCodes as $tourCode) {
            $result = Yii::$app->helper->curlGet(API_BASE.'/tour/comparison/' . $tourCode . '/' . $currency);
            if($result['status'] != 200) continue;
            $result['data']['sign'] = Yii::$app->params['curCurrencies']['sign'];
            $data[] = $result['data'];
        }

        echo json_encode([
                'status' => 200,
                'message' => 'success',
                'data'    => $data
        ]);exit;
    }
} 