<?php
/**
 * 右侧小部件
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\widgets;

use linslin\yii2\curl\Curl;
use yii\base\Widget;
use lulutrip\components\WebUser;

class SidebarWidgets extends Widget
{
    public function run()
    {
        $user = new WebUser();
        $curl = new Curl();
        $member = $user->getCurrentUser();
        $qrcode = null;
        if ($member['memberid']) {
            $result = $curl->get(\Yii::$app->params['service']['api'] . "/get-wxcode/" . $member['memberid']);
            $return = json_decode($curl->response, true);
            $qrcode = $return['data'];
        }

        //客服电话
        $curl->post(\Yii::$app->params['service']['api'] . "/admin/base/phone/list");
        $serviceTel = json_decode($curl->response, true);

        return $this->render('@lulutrip/views/widgets/_sidebar', [
            'params' => \Yii::$app->params,
            'QRCode' => $qrcode,
            'serviceTel' => empty($serviceTel['data']) ? [] : $serviceTel['data']
        ]);
    }
}