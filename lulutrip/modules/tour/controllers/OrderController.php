<?php
/**
 * 旅行团列表页控制器
 * @copyright (c) 2017, lulutrip.com
 * @author  Serena Liu<serena.liu@ipptravel.com>
 */
namespace lulutrip\modules\tour\controllers;
use Yii;
use yii\web\Controller;
class OrderController extends Controller
{
    public $staticUrl;
    public $pageTitle;
    public $timeOut;

    public function init()
    {
        parent::init();
        $this->timeOut = 24*60*60;
        $this->layout = '@orderModule/views/layouts/main.html';
        $this->staticUrl = Yii::$app->params['staticDomain'] . "/lulutrip/".Yii::$app->params['front_version']."/dist/pages/";
    }

    public function actions()
    {
        return [
            'scheduling' => 'lulutrip\modules\tour\actions\order\Scheduling',
            'scheduling-submit' => 'lulutrip\modules\tour\actions\order\SchedulingStep1',
            'personsInfo' => 'lulutrip\modules\tour\actions\order\PersonsInfo',
            'personsInfo-submit' => 'lulutrip\modules\tour\actions\order\PersonsInfoStep2'
        ];
    }
}