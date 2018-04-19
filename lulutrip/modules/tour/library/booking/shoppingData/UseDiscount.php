<?php

namespace lulutrip\modules\tour\library\booking\shoppingData;

/**
 * Class UseDiscount 折后价
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
class UseDiscount {
    /**
     * @var int 折后价记录Id
     */
    public $id;

    /**
     * @var int 折后价记录关联活动Id
     */
    public $activity_id;

    /**
     * @var int 折扣金额
     */
    public $discountPrice;

    /**
     * @var string 折扣标题
     */
    public $title;

    /**
     * @var int 活动种类 1 网站活动  2 市场活动 3 秒杀活
     */
    public $kind;

    /**
     * @var int 是否使用折后价
     */
    public $isDiscount;

    /**
     * @var string 优惠码
     */
    public $promoCode;

    /**
     * UsePromotion constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->id = isset($data['id']) ? $data['id'] : 0;
        $this->activity_id = isset($data['activity_id']) ? $data['activity_id'] : 0;
        $this->discountPrice = isset($data['discountPrice']) ? $data['discountPrice'] : 0;
        $this->title = isset($data['title']) ? $data['title'] : null;
        $this->promoCode = (isset($data['promoCode']) && !empty($data['promoCode'])) ? $data['promoCode'] : '';
        $this->isDiscount = $data['isDiscount'];
        $this->kind       = $data['kind'];

    }
} 