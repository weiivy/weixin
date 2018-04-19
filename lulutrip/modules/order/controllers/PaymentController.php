<?php
/**
 * 支付相关
 * @copyright (c) 2017, lulutrip.com
 * @author  Serena Liu<serena.liu@ipptravel.com>
 */

namespace lulutrip\modules\order\controllers;

class PaymentController extends BaseController
{
    public function actions()
    {
        return [
            'result' => 'lulutrip\modules\order\actions\payment\Result'
        ];
    }

} 