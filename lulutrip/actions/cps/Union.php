<?php

namespace lulutrip\actions\cps;

use yii\base\Action;
use Yii;

/**
 * Class Union
 * @package lulutrip\actions\cps
 */
class Union extends Action {

    /**
     * @var array
     */
    private $_sources = ['linkstars'];

    /**
     * 什么值得买 UNION 接口
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2018-03-08
     * @param $source
     * @param $feedback
     * @param $to
     * @throws \Exception
     */
    public function run($source, $feedback, $to) {
        if (in_array($source, $this->_sources)) {
            $_SESSION['cps']['source'] = $source;
        } else {
            throw new \Exception("非法链接");
        }

        $_SESSION['cps']['feedback'] = $feedback;

        Yii::$app->response->redirect($to);
    }
}