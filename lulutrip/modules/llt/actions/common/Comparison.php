<?php
/**
 * @copyright (c) 2017, lulutrip.com
 * @author  martin ren<martin@lulutrip.com>
 */

namespace lulutrip\modules\llt\actions\common;

use yii\base\Action;
use Yii;
use yii\base\Exception;
use yii\helpers\Json;

class Comparison extends Action
{
    public function run($tourCode)
    {
        $currency = Yii::$app->params['curCurrencies']['code'];
        try {
            $data = (new \lulutrip\modules\llt\library\common\Comparison)->addComparison($tourCode, $currency);
        } catch (Exception $e) {
            echo Json::encode(['status' => $e->getCode(), 'message' => $e->getMessage()]);
            exit;
        }

        //当前币种
        $data['sign'] = Yii::$app->params['curCurrencies']['sign'];
        echo Json::encode(['status' => 200, 'message' => 'success', 'data' => $data]);
        exit;
    }
}