<?php
/**
 * 旅行团列表页actions
 * @copyright (c) 2017, lulutrip.com
 * @author  Serena Liu<serena.liu@ipptravel.com>
 */
namespace lulutrip\modules\tour\actions\tourlist;

use lulutrip\library\common\LogRecord;
use lulutrip\models\sale\Activities;
use lulutrip\models\sale\ActivityProductsDiscount;
use lulutrip\modules\tour\library\detail\Discount;
use lulutrip\modules\tour\library\lists\DealMenus;
use lulutrip\modules\tour\library\lists\DealRight;
use lulutrip\modules\tour\library\lists\GetListAd;
use lulutrip\modules\tour\library\lists\GetParams;
use lulutrip\modules\tour\library\lists\GetRequestData;
use lulutrip\modules\tour\library\lists\GetTdk;
use lulutrip\modules\tour\library\lists\GetPage;
use yii\base\Action;
use Yii;

class Lists extends Action {
    private $_params = [];
    public $_reParam = array(
//        'region' => 'region',
        'cat' => 'subType',
        'd' => 'days',
        'st' => 'countries',
        'c' => 'cities',
        's' => 'scenes',
        'f' => 'features',
//        'l' => 'lines', 暂不做
      'ns' => 'noscenes',
    );
    public $productIds;
    public $urlParm;
    public $_auroraScores;

    public function run() {
        $firstTime = Yii::$app->helper->getMicroTime();//当前使用时间
        $firstMem  = memory_get_usage();//当前内存

        $this->urlParm = Yii::$app->params['service']['www'];
        //极光分数
        $return = Yii::$app->helper->curlPost(\Yii::$app->params['service']['api'] . "/setting/get-score", ['type' => 1]);
        if(!empty($return['data'])){
            foreach ($return['data'] as $value){
                $this->_auroraScores[$value['tourcode']] = $value['score'];
            }
        }
        $_GET['params'] = $temp = rtrim($_GET['params'], '/');
        $_GET['params'] = preg_replace('/region.*?_st-/', 'region-' ,$_GET['params']);
        $_GET = GetParams::parseUrl(trim($_GET['params'], '/'), $this->_reParam);
        $data['params'] = $this->_params = GetParams::getParams();
        $dealMenus = new DealMenus();

        //st的301跳转处理
        $this->stRedirect($temp);

        //组合请求data json
        $getRequestData = new GetRequestData();
        $jsonData = $getRequestData->getRequestData($this->_params);

        //获取榜单数据
        //把url中的参数refresh、page、isshowline 、utm过滤掉
        $pattern = ['/((\?|&)refresh=1)|((\?|&)page=\d+)|((\?|&)isshowline=(-)?1)/', '/&utm[=_][^&]*(?=&|$)/', '/\?utm[=_][^&]*$/', '/\?utm[=_][^&]*&/'];
        $requestUri = preg_replace($pattern, ['', '', '', '?'], $_SERVER['REQUEST_URI']);

        //把url中的参数#keyword过滤掉
        $requestUri = urldecode($requestUri);
        $requestUri = preg_replace('/(\#)keyword=[a-zA-Z0-9\x{4e00}-\x{9fa5}]+/u','',$requestUri);
        $jsonData['requestUrl'] = $this->urlParm . $requestUri;
        $url = Yii::$app->params['service']['tourapi'] . '/search/lulutrip/list';

        $secondTime = Yii::$app->helper->getMicroTime();//当前使用时间
        $secondMem  = memory_get_usage();//当前内存
        $result = Yii::$app->helper->curlJson($url, $jsonData);

        $threeTime = Yii::$app->helper->getMicroTime();//当前使用时间
        $threeMem  = memory_get_usage();//当前内存

        Yii::info('API-POST: ' . $url . '===' . json_encode($jsonData) . '===' . json_encode($result), __METHOD__);

        if(empty($result) || empty($result['data']['facetFields'])){
            $data['products'] = array();
            $data['menus']['sub_type']['facetItems'][0] = array('url'=>'', 'displayName' => 0, 'count' => 0);
            $data['regionRoot'] = 'NA'; //可能有问题
            $data['tabId'] = '';
        }else{
            $dealMenus->regionRoot = $regionRoot = $result['data']['navigations'][0]['id'];
            //阿联酋相关的产品是由欧洲团队负责的,顶部导航应该为欧洲旅游
            if($regionRoot == 'Asia' && $result['data']['navigations'][1]['id'] == 'ARE') $regionRoot = 'EU';
            Yii::$app->controller->regionRoot = $data['regionRoot'] =  in_array($regionRoot, ['AU', 'EU']) ? $regionRoot : 'NA';

            //如果page 数据不存在 跳到第一页
            if(empty($result['data']['products']) && $this->_params['page'] > 1) {
                $tPrms = $this->_params;
                $tPrms['page'] = 1;
                $url301 = $dealMenus->mergeUrl($tPrms);
                header("Location: $url301", true, 301);
                exit;
            }

            $data['menus'] = $dealMenus->dealMenus($result['data']['facetFields'], $this->_params, $this->_reParam);
            $data['menus']['dealMenusObj'] = $dealMenus;

            //清除选项
            $tPrms = array('region' => $regionRoot);
            isset($this->_params['id']) && $tPrms['id'] = $this->_params['id'];
            isset($this->_params['keyword']) && $tPrms['keyword'] = $this->_params['keyword'];
            isset($this->_params['service']) && $tPrms['service'] = $this->_params['service'];
            $data['menus']['clearAll'] = $dealMenus->mergeUrl($tPrms);
            $tPrms = $this->_params;
            if(isset($tPrms['orderby'])) $tPrms['order'] = $tPrms['orderby'] = '';
            $data['menus']['orderUrl'] = $data['menus']['defaultSortUrl'] = $dealMenus->mergeUrl($tPrms);
            $data['menus']['orderUrl'] .= preg_match('/\?/', $data['menus']['orderUrl']) ? "&" : "?";

            //榜单
            $tourCodes = isset($result['data']['topProductCodes']) ? $result['data']['topProductCodes'] : array();
	        $data['bangData'] = $tourCodes;
            $data['products'] = $this->defineProducts($result['data']['products'], $tourCodes);

            //分页
            $tPrms = $this->_params;
            $tPrms['page'] = '{{page}}';
            $pageLink = $dealMenus->mergeUrl($tPrms);
            $page = new GetPage($this->_params['page'], 20, $result['data']['total'], $pageLink);
            if($result['data']['total'] > 20) $data['page'] =  array('bottom' => $page->getPageDots());

            //面包屑
            $sceneIds = isset($jsonData['includeScenic']) ? $jsonData['includeScenic'] : [];
            $data['breadData'] = $this->setBreadData($result['data']['navigations'], $regionRoot, $sceneIds);

            //tdk
            $temp = (new GetTdk())->getListTdk($this->_params, isset($result['data']['tdkResult']) ? $result['data']['tdkResult'] : [], $result['data']['navigations']);
            list(Yii::$app->controller->pageTitle, Yii::$app->controller->pageKeywords, Yii::$app->controller->pageDesc) = [$temp['title'], $temp['keywords'], $temp['description']];

            //广告
            $ads = GetListAd::getAds($result['data']['navigations']);
            $data['rightAds'] = !empty($ads['rightAds']) ? $ads['rightAds'] : [];
            $data['firstAds'] = !empty($ads['firstAds']) ? $ads['firstAds'] : [];

            //id情况下tab 显示
            if(isset($result['data']['tdkResult']['poi'])) $data['tabId'] = trim($result['data']['tdkResult']['poi']['displayName']);

            //GA产品ID
            $this->productIds = empty($data['products']) ? [] : array_column($data['products'], 'id');


            $dealRight = new DealRight($this->_params, $result['data']['navigations']);
            //热门攻略
            $data['recPlayLists'] = $dealRight->getRecPlayList();

            //轻攻略
            $data['lightRaiders'] = $dealRight->getLightRaiders();

            //人气筛选参数
            $data['hotDestination'] = $this->getTopParams($jsonData, $result['data']['navigations']);


        }
        //menusOthers
        $data['menus']['others'] = $dealMenus->setOtherMenuUrl($this->_params);
        LogRecord::recordDebugInfo($firstTime, $secondTime, $threeTime, $firstMem, $secondMem, $threeMem, __METHOD__);

        return $this->controller->render("entry", $data);
    }
    /**
     * 列表页产品
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-08-01
     * @param $data
     * @param $tourcodes 推荐产品
     */
    private function defineProducts($data, $tourcodes) {
        foreach ($data as $key => $var) {
            //是否推荐
            $data[$key]['is_tui'] = 0;
            if (array_search($var['productKey'], $tourcodes) !== false)
                $data[$key]['is_tui'] = 1;
            //出发地
            $startcity = empty($var['startLocation']) ? [] : array_column($var['startLocation'], 'displayName');
            $data[$key]['startCity'] = implode('/', $startcity);

            //离团地
            $endCity = empty($var['endLocation']) ? [] : array_column($var['endLocation'], 'displayName');
            $data[$key]['endCity'] = implode('/', $endCity);
            $data[$key]['link'] = '/tour/view/tourcode-' . $var['productKey'];
            $tagIcon = $tagSale = $tagFeature = $tagService = $tagOther = array();
            if(isset($var['tags'])){
                foreach ($var['tags'] as $tag) {
                    if (empty($tag['nameCN'])) continue;

                    //是否在列表页显示
                    if(!in_array($tag['display'], [4, 8, 9])) continue;
                    //含有图片的标签，不包含附加服务类
                    if (!empty($tag['icon']) && ($tag['filterType'] !== 'F_SERVICE')) {
                        $tagIcon[] = $tag;
                        continue;
                    }
                    /*if ($tag['type'] == 'SALE' && $tag['filterType'] !== 'F_SERVICE') {
                        $tagSale[] = $tag;
                        continue;
                    }
                    if ($tag['type'] == 'FEATURE' && $tag['filterType'] !== 'F_SERVICE') {
                        $tagFeature[] = $tag;
                        continue;
                    }*/

                    if ($tag['filterType'] == 'F_SALE') {
                        $tagSale[] = $tag;
                        continue;
                    }
                    if ($tag['filterType'] == 'F_FEATURE') {
                        $tagFeature[] = $tag;
                        continue;
                    }

                    //只显示订即确认
                    if ($tag['filterType'] == 'F_SERVICE') {
                        if($tag['nameCN'] != '订即确认') continue;
                        $tagService[] = $tag;
                    }
                }
               /* $_tagService = array();
                foreach ($tagService as $ts) {
                    $_tagService['count'] = isset($_tagService['count']) ? $_tagService['count'] : 0;
                    $_tagService['content'] = isset($_tagService['content']) ? $_tagService['content'] : '';
                    $_tagService['count'] ++;
                    $_tagService['content'] .= "<a class='J_service'>";
                    if (!empty($ts['icon'])) $_tagService['content'] .= "<div class='icon'><img src='" . Yii::$app->helper->getImgDomain() . '/' . $ts['icon'] . "'></div>";
                    $_tagService['content'] .= "<div class='tit'><strong>" . $ts['nameCN'] . "</strong></div>
                                                    <div class='text'>" . $ts['descCN'] . "</div></a>";
                }*/

                $data[$key]['tags'] = array('tagIcon' => $tagIcon, 'tagSale' => $tagSale, 'tagFeature' => $tagFeature, 'tagService' => $tagService);
            }
            if ($var['currency'] == 'CNY') $data[$key]['currency'] = 'RMB';
            //极光分数
            if(!empty($this->_auroraScores) && array_key_exists($var['productKey'], $this->_auroraScores)) $data[$key]['auroraScore'] = $this->_auroraScores[$var['productKey']];

            //发团日处理
           $data[$key]['tourDate'] = $this->formatTourDate($var['tourDate']);

            if(!empty($var['discountActivity'])) {
                if(!empty($var['discountActivity']['maxDiscount'])) $data[$key]['discountActivity'] = $this->formatData($var['discountActivity']['maxDiscount']);
                if(!empty($var['discountActivity']['discounts'])){
                    $discounts = json_decode($var['discountActivity']['discounts'], true);
                    $data[$key]['activityTags'] = Discount::formatListDiscount($discounts, $var['id']);
                }
//               if($data[$key]['activityTags']) var_dump($data[$key]['activityTags']['afterDiscount'][108]);die;
            }

        }
        return $data;
    }

    /**
     * 面包屑
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-08-03
     * @param $navigations
     * @param $region
     * @param $sceneIds
     * @return array 返回数据
     */
    private function setBreadData($navigations, $region, $sceneIds)
    {
        $params = $this->_params;
        $data = [['name' => '首页', 'url' => '/']];

        if(empty($navigations)){
            if(isset($params['keyword']) && !empty($params['keyword'])) {
                $data[] = ['name' => '搜索结果', 'url' => '#'];
                $data[] = ['name' => $params['keyword'], 'url' => ''];
            }
            return $data;
        }

        $www = $this->urlParm;
        $curUrl = $www . '/tour';
        if(!empty($params['keyword'])) {
            $curUrl = $www . '/search/tour';
        } elseif(isset($params['id'])) {

            $curUrl .= '/destination/';
        } else {
            if($region == 'NA') {
                $curUrl .= '/north_america/';
            } else {
                $curUrl .= '/destination/';
            }
        }

        $scenes = [];
        //优化非洲列表页的面包屑层级 上一级就是首页
        $navigationIds = array_column($navigations, 'id');
        foreach($navigations as $key => $value) {
            if(in_array('AF', $navigationIds) && $key == 0) continue;
            $name = $value['displayName'] . "旅游";
            if(!in_array($value['id'], $sceneIds)) {
                $data[] = [
                    'name' => $name,
                    'url'  => $curUrl . 'region-'. $value['id']

                ];
            } else {
                $scenes[] =  $value['displayName'];
            }
        }

        if(!empty($scenes)) {
            $data[] = [
                'name' => implode('、', $scenes) . "旅游",
                'url'  => ''
            ];
        }
        return $data;
    }

    /**
     * 格式化发团日
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-08-04
     * @param $tourDate
     * @return string
     */
    private function formatTourDate($tourDate)
    {
        $data = '';
        if(empty($tourDate)) return $data;
        $tourDate = json_decode($tourDate, true);
        $days = $newdays    =  array();
        $week               = ['周日' => 0, '周一' => 1, '周二' => 2, '周三' => 3, '周四' => 4, '周五' => 5, '周六' => 6];
        if (isset($tourDate['week']) && is_array($tourDate['week'])) {
            foreach($tourDate['week'] as $value){
                $days = array_unique(array_merge($days, explode(";",$value['day'])));
            }
        }

        foreach($days as $v){
            if($v == '每日发团') {
                $newdays[0] = '每日发团';
                break;
            }

            $newdays[$week[$v]] = $v;
        }

        ksort($newdays);
        $temDays = $newdays;
        if(count($newdays) == 7){
            $data = '每日发团';
        } else if(is_array($newdays) && count($newdays) == 1 && array_shift($temDays) == '每日发团') {
            $data = '每日发团';
        } else{
            $data = implode(";",$newdays);
        }

        return empty($data) ? '固定发团日' : $data;
    }

    /**
     * st的301跳转处理
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-08-08
     * @param $data
     */
    private function stRedirect($data)
    {
        $dealMenus = new DealMenus();
        if(preg_match('/\_st\-/', $data)) {
            $dealMenus->regionRoot = $this->_params['regionArr'][0];
            $url301 = $dealMenus->mergeUrl($this->_params);
            header("Location: $url301", true, 301);
            exit;
        }

        //d-12跳转
        $params = GetParams::parseUrl($data, $this->_reParam);
        if(isset($params['days']) && $params['days'] > 10) {
            $dealMenus->_reParam = $this->_reParam;
            $days = $params['days'] == 100 ? [10] : str_split($params['days']);
            $tmp = $this->_params;
            $tmp['days'] = implode('|', $days);
            $tmp['daysArr'] = $days;
            $url301 = $dealMenus->mergeUrl($tmp);
            header("Location: $url301", true, 301);
            exit;
        }

    }

    /**
     * 重新组装人气推荐参数
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-08-24
     * @param $params
     * @param $navigations
     * @return array 返回数据
     */
    private function getTopParams($params, $navigations)
    {
        $areaList = isset($params['tripLine']) ? $params['tripLine'] : [];
        $scenicList = isset($params['includeScenic']) ? $params['includeScenic'] : [];
        $continent = (isset($navigations[0]['id']) && in_array($navigations[0]['id'], ['NA', 'AU', 'EU'])) ? $navigations[0]['id'] : 'NA';

        //区分大洲和区域或国家
        foreach(['NA', 'AU', 'EU'] as $val) {
            if(in_array($val, $areaList)) {
                $areaList = array_flip($areaList);
                unset($areaList[$val]);
                $areaList = array_flip($areaList);
                $continent = $val;
            }
        }

        $currency = Yii::$app->params['curCurrency'] != 'RMB' ? Yii::$app->params['curCurrency'] : 'CNY';
        $params = ['categories' => $params['categories'], 'continent' => $continent, 'areaList' => array_values($areaList), 'scenicList' => $scenicList, 'currency' => $currency];
        $apiUrl = Yii::$app->params['service']['tourapi'] . "/search/lulutrip/top";
        $result = Yii::$app->helper->curlJson($apiUrl, $params);
        Yii::info('API-POST: ' . $apiUrl . '===' . json_encode($params) . '===' . json_encode($result), __METHOD__);

        $data = empty($result['data']) ? [] : $result['data'];
        foreach($data['products'] as $key => $value) {
            $data['products'] [$key]['link'] = Yii::$app->params['service']['www'] . "/tour/view/tourcode-" . $value['id'] . "#list_top5";
            $data['products'] [$key]['sign'] = Yii::$app->params['curCurrencies']['sign'];

            //向上取整
            $data['products'] [$key]['price'] = ceil($value['price']);
            $data['products'] [$key]['marketPrice'] = ceil($value['marketPrice']);
        }

        return $data;
    }

    /**
     * 格式化产品折扣数据
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-12-08
     * @param ActivityProductsDiscount $discount
     * @return array 返回数据
     */
    private static  function formatData($discount)
    {
        return [
            'title'         => $discount['title'] . "  " .$discount['discount'] . "折",
            'description'   => "美西时间 " . ($discount['isAll'] == Activities::ISALL_TRUE ? "长期" : date("Y-m-d", strtotime($discount['startTime'])) . "至" . date("Y-m-d", strtotime($discount['endTime']))) . ",订购本产品享受" . $discount['discount'] . "折/" . ActivityProductsDiscount::discountLimit($discount['discountLimit']),
        ];
    }

}
