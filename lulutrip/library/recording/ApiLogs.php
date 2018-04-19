<?php
/**
 * @copyright (c) 2017, lulutrip.com
 * @author  martin ren<martin@lulutrip.com>
 */

namespace lulutrip\library\recording;

use linslin\yii2\curl\Curl;
use yii\base\Component;
use Yii;
use yii\helpers\Json;

class ApiLogs extends Component
{
    private $_apiParams;

    public function init()
    {
        $this->_apiParams = Yii::$app->params['apiAdapter'];
    }

    public function update($adapter, $api, $params = [])
    {
        $curl = new Curl;
        $curl->reset()->setOption(
            CURLOPT_POSTFIELDS,
            http_build_query($params))->post($this->_apiParams[$adapter]. $api);

        if($curl->response) {
            return json_decode($curl->response, true);
        }
        return false;
    }
}