<?php
/**
 * 快速登录
 * @copyright (c) 2017, lulutrip.com
 * @author  Justin Jia<justin.jia@ipptravel.com>
 */
namespace lulutrip\modules\rentcar\actions\order;

use lulutrip\library\Users;
use yii\base\Action;
use Yii;

class UserQuickLogin extends Action {
    public function run() {
        $request = Yii::$app->request->post();

        try{
            $user = new Users();
            $user->quickLogin($request);
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 400;
            return ['code' => $e->getCode(), 'message' => $e->getMessage()];
        }
    }
}