<?php
/**
 * 小众产品专区
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\actions\aggregation;

use lulutrip\library\common\ListPage;
use yii\base\Action;
use Yii;

class Index extends Action
{
    public $region;
    public function run()
    {
        //分页相关数据
        $page = \Yii::$app->request->get('page', 1);
        $pageSize = 10;
        $regionPa = (empty($this->region) ? 'na' : $this->region);
        $this->controller->regionRoot = strtoupper($regionPa);
        $result = Yii::$app->helper->curlGet(Yii::$app->params['service']['api'] . "/get-aggregation/". implode('/', array($page, $pageSize, $regionPa)));
        $data['list'] = $result['data']['data'];

        //分页
        $get['page'] = $page;
        $link = "/aggregation/index" . Yii::$app->helper->mergeUrl($get);

        $link = str_replace('page-' . $page, 'page-{{page}}', $link);
        $listpage = new ListPage($page, $pageSize, $result['data']['count'], $link);
        $data['pageData'] =  $listpage->getPageDots();

        //页码数
        $data['pageCount'] = ceil($result['data']['count'] / $pageSize);

        return $this->controller->render('index', $data);
    }
} 