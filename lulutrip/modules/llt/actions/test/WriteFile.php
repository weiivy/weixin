<?php
/**
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\llt\actions\test;
use yii\base\Action;
use linslin\yii2\curl\Curl;
use Yii;

class WriteFile extends Action
{
    public function run() {
        $filename = 'test' . date('Ymd') . '.csv'; //设置文件名
        $curl = new Curl();
        $data[] = array(date('Ymd'), date('His'));
        $query = http_build_query(['filename' => $filename, 'data' => $data]);
        $curl->get(Yii::$app->params['service']['upload'] . '/admin/createCsv.php?' . $query);
        return json_decode($curl->response, true);
    }
}