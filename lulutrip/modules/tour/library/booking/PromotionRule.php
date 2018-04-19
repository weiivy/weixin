<?php

namespace lulutrip\modules\tour\library\booking;


use api\library\Help;
use lulutrip\models\sale\Activities;
use yii\base\Component;
use Yii;

/**
 * 优惠验证规则
 * @copyright (c) 2018, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
class PromotionRule
{
    /**
     * @var Promotion
     */
    public $promotion;

    /**
     * @var ShoppingData
     */
    public $shoppingData;

    /**
     * UsePromotion constructor.
     * @param $promotion
     * @param $shoppingData
     */
    public function __construct($promotion, $shoppingData)
    {
        $this->promotion = $promotion;
        $this->shoppingData = $shoppingData;
    }

    /**
     * 根据订单信息过滤优惠信息
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-02-03
     *
     * @return array 返回数据
     */
    public function checkPromotions()
    {
        $result = [];
        foreach($this->promotion as $promotion) {
            if(!$this->_check($promotion)) continue;
            $result[] = $promotion;
        }
        return $result;
    }

    /**
     * 根据条件过滤数据
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-02-03
     * @param $promotion
     * @return bool
     */
    public function _check($promotion)
    {
        // 检查使用平台
        if (!in_array($promotion['activity']['platform'], [Activities::PLATFORM_ALL, Activities::PLATFORM_LUPC])) {
            Yii::info('平台错误' . $promotion['activity']['platform'], __METHOD__);
            return false;
        }

        //长期活动不处理
        if($promotion['activity']['is_all'] == Activities::ISALL_FALSE) {
            // 检查有效日期范围
            if ($promotion['activity']['start_time'] > date('Y-m-d H:i:s')) {
                Yii::info('检查有效日期范围', __METHOD__);
                return false;
            }

            // 检查有效日期范围
            if ($promotion['activity']['end_time'] < date('Y-m-d H:i:s')) {
                Yii::info('检查有效日期范围', __METHOD__);
                return false;
            }
        }


        // 优惠码不能为空
        if ($promotion['activity']['kind'] == Activities::KIND_2 && empty($promotion['activity']['promo_code'])) {
            Yii::info('优惠码不能为空', __METHOD__);
            return false;
        }

        // 检查优惠券数量
        if (!($promotion['num_limit'] == -1 || ($promotion['num_limit'] - $promotion['use_num']) > 0)) {
            Yii::info('检查优惠券数量', __METHOD__);
            return false;
        }

        //检查订单金额
        if(!empty($promotion['money_limit'])) {
            $moneyLimit = is_array($promotion['money_limit']) ? $promotion['money_limit'] : json_decode($promotion['money_limit'], true);

            $moneyLimit['min'] = Help::exchangeCurrency($moneyLimit['min'], $moneyLimit['unit'], $this->shoppingData->currency, 'round2');
            // 检查最小使用金额
            if ($moneyLimit['min'] > 0 && !$this->_checkMinPrice($moneyLimit['min'], $this->shoppingData->totalAmount)) {
                return false;
            }

            $moneyLimit['max'] = Help::exchangeCurrency($moneyLimit['max'], $moneyLimit['unit'], $this->shoppingData->currency, 'round2');
            // 检查最大使用金额
            if (!empty($moneyLimit['max']) && !$this->_checkMaxPrice($moneyLimit['max'], $this->shoppingData->totalAmount)) {
                return false;
            }
        }

        //检查订单人数

        if(!empty($promotion['people_limit'])) {
            $peopleLimit = is_array($promotion['people_limit']) ? $promotion['people_limit'] : json_decode($promotion['people_limit'], true);

            //订单总人数
            $totalPeople = $this->shoppingData->adultCount + $this->shoppingData->childCount;

            // 检查订单人数最小值
            if ($peopleLimit['min'] > 0 && !$this->_checkMinPeople($peopleLimit['min'], $totalPeople)) {
                return false;
            }

            // 检查订单人数最大值
            if ($peopleLimit['max'] > 0 && !$this->_checkMaxPeople($peopleLimit['max'], $totalPeople)) {
                return false;
            }
        }

        if(!empty($promotion['departure_rule'])) {
            // 检查出发日期
            $departureRule = is_array($promotion['departure_rule']) ? $promotion['departure_rule'] : json_decode($promotion['departure_rule'], true);
            if (!$this->_checkDepartureDate($departureRule, $this->shoppingData->sdate)) {
                Yii::info('检查出发日期', __METHOD__);
                return false;
            }
        }
        return true;
    }


    /**
     * 检查最小使用金额
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-02-02
     * @param $minPrice
     * @param $totalAmount
     * @return bool
     */
    private function _checkMinPrice($minPrice, $totalAmount) {
        if ($totalAmount < $minPrice) {
            Yii::info('检查最小使用金额', __METHOD__);
            return false;
        }
        return true;
    }

    /**
     * 检查最大使用金额
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-02-02
     * @param $maxPrice
     * @param $totalAmount
     * @return bool
     */
    private function _checkMaxPrice($maxPrice, $totalAmount) {
        if ($totalAmount > $maxPrice) {
            Yii::info('检查最大使用金额', __METHOD__);
            return false;
        }
        return true;
    }
    /**
     * 检查最小使用人数
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-02-02
     * @param $minPeople
     * @param $totalPeople
     * @return bool
     */
    private function _checkMinPeople($minPeople, $totalPeople)
    {
        if ($totalPeople < $minPeople) {
            Yii::info('检查最少使用人数', __METHOD__);
            return false;
        }
        return true;
    }

    /**
     * 检查最大使用人数
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-02-02
     * @param $maxPeople
     * @param $totalPeople
     * @return bool
     */
    private function _checkMaxPeople($maxPeople, $totalPeople)
    {
        if ($totalPeople > $maxPeople) {
            Yii::info('检查最少使用人数', __METHOD__);
            return false;
        }
        return true;
    }

    /**
     * 检查最大使用金额
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2018-02-02
     * @param $departureRule
     * @param $departureDate
     * @return bool
     */
    private function _checkDepartureDate($departureRule, $departureDate) {
        switch($departureRule['type'])
        {
            case 1: //范围日期
                if (strtotime($departureDate) < strtotime($departureRule['start_time'])) {
                    return false;
                }

                if (strtotime($departureDate) > strtotime($departureRule['end_time'])) {
                    return false;
                }
                break;
            case 2: //枚举日期
                $limitDates = array_filter(explode(',', $departureRule['time']));
                if (count($limitDates) > 0 && !in_array($departureDate, $limitDates)) {
                    return false;
                }
                break;
            case 3: //排除日期
                $limitDates = array_filter(explode(',', $departureRule['time']));
                if (count($limitDates) > 0 && in_array($departureDate, $limitDates)) {
                    return false;
                }
                break;
            case 4: //指定天数之后
                $diff = (strtotime($departureDate) - time()) / 86400;
                if($diff <= $departureRule['days']) {
                    return false;
                }
                break;
        }
        return true;
    }
} 