<?php
/**
 * 旅行团action
 * @copyright (c) 2017, lulutrip.com
 * @author  xiaopei Dou<xiaopei.dou@ipptravel.com>
 */
namespace lulutrip\modules\llt\actions\qna;

use api\library\product\Qna;
use yii\rest\Action;

class Tour extends Action
{
    public $modelClass = '';

    public function run()
    {

        //$params = json_decode(\Yii::$app->request->rawBody, true);
        $params = \Yii::$app->request->post();
        $tourCode = $params['tourCode'];
        $page = $params['page'] > 0 ? $params['page']-1 : 0;
        $pageSize = empty($params['pageSize'])? 3 : $params['pageSize'];
        $type = empty($params['type'])? 'tour' : $params['type'];

        $model = new Qna();
        $count = $model->getQnasNum($tourCode, $type);
        $list  = $model->getById($tourCode, $type, $page, $pageSize);

        $data['qnasNum'] = $count;
        foreach ($list as $val){
            $arr = array();
            $arr['content'] = $val['content'];
            $arr['dateTime'] = date("Y-m-d h:i:s", $val['datetime']);
            $arr['reply'] = htmlspecialchars_decode($val['admin_content'], ENT_QUOTES);
            $arr['screenName'] = empty($val['screenname']) ? "" : $val['screenname'];

            $data['qnasInfo'][] = $arr;
        }

        return array('data' => $data, 'rs' => '1');
    }
}