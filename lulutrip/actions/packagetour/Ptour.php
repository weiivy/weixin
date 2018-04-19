<?php
/**
 * Private Tour 产品页面制作页
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\actions\packagetour;


use yii\base\Action;
use Yii;
class Ptour extends Action
{
    public function run()
    {
        $ptourCode = Yii::$app->request->get('ptourcode', 0);

        //基础信息
        $product = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . "/ptour/get-detail/" . $ptourCode);
        $data['product'] = $product['data'];

        //行程信息
        $itis = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . "/ptour/get-itin/" . $ptourCode);
        $data['itis'] = $itis['data'];

        //客服电话
        //$staticNav = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . '/get-static-nav');
        //$data['phones'] = $staticNav['data']['IpPhone'];
        return $this->controller->render('ptour', $data);
    }
}