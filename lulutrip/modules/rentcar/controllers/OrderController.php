<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/5 0005
 * Time: 下午 3:17
 */

namespace lulutrip\modules\rentcar\controllers;
use yii\web\Controller;
use Yii;

class OrderController extends Controller
{
    public $callmenowRegion;
    public $regionRoot;
    public $pageTitle;
    public $pageKeywords;
    public $pageDesc;
    public $staticUrl;
    public function actions() {
        $this->layout = '@orderModule/views/layouts/main.html';
        $this->staticUrl = Yii::$app->params['staticDomain'] . "/lulutrip/".Yii::$app->params['front_version']."/dist/pages/";
        $this->callmenowRegion = 'NA';
        $this->pageTitle = '租车详情页入口';
        $this->pageKeywords = '';
        $this->pageDesc = '';
        $this->regionRoot = 'NA';
        return [
            'schedulings'           => 'lulutrip\modules\rentcar\actions\order\Schedulings',
            'scheduling-submit'     => 'lulutrip\modules\rentcar\actions\order\SchedulingSubmit',
            'personsInfo'           => 'lulutrip\modules\rentcar\actions\order\PersonsInfo',
            'personsInfo-submit'    => 'lulutrip\modules\rentcar\actions\order\PersonsInfoSubmit',
            'user-quick-login'      => 'lulutrip\modules\rentcar\actions\order\UserQuickLogin',
            'view-voucher'          => 'lulutrip\modules\rentcar\actions\order\ViewVoucher',
            'view-invoice'          => 'lulutrip\modules\rentcar\actions\order\ViewInvoice',
        ];
    }
}