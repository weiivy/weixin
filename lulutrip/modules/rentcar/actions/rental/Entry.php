<?php
/**
 * @copyright (c) 2017, lulutrip
 * @author Justin Jia<justin.jia@ipptravel.com>
 */

namespace lulutrip\modules\rentcar\actions\rental;
use Yii;
use yii\base\Action;
use lulutrip\modules\rentcar\library\GetParams;
use lulutrip\library\common\ListPage;

class Entry extends Action
{
    public function run() {
        $api = Yii::$app->params['service']['api'];
        $post = GetParams::getParam();
        $post['pageSize'] = 20;
        $data = Yii::$app->helper->curlPost($api . '/rental-car/list', $post);
        $data['param'] = $post;

        //分页
        $link = (new GetParams())->mergeUrl($post);
        $link = str_replace('page-' . $post['page'], 'page-{{page}}', $link);
        $listpage = new ListPage($post['page'], $post['pageSize'], $data['count'], $link);
        $data['pageData'] =  $listpage->getPageDots();

        //广告信息
        $banners = Yii::$app->helper->curlGet($api . '/banner/get-banner-pos/car_list_mian');
        $data['banners'] = $banners['data'];
        return $this->controller->render('@lulutrip/modules/rentcar/views/rental/entry', $data);
    }
}