<?php
/**
 * 标准化包团详情页action
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\actions\packagetour;

use linslin\yii2\curl\Curl;
use lulutrip\components\Helper;
use lulutrip\library\recording\Record;
use yii\base\Action;

class View extends Action
{
    public $productIds;
    public $packagetour;

    public function run()
    {
        $packId = \Yii::$app->request->get('packid');
        $this->productIds = $packId + 800000;

        Helper::setSeo('channel', 'home');

        $data['themesData'] = \Yii::$app->controller->_themeData;

        //获取数据
        $curl = new Curl();

        //包团详情
        $result = $curl->get(\Yii::$app->params['service']['api'] . "/package-tour/detail/" . $packId);
        $return = json_decode($curl->response, true);
        $data['packagetour'] = $this->packagetour = $return['data'];
        //获取大区域
        $states = \Yii::$app->helper->getRegRootBySceneId($data['packagetour']['pack_sceneid']);
        $this->controller->regionRoot = $states;
        $this->controller->callmenowRegion = $states;
        //获取大区域 end
        $data['packagetour']['FirstDay'] = date('Y-m-d',time()+3600*24*$data['packagetour']['leadtime']);
        $data['packagetour']['pcode'] = 800000 + $data['packagetour']['packid'];
        $data['packagetour']['operatornotes_cn'] = str_replace('订购须知','&lt;a name=&quot;note&quot;&gt;&lt;/a&gt;订购须知',$data['packagetour']['operatornotes_cn']);

        //包团行程单
        $result = $curl->get(\Yii::$app->params['service']['api'] . "/package-tour/itin/" . $packId);
        $return = json_decode($curl->response, true);
        $data['itineraries'] = $return['data'];

        //评价
        $result = $curl->get(\Yii::$app->params['service']['api'] . "/package-tour/comment/" . $packId . "/1/4" );
        $return = json_decode($curl->response, true);
        $data['commsNum'] = $return['data']['count'];

        //推荐旅行团产品
        $curl->get(\Yii::$app->params['service']['api'] . "/package-tour/recommend/" . $data['packagetour']['tourcode']);
        $return              = json_decode($curl->response, true);
        $data['recProducts'] = $return['data'] ? $return['data'] : [];

        //根据产品重新设置
        \Yii::$app->controller->pageTitle = $data['packagetour']['packmaintitle_cn'] . ',出境游线路攻略,华人旅行社_路路行旅游网 lulutrip.com';

        //历浏览记录相关
        $record = new Record;
        if(\Yii::$app->user->isGuest === false) {
            $record->writeDataForMdc(\Yii::$app->user->toArray, $data['packagetour']['pcode']);
        } else {
            Record::writeHistoryData($data['packagetour']['pcode']);
            $record->writeDataForMdc([], $data['packagetour']['pcode']);
        }

        //判断是否显示返回旅行团 来源旅行团可以访问就正常显示
        $curl->get(\Yii::$app->params['service']['tourapi'] . "/gtravel/lulu/product/{$data['packagetour']['tourcode']}/pinfo");
        $return              = json_decode($curl->response, true);
        if ($return['rs'] == 1) {
            $data['tourCode'] = $data['packagetour']['tourcode'];
        }

        return $this->controller->render('@lulutrip/views/package-tour/view', $data);
    }

}