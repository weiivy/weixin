<?php
/**
 * @copyright (c) 2017, lulutrip.com
 * @author Serena Liu<serena.liu@ipptravel.com>
 */
namespace lulutrip\actions\cruise;

use lulutrip\library\Seotdk;
use yii\base\Action;
use linslin\yii2\curl\Curl;
use Yii;
use lulutrip\components\Cookies;

class GetSearchTotal extends Action
{
    public function run()
    {
        $curl = new Curl();
        $get = $param = Yii::$app->request->get();
        unset($get['url']);
        $get = http_build_query($get);
        $curl->setOption(CURLOPT_TIMEOUT, 60);
        $search = $curl->get(Yii::$app->params['service']['api'] . '/cruise/search-cruise?' . $get);
        $search = json_decode($search, true);

        echo json_encode([
            'data' => ['num' => $search['data']['num'], 'newFilter' => $search['data']['newFilter']],
            'message' => 'success'
        ]);
        exit;
    }
}