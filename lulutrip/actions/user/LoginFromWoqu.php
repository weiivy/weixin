<?php

namespace lulutrip\actions\user;

use api\models\Members;
use lulutrip\components\Cookies;
use lulutrip\library\WoquUsers;
use yii\base\Action;
use Yii;

/**
 * Class LoginFromWoqu
 * @package lulutrip\actions\user
 */
class LoginFromWoqu extends Action {
    /**
     * 我趣登陆用户跳转到路路行之后自动登陆（或者创建账户）
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-12-11
     * @param $sessionId
     * @param $redirectURI
     * @return mixed
     */
    public function run($sessionId, $redirectURI) {
        $this->_loginFromWoqu($sessionId);
        return Yii::$app->controller->redirect($redirectURI);
    }

    /**
     * 我趣登陆用户跳转到路路行之后自动登陆（或者创建账户）
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-12-11
     * @param $sessionId
     */
    private function _loginFromWoqu($sessionId) {
        $userInfo = (new WoquUsers())->getUserInfo($sessionId);
        if ($userInfo->isLogin) {
            $this->_loginIntoLulutrip($userInfo);
        }
    }

    /**
     * 我趣登陆用户跳转到路路行之后自动登陆（或者创建账户）
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-12-11
     * @param WoquUsers $userInfo
     */
    private function _loginIntoLulutrip(WoquUsers $userInfo) {
        $user = $this->_findRelatedUser($userInfo);

        if ($user) {
            $this->_autoLogin($user);
        } else {
            $this->_autoRegister($userInfo);
        }
    }

    /**
     * 查找关联的lulutrip用户
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-12-11
     * @param WoquUsers $userInfo
     * @return Members|null
     */
    private function _findRelatedUser(WoquUsers $userInfo) {
        if (!empty($userInfo->userId) && $user = Members::find()->where(['woqu_user_id' => $userInfo->userId])->one()) {
            return $user;
        }

        if (!empty($userInfo->email) && $user = Members::find()->where(['email' => $userInfo->email])->one()) {
            $user->woqu_user_id = $userInfo->userId;
            $user->save();
            return $user;
        }

        if (!empty($userInfo->phone) && $user = Members::find()->where(['phone' => $userInfo->phone])->one()) {
            $user->woqu_user_id = $userInfo->userId;
            $user->save();
            return $user;
        }

        return null;
    }

    /**
     * 用户登陆
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-12-11
     */
    private function _autoLogin(Members $user) {
        Yii::$app->cookies->setCookies("LuluUser", Cookies::encrypt($user->memberid));
        Yii::$app->cookies->setCookies("LuluUserEmail", Cookies::encrypt($user->email), 30);
    }

    /**
     * 用户注册
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-12-11
     * @param WoquUsers $userInfo
     */
    private function _autoRegister(WoquUsers $userInfo) {
        $user = new Members();
        $user->woqu_user_id = $userInfo->userId;
        $user->screenname = $userInfo->userName ? $userInfo->userName : ($userInfo->email ? $userInfo->email : ($userInfo->phone ? $userInfo->phone : "woqu_user_{$userInfo->userId}"));
        $user->email = $userInfo->email;
        $user->phonearea = (int)$userInfo->countryCode;
        $user->phone = $userInfo->phone;
        if ($user->save()) {
            $this->_autoLogin($user);
        } else {
            Yii::error('自动注册账户失败' . json_encode($user->errors), __METHOD__);
        }
    }
}