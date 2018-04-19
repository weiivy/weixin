<?php
/**
 * 标准化包团action
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\modules\llt\actions\comment;

use linslin\yii2\curl\Curl;
use lulutrip\library\common\ListPage;
use yii\base\Action;

class PackageTour extends Action
{
    public function run()
    {
        $packId = \Yii::$app->request->post('packId', 0);
        $page = \Yii::$app->request->post('page', 1);
        $type = \Yii::$app->request->post('type', 1);

        //每页显示
        $pageSize = 3;

        //评论数据
        $params = array($packId, $page, $pageSize);
        $curl = new Curl();
        $result = $curl->get(\Yii::$app->params['service']['api'] . "/package-tour/comment/". implode('/', $params));
        $return = json_decode($curl->response, true);
        $data['tourComms'] = $return['data']['list'];

        //分页
        $listpage = new ListPage($page,$pageSize, $return['data']['count']);
        $data['pageData'] = $listpage->getPage('current',9, $type . 'comm');
        $data['type'] = $type;
        return json_encode(array('content' =>  $this->controller->renderPartial('@lulutrip/views/comment/_comment', $data)));
    }
}