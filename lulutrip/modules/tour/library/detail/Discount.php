<?php

namespace lulutrip\modules\tour\library\detail;


use api\library\Help;
use Curl\Curl;
use lulutrip\models\sale\Activities;
use lulutrip\models\sale\ActivityProductsDiscount;
use yii\base\Component;
use Yii;

/**
 * 折扣信息
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
class Discount extends Component
{
    public  static function getDiscounts($tourCode)
    {
        $curl = new Curl();
        $post = [
            'pid'       => $tourCode,
            'channel'   => Activities::CHANNEL_1,
            'platform'  => Activities::PLATFORM_LUPC
        ];
        $curl->post(Yii::$app->params['service']['api'] . "/saleactivity/get-discounts", $post);
        $data = [];
        if($curl->response->data) {
            foreach($curl->response->data as $discount) {
                $temp = static::formatData($discount, $tourCode);
                $data[] = $temp;
            }
        }
        return $data;
    }


    /**
     * 格式化产品折扣数据
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-12-04
     * @param ActivityProductsDiscount $discount
     * @param $pid
     * @return array 返回数据
     */
    public static function formatData($discount, $pid)
    {
        $discount = is_object($discount) ? $discount : (object)$discount;
        $discount->activity = is_object($discount->activity) ? $discount->activity : (object)$discount->activity;

        //折扣类型 1 折扣  2 减价
        switch($discount->type)
        {
            case ActivityProductsDiscount::TYPE_DISCOUNT:
                $discountAlisa = $discount->discount . "折";
                $title = $discount->activity->title . "  " .$discountAlisa;
                $strengthDis = $discountAlisa . "/";

                break;
            case ActivityProductsDiscount::TYPE_REDUCE:
                $reduce = json_decode($discount->reduce, true);
                $discountAlisa = Yii::$app->params['currencies'][$reduce['unit']]['sign'].$reduce['value'];
                $title = $discount->activity->title . "  立减". $discountAlisa;
                $strengthDis = "立减". $discountAlisa . "/";
                break;
        }
        $data = [
            'id'            => $discount->id,
            'activity_id'   => $discount->activity_id,
            'discount'      => $discount->discount,
            'title'         => $title,
            'validTime'     => ($discount->activity->is_all == Activities::ISALL_TRUE ? "无限期" : "美西时间 " . date("Y-m-d", strtotime($discount->activity->start_time)) . "至" . date("Y-m-d", strtotime($discount->activity->end_time))),
            'endTime'       => date("Y-m-d H:i:s", strtotime($discount->activity->end_time)),
            'strength'      => $strengthDis . ActivityProductsDiscount::discountLimit($discount->discount_limit),
            'instructions'  => "订购产品{$pid}即可参与",
            'is_all'        => $discount->activity->is_all,
            'discountAlisa' => $discountAlisa
        ];

        //参与条件
        $string = '';
        //金额限制
        if(!empty($discount->money_limit)) {
            $moneyLimit = json_decode($discount->money_limit, true);
            $currencyName = isset(Yii::$app->params['currencies'][$moneyLimit['unit']]) ? Yii::$app->params['currencies'][$moneyLimit['unit']]['name'] : $moneyLimit['unit'];
            $string .= '订单总额';
            if($moneyLimit['min']) $string .= "大于等于 {$moneyLimit['min']} {$currencyName}";
            if($moneyLimit['max'] && $moneyLimit['min']) $string .= "且";
            if($moneyLimit['max']) $string .= "小于等于 {$moneyLimit['max']} {$currencyName};";
        }

        //人数限制
        if(!empty($discount->people_limit)) {
            if(!empty($string)) $string .= "<br/>且" ;
            $peopleLimit = json_decode($discount->people_limit, true);
            $string .= '订单总人数';
            if($peopleLimit['min']) $string .= "大于等于 {$peopleLimit['min']} 人";
            if($peopleLimit['max'] && $peopleLimit['min']) $string .= "且";
            if($peopleLimit['max']) $string .= "小于等于 {$peopleLimit['max']} 人;";
        }

        if(!empty($discount->departure_rule)) {
            if(!empty($string)) $string .= "<br/>且" ;
            $departureRule = json_decode($discount->departure_rule, true);
            switch($departureRule['type'])
            {
                case 1:
                    $string .= "订单出发日期在 {$departureRule['start_time']} 至 {$departureRule['end_time']} 期间";
                    break;
                case 2:
                    $time = explode("、", $departureRule['times']);
                    $string .= "订单出发日期为 {$time} ";
                    break;
                case 3:
                    $time = explode("、", $departureRule['times']);
                    $string .= "订单出发日期不为 {$time}";
                    break;
                case 4:
                    $string .= "订单出发日期为 {$departureRule['days']}天 之后";
                    break;
            }
        }
        if(!empty($string)) $data['useLimit'] = $string;

        return $data;
    }


    /**
     * 格式化产品网站活动信息
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-02-11
     * @param $discounts
     * @param $pid
     * @return array 返回数据
     */
    public static function formatListDiscount($discounts, $pid)
    {
        $data = [];
        //分离折后价和非折后价活动
        $activity = $afterDiscounts = $reduceDiscounts = [];

        foreach($discounts as $discount) {
            if($discount['is_discount'] == ActivityProductsDiscount::IS_DISCOUNT_TRUE) {
                $afterDiscounts[$discount['activity']['id']][] = $discount;
            } elseif($discount['is_discount'] == ActivityProductsDiscount::IS_DISCOUNT_FALSE) {
                $reduceDiscounts[$discount['activity']['id']][] = $discount;
            }
            $activity[$discount['activity']['id']] = $discount['activity'];
        }

        //列折扣类活动 > 满减类活动
        $typeReduceSort = $typeDiscountSort = $afterDiscountSort = $afterTypeDiscount = $typeDiscount = $typeReduce = [];
        foreach($afterDiscounts as $key => $afterDiscount) {
            $sortArr = [];
            foreach($afterDiscount as $value) {
                if($value['type'] == ActivityProductsDiscount::TYPE_DISCOUNT) {
                    $temp = static::formatData($value, $pid);
                    $afterTypeDiscount[$key][$value['id']] = $temp;
                    $sortArr[$value['id']] = $value['discount'];
                }
            }
            asort($sortArr);
            foreach($sortArr as $id => $value) {
                $data['afterDiscount'][$key]['discounts'] = $afterTypeDiscount[$key];
                if(!isset($data['afterDiscount'][$key]['activity'])) {
                    $data['afterDiscount'][$key]['activity'] = [
                        'title' => $activity[$key]['title'] . (count($sortArr) > 1 ? ' 最高' : ' ') . $afterTypeDiscount[$key][$id]['discountAlisa'],
                        'time'  => $afterTypeDiscount[$key][$id]['validTime'],
                        'endTime'   => $afterTypeDiscount[$key][$id]['endTime']
                    ];
                    $afterDiscountSort[$key] = $afterTypeDiscount[$key][$id]['discount'];
                }
            }

        }

        //处理折后价
        foreach($reduceDiscounts as $key => $reduceDiscount) {
            $sortDiscountArr = $sortReduceArr = [];
            foreach($reduceDiscount as $value) {
                if($value['type'] == ActivityProductsDiscount::TYPE_DISCOUNT) {
                    $temp = static::formatData($value, $pid);
                    $typeDiscount[$key][$temp['id']] = $temp;
                    $sortDiscountArr[$temp['id']] = $value['discount'];
                } elseif($value['type'] == ActivityProductsDiscount::TYPE_REDUCE) {
                    $reduce = json_decode($value['reduce'], true);
                    $temp = static::formatData($value, $pid);
                    $temp['reducePrice'] = $sortReduceArr[$temp['id']] = Help::exchangeCurrency($reduce['value'], $reduce['unit'], 'USD','ceil');
                    $typeReduce[$key][$temp['id']] = $temp;
                }
            }

            asort($sortDiscountArr);
            arsort($sortReduceArr);

            //折后价
            foreach($sortDiscountArr as $id => $value) {
                $data['typeDiscount'][$key]['discounts'] = $typeDiscount[$key];
                if(!isset($data['typeDiscount'][$key]['activity'])) {
                    $data['typeDiscount'][$key]['activity'] = [
                        'title' => $activity[$key]['title'] . (count($sortDiscountArr) > 1 ? ' 最高' : ' ') . $typeDiscount[$key][$id]['discountAlisa'],
                        'time'  => $typeDiscount[$key][$id]['validTime'],
                        'endTime'   => $typeDiscount[$key][$id]['endTime']
                    ];
                    $typeDiscountSort[$key] = $typeDiscount[$key][$id]['discount'];
                }
            }


            //满减
            foreach($sortReduceArr as $id => $value) {
                $data['typeReduce'][$key]['discounts'] = $typeReduce[$key];
                if(!isset($data['typeReduce'][$key]['activity'])) {
                    $data['typeReduce'][$key]['activity'] = [
                        'title' => $activity[$key]['title'] . (count($sortReduceArr) > 1 ? ' 最高' : ' ') . $typeReduce[$key][$id]['discountAlisa'],
                        'time'  => $typeReduce[$key][$id]['validTime'],
                        'endTime'   => $typeReduce[$key][$id]['endTime']
                    ];
                    $typeReduceSort[$key] = $typeReduce[$key][$id]['reducePrice'];

                }
            }
        }

        //最高优惠力度排列 力度高 > 力度低
        asort($afterDiscountSort);
        asort($typeDiscountSort);
        arsort($typeReduceSort);
        $oldData = $data;
        $data = [];
        foreach($afterDiscountSort as $id => $value) {
            $data['afterDiscount'][$id] = $oldData['afterDiscount'][$id];
        }

        foreach($typeDiscountSort as $id => $value) {
            $data['typeDiscount'][$id] = $oldData['typeDiscount'][$id];
        }

        foreach($typeReduceSort as $id => $value) {
            $data['typeReduce'][$id] = $oldData['typeReduce'][$id];
        }

        return $data;
    }
} 