<?php
/**
 * 用户反馈表.
 * User: Justin Jia<justin.jia@ipptravel.com>
 * Date: 2017/7/3 0003
 * Time: 上午 10:35
 */

namespace lulutrip\modules\llt\actions\packagetour;

use yii\base\Action;
use Yii;

class Feedback extends Action {
    public function run() {
        $page = Yii::$app->request->get('page', 1);
        $feedback = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . "/package-tour/feedback/" . $page);
        return json_encode($feedback);
    }
}