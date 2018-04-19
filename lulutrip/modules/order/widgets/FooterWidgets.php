<?php
/**
 * 简易 - 底部
 * @copyright (c) 2017, lulutrip.com
 * @author  Serena Liu<serena.liu@ipptravel.com>
 */

namespace lulutrip\modules\order\widgets;

use yii\base\Widget;
use Yii;
class FooterWidgets extends Widget
{
    public function run()
    {
        //客服电话
        $serviceTel = Yii::$app->helper->curlPost(Yii::$app->params['service']['api'] . '/admin/base/phone/list');

        return $this->render('@orderModule/views/widgets/footer.html', [
            'serviceTelDefault'         => !empty($serviceTel['default']) ? $serviceTel['default'] : array()
        ]);
    }
} 