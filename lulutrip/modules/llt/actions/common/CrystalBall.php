<?php
namespace lulutrip\modules\llt\actions\common;

use lulutrip\components\WebUser;
use yii\base\Action;
use Yii;

class CrystalBall extends Action
{
    public function run()
    {
        $name = trim(Yii::$app->request->post('name'));
        $type = trim(Yii::$app->request->post('type'));
        $user = new WebUser();
        $userInfo = $user->getCurrentUser();
        $operationId = empty($userInfo) ? $userInfo['memberid'] :  Yii::$app->cookies->getCookies('Lulutrip_LSM', 0);
        $data = array(
            'operationid' => $operationId,
            'name' => $name,
            'click_action' => $type,
            'layer' => "crystal_ball ",
            'datetime' => time()
        );

        //将水晶球log记录到redis 每30分钟向mysql同步一次
        $redisKey = "crystalBallLog";
        $expireKey = 'redisDataToMysql';
        Yii::$app->cache->rPush($redisKey, serialize($data));
        $redisDataToMysql = Yii::$app->cache->get($expireKey);
        if(empty($redisDataToMysql)) {
            $result = Yii::$app->helper->curlPost(Yii::$app->params['service']['api'] . '/crystalball', array($redisKey, $expireKey));
            var_dump($result);die;
        }
    }
}