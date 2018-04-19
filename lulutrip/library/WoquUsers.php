<?php

namespace lulutrip\library;

use Curl\Curl;
use yii\base\Component;
use Yii;

/**
 * Class WoquUsers
 * @package lulutrip\library
 */
class WoquUsers extends Component
{
    /**
     * @var boolean
     */
    public $isLogin;

    /**
     * @var integer
     */
    public $userId;

    /**
     * @var string
     */
    public $userName;

    /**
     * @var string
     */
    public $email;

    /**
     * @var integer
     */
    public $countryCode;

    /**
     * @var string
     */
    public $phone;

    /**
     * 根据 sessionId 获取我趣用户信息
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-12-11
     * @param $sessionId string
     * @return $this
     */
    public function getUserInfo($sessionId) {
        $curl = new Curl();
        $curl->setHeader('Content-Type', 'application/json');
        $curl->post(Yii::$app->params['service']['tourapi'] . "/auth/member/query", ['sessionId' => $sessionId]);

        Yii::info("API-POST: " . $curl->url . " " . json_encode(['sessionId' => $sessionId]) . " " . $curl->rawResponse, __METHOD__);

        if ($curl->response->result == true) {
            $this->isLogin = true;
            $this->userId = $curl->response->returnObject->uid;
            $this->userName = $curl->response->returnObject->userName;
            $this->email = $curl->response->returnObject->email;
            $this->countryCode = $curl->response->returnObject->countryCode;
            $this->phone = $curl->response->returnObject->mobile;
        } else {
            $this->isLogin = false;
        }

        return $this;
    }
}