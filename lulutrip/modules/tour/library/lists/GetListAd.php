<?php
/**
 * 列表页广告
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */

namespace lulutrip\modules\tour\library\lists;


use yii\base\Component;
use Yii;

class GetListAd extends Component
{
     public static  function getAds()
     {
         $data = ['rightAds' => [], 'firstAds' => []];
          //广告信息
         $result = Yii::$app->helper->curlPost(Yii::$app->params['service']['api'] . '/banner/get-fixed-ads', ['status' => 1]);
         if(empty($result['data'])) return $data;

//         //右侧广告位
//         foreach($navigations as $value) {
//             $temp = "list_right_".strtolower($value['id'])."_tour";
//             if(isset($result['data'][$temp])) {
//                 $data['rightAds'] = $result['data'][$temp];
//                 break;
//             }
//         }

//        //列表页首屏广告
//         foreach($navigations as $value) {
//             $temp = "list_main_".strtolower($value['id'])."_tour";
//             if(isset($result['data'][$temp])) {
//                 $data['firstAds'] = $result['data'][$temp];
//                 break;
//             }
//         }

         if(!empty($result['data'])) {
             foreach ($result['data'] as $key => $value){
                 $links = explode(",", $value['text']);
                 $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                 //把url中的参数refresh、page 过滤掉
                 $pattern = '/((\?|&)refresh=1)|((\?|&)page=\d+)/';
                 $url = preg_replace($pattern, '', $url);

                 //过滤?|&utm by Ivyzhang
                 $url = preg_replace(['/&utm[=_][^&]*(?=&|$)/', '/\?utm[=_][^&]*$/', '/\?utm[=_][^&]*&/'], ['', '', '?'], $url);
//                 foreach ($links as &$link){
//                     if(strpos($link,'north_america') !== false) $link = str_replace('north_america', 'destination', $link);
//                 }
//                 $surl = 'http://'.$_SERVER['HTTP_HOST'].'/tour/destination/region-NA';
//                 if(in_array($surl, \Yii::$app->helper->trimArray($links))){
//                     $key = array_search($surl, \Yii::$app->helper->trimArray($links));
//                     $links[$key] = 'http://'.$_SERVER['HTTP_HOST'].'/tour/destination';
//                 }
//                 if($url == $surl) $url = 'http://'.$_SERVER['HTTP_HOST'].'/tour/destination';
                 if(in_array($url, \Yii::$app->helper->trimArray($links))){
                     if($value['posid'] == -1){
                         $data['firstAds'][] = $value;
                     }elseif ($value['posid'] == -2){
                         $data['rightAds'][] = $value;
                     }
                 }
             }
         }

         return $data;
     }

}