<?php

namespace lulutrip\modules\tour\controllers;

use api\library\Help;
use Curl\Curl;
use api\library\product\Comment;
use api\library\product\Qna;
use lulutrip\library\common\LogRecord;
use lulutrip\models\sale\Activities;
use lulutrip\modules\tour\library\detail\Discount;
use lulutrip\modules\tour\library\detail\GetItinerary;
use Yii;

/**
 * Class DetailController
 * @package lulutrip\modules\tour\controllers
 * @author Victor Tang<victor.tang@ipptravel.com>
 * @copyright (c) 2017, lulutrip.com
 */
class DetailController extends BaseController {
    /**
     * @var 用于trackCode
     */
    public $trackCode;

    /**
     * @var 折后价显示标示
     */
    public $discounAfterPirce;

    /**
     * 获取秒杀折扣
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-15
     * @param $tourCode integer 团号
     * @return float|int
     */
    protected function getOffPercent($tourCode) {
        $curl = new Curl();
        $offPercent = 1;

        //团购
        $curl->get(Yii::$app->params['service']['api'] . "/tour/group-buying/". $tourCode);
        if(!empty($curl->response->data)){
            $offPercent = $curl->response->data->off_percent / 10;
        }

        if($offPercent == 1) {
            //折后价
            $post = [
                'pid'       => $tourCode,
                'channel'   => Activities::CHANNEL_1,
                'platform'  => Activities::PLATFORM_LUPC
            ];
            $curl->post(Yii::$app->params['service']['api'] . "/saleactivity/get-max-discount", $post);
            if(!empty($curl->response->data)){
                $offPercent = $curl->response->data->discount / 10;
                $this->discounAfterPirce = 1;
            }
        }

        return $offPercent;

    }

    /**
     * 面包屑
     * @author Xiaopei Dou<xiaopei.dou@ipptravel.com>
     * @copyright 2018-01-18
     * @param $navigations
     * @return array 返回数据
     */
    private function setBreadData($navigations){
        if(empty($navigations)) return [];
        $domain = Yii::$app->params['service']['www'];
        $data = [['name' => '首页', 'url' => '/']];
        $count = count($navigations);
        foreach($navigations as $key => $value) {
            $temp = [];
            if($key+1 < $count){
                $temp['name'] = $value['cnName'] . "旅游";
                $temp['url'] = $domain . '/tour/destination/region-' . $value['luluCode'];
            }else{
                $temp['name'] = $value['cnName'] . "出发";
                $temp['url'] = $count < 2 ? '' : $domain . '/tour/destination/region-' . $navigations[$count-2]['luluCode'] . '_c-' . $value['luluCode'];
            }
            $data[] = $temp;
        }

        return $data;
    }

    /**
     * 旅行团详情页
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-14
     * @param $tourCode integer 团号
     * @return string
     */
    public function actionView($tourCode) {
        $firstTime = Yii::$app->helper->getMicroTime();//当前使用时间
        $firstMem  = memory_get_usage();//当前内存

        $currency = Yii::$app->params['curCurrencies']['code'];

        $curl = new Curl();
        $curl->setHeader('currency', $currency);
        $url = Yii::$app->params['service']['tourapi'] . "/gtravel/lulu/product/{$tourCode}";

        $secondTime = Yii::$app->helper->getMicroTime();//当前使用时间
        $secondMem  = memory_get_usage();//当前内存

        $curl->get($url);
        Yii::info('API-GET: ' . $url . '===HEAD: ' . json_encode(['currency' => $currency]) . '===' . json_encode($curl->response), __METHOD__);
        $tourData = json_decode(json_encode($curl->response), true);

        $threeTime = Yii::$app->helper->getMicroTime();//当前使用时间
        $threeMem  = memory_get_usage();//当前内存

        if($tourData['rs'] == 0){
            if(!isset($_SERVER['HTTP_ISNEW'])){
                return $this->redirect(Yii::$app->params['service']['www'] . '/old/tour/view/tourcode-' . $tourCode);
            }else{
                Yii::$app->helper->set404();
            }
        }

//        if ($tourData['data']['state'] == 2) {
//            http_response_code(404);
//            echo '产品已下架';
//            exit();
//        }

        if(!empty($tourData['data']['navigations'][0])) $region = $tourData['data']['navigations'][0];
        //非洲的产品详情所在的导航定位在欧洲
        if((!empty($tourData['data']['navigations'][1]) && $tourData['data']['navigations'][1]['luluCode'] == 'ARE') || (!empty($region['luluCode']) && $region['luluCode'] == 'AF')){
            $this->regionRoot = 'EU';
        }elseif(!empty($region['luluCode'])){
            $this->regionRoot = $region['luluCode'];
        }else{
            $this->regionRoot = 'NA'; 
        }

        // TKD
        $this->pageTitle = $tourData['data']['translation']['seoInfo']['stitle'];
        $this->pageKeywords = implode(',', explode(' ', $tourData['data']['translation']['seoInfo']['skeywords']));
        $this->pageDesc = $tourData['data']['translation']['seoInfo']['sdesc'];

        $comment = new Comment;
        $commentCount = $comment->getCommsNum($tourCode, 'tour', 'PC');

        $Qna = new Qna();
        $questionCount = $Qna->getQnasNum($tourCode, 'tour');

        //判断该产品在包团定制库中是否存在对应产品
        $domain = Yii::$app->params['service']['www'];
        $row = Yii::$app->db->createCommand("SELECT packid from packagetours WHERE `tourcode` = " . $tourCode . " and p_active = 'Y'")->queryOne();
        if(!empty($row['packid'])){
            $customLink = $domain . '/privatetour/view-' . $row['packid'];
        }else{
            $customLink = $domain . '/private/tour_book/type-tour';
        }
        if($this->regionRoot == 'NA'){
            $wechatLink = Yii::$app->helper->getFileUrl('/images/private_trips/ptCode_weixin_NA.jpg');
        }elseif ($this->regionRoot == 'EU'){
            $wechatLink = Yii::$app->helper->getFileUrl('/images/private_trips/euCode.jpg');
        }else{
            $wechatLink = Yii::$app->helper->getFileUrl('/images/private_trips/ptCode_weixin_AU.png');
        }

        $offPercent = $this->getOffPercent($tourCode);

        //组装trackcode记录数据
        $navigations = array_column($tourData['data']['navigations'], 'code', 'enName');
        $this->trackCode = [
            'productId' => $tourCode,
            'cityCode' => $navigations[$tourData['data']['basic']['startLocation'][0]['enName']],
            'photo' => empty($tourData['data']['photos'][0]['photo']) ? '' : $tourData['data']['photos'][0]['photo'],
            'url' => Yii::$app->params['service']['www'] . '/tour/view/tourcode-'. $tourCode,
            'price' =>  $tourData['data']['startPrice'],
            'offPercent' => $offPercent,
            'priceRMB'   => $offPercent < 1 ? Help::exchangeCurrency(ceil($tourData['data']['startPrice'] *$offPercent), $tourData['data']['currency'], 'RMB') : Help::exchangeCurrency($tourData['data']['startPrice'], $tourData['data']['currency'], 'RMB')
        ];

        //获取静态配置数据
        $url = Yii::$app->params['service']['api'] . '/get-static-nav';
        $staticNav = Yii::$app->helper->curlGet($url);

        //结伴期小于1天及已过期的结伴不会出现 by Ivyzhang 17.10.10
        $time = date("Y-m-d", strtotime('+1 days', time()));
        //行程部分支持展示景点链接 by Ivyzhang 17.10.10
        $tourData['data']['itinerarys'] = (new GetItinerary())->dealIti($tourData['data']['itinerarys'], $tourCode);
        //自选项目套餐类型id
        if(!empty($tourData['data']['activityGroups'])) $tourData['data']['optionalItemSubType'] = array_column($tourData['data']['activityGroups'], 'subType');

        $data = [
            'currency' => Yii::$app->params['curCurrencies']['sign'],
            'offPercent' => $offPercent,
            'tourCode' => $tourCode,
            'tourData' => $tourData['data'],
            'commentCount' => $commentCount,
            'questionCount' => $questionCount,
            'luluTopicCount' => Yii::$app->db->createCommand('select * from c_topics where tourcode = :tourcode and is_finished = 0 and is_deleted = 0', [':tourcode' => $tourCode])->query()->count(),
            'luluPartner' => Yii::$app->db->createCommand("select c_topics.id as topicId, memberid, screenname, avatar, i_am, subject, content, date(FROM_UNIXTIME(created_at)) as postDate from c_topics left join members using (memberid) where tourcode = :tourcode and is_finished = 0 and is_deleted = 0 and start_date > '$time' order by id desc limit 3", [':tourcode' => $tourCode])->queryAll(),
            'customLink' => $customLink,
            'wechatLink' => $wechatLink,
            'phones'     => $staticNav['data']['IpPhone'],
            'discountInfo' => Discount::getDiscounts($tourCode)
        ];
        //面包屑
        $data['breadData'] = $this->setBreadData($tourData['data']['navigations']);

        LogRecord::recordDebugInfo($firstTime, $secondTime, $threeTime, $firstMem, $secondMem, $threeMem, __METHOD__);

        return $this->render('index.html', $data);
    }


}