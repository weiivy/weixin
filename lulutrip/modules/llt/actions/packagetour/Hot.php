<?php
/**
 * 标准化包团列表页获取热门包团产品action
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\modules\llt\actions\packagetour;
use linslin\yii2\curl\Curl;
use yii\base\Action;
class Hot extends Action
{
    public function run()
    {
        $curl = new Curl();
        $session = \Yii::$app->session;
        $page = \Yii::$app->request->get('page', 1);
        $refresh = \Yii::$app->request->get('refresh');
        $return = $refresh > 0 ? array() : $session->get('hotSale');
        if(empty($return)) {
            $result = $curl->get(\Yii::$app->params['service']['api'] . "/package-tour/get-hot");
            $return = json_decode($curl->response, true)['data'];
            $session->set('hotSale', $return);
        }
        $pageSize = 5;
        $totalPage = ceil(count($return['data']) / $pageSize);
        $curPage = $page;
        $prePage = ($curPage > 1) ? $curPage-1 : 1;
        $nePage = ($curPage < $totalPage) ? $curPage+1 : $totalPage;
        return $this->controller->renderPartial('@lulutrip/views/package-tour/_hotsale', array(
            'hotSales' => $return['data'],
            'totalPage' => $totalPage,
            'curPage' => $curPage,
            'prePage' => $prePage,
            'nePage' => $nePage,
        ));
    }
}