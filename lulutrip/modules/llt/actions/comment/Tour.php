<?php
/**
 * 旅行团action
 * @copyright (c) 2017, lulutrip.com
 * @author  xiaopei Dou<xiaopei.dou@ipptravel.com>
 */
namespace lulutrip\modules\llt\actions\comment;

use linslin\yii2\curl\Curl;
use lulutrip\library\common\ListPage;
use api\library\product\Comment;
use yii\base\Action;

class Tour extends Action
{
    public function run()
    {

        //$params = json_decode(\Yii::$app->request->rawBody, true);
        $params = \Yii::$app->request->post();
        $tourCode = $params['tourCode'];
        $page = $params['page'] > 0 ? $params['page']-1 : 0;
        $pageSize = empty($params['$pageSize'])? 3 : $params['page'];
        $type = empty($params['type'])? 'tour' : $params['type'];
        $site  = 'PC';
        $model = new Comment;
        $count = $model->getCommsNum($tourCode, $type, $site);
        $list  = $model->getById($tourCode, $type, $site, $page, $pageSize);

        $data['commsNum'] = $count;
        foreach ($list as $val){
            $comms = array();
            //用户头像
            $comms['avatar'] = empty($val['avatar'])? \Yii::$app->params['staticDomain'] . '/llt-static/images/detail/comment-avatar' . rand(1,2) . '.jpg' :  \Yii::$app->helper->getImgDomain() . '/' .$val['avatar'];
            //用户呢称
            $comms['screenName'] = $val['screenname'];
            //评价主题
            $comms['subject'] = $val['subject'];
            //评价内容
            $comms['content'] = htmlspecialchars_decode($val['content'], ENT_QUOTES);
            //Lulutrip评分
            $comms['luluRating'] = $val['ratings']['lulutrip'];
            //旅行团评分
            $comms['travelRating'] = $val['ratings']['scenery'];
            //回复内容
            $comms['reply'] = htmlspecialchars_decode($val['reply'], ENT_QUOTES);
            $data['commsInfo'][] = $comms;
        }

        return json_encode(array('data' => $data, 'rs' => '1'));
    }
}