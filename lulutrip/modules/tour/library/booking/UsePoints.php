<?php

namespace lulutrip\modules\tour\library\booking;

use api\library\Help;
use Yii;

/**
 * Class UsePoints
 * @package lulutrip\library
 * @author Victor Tang<victor.tang@ipptravel.com>
 * @copyright (c) 2017, lulutrip.com
 */
class UsePoints
{
    /**
     * @var integer 用户所有积分
     */
    public $points;

    /**
     * @var ShoppingData 订购数据
     */
    public $shoppingData;

    /**
     * @var string 当前币种
     */
    public $currency;

    /**
     * @var float 100积分换算1美元
     */
    public static $lulupoint_factor = 0.01;

    /**
     * @var int 只能使用100倍数的积分
     */
    public static $lulupoint_step = 100;

    /**
     * @var int 小于10美元时不能使用积分
     */
    public static $lulupoint_exclude = 10;

    /**
     * UsePoints constructor.
     * @param $shoppingData
     */
    public function __construct(ShoppingData $shoppingData)
    {
        $this->points = Yii::$app->user->current_user['lulupoints'];
        $this->shoppingData = $shoppingData;
        $this->currency = Yii::$app->params['curCurrency'];
    }

    /**
     * 获取可用积分
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     * @return array
     */
    public function getAvailablePoints() {
        $availablePoints = 0;

        for ($points = self::$lulupoint_step; $points <= $this->points; $points += self::$lulupoint_step) {
            if (!$this->check($points)) {
                break;
            }

            $availablePoints = $points;
        }

        return $availablePoints;
    }

    /**
     * 检查积分
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     * @param $points
     * @return bool
     */
    public function check($points) {
        if ($points > $this->points) {
            return false;
        }

        if ($points * self::$lulupoint_factor + self::$lulupoint_exclude > Help::exchangeCurrency($this->shoppingData->totalAmount - $this->shoppingData->usePromotion->discountPrice, $this->currency, 'USD', 'floor2')) {
            return false;
        }

        return true;
    }

    /**
     * 使用积分
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-29
     * @param $points
     * @return array
     */
    public function apply($points) {
        $discountPrice = Help::exchangeCurrency($points * self::$lulupoint_factor, 'USD', $this->currency, 'floor2');
        $totalAmount = $this->shoppingData->totalAmount - $discountPrice;

        $this->shoppingData->usePoints = new \lulutrip\modules\tour\library\booking\shoppingData\UsePoints([
            'points' => $points,
            'discountPrice' => $discountPrice
        ]);
        $this->shoppingData->save();

        return $discountPrice;
    }

    /**
     * 取消使用积分
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2017-08-30
     * @param ShoppingData $shoppingData
     */
    public static function cancel(ShoppingData $shoppingData) {
        $shoppingData->usePoints = new \lulutrip\modules\tour\library\booking\shoppingData\UsePoints([
            'points' => 0,
            'discountPrice' => 0
        ]);
        $shoppingData->save();
    }
}