<?php
/**
 * @Summary 自选项目配置
 * @author Justin Jia<justin.jia@ipptravel.com>
 * @copyright (c) 2017, lulutrip
 */

namespace lulutrip\modules\rentcar\library\booking;
use yii\base\Component;
use Yii;
use api\library\Help;

class OptionalProject extends Component
{
    /**
     * 获取自选项目
     * @return mixed
     */
    public function getOptional() {
        $optionals = $this->setting()['optionalProject'];
        foreach ($optionals['items'] as &$val) {
            $val['price'] = Help::fmtPrice($val['price'], $optionals['currency'])[Yii::$app->params['curCurrency']];
            $val['priceCaps'] = Help::fmtPrice($val['priceCaps'], $optionals['currency'])[Yii::$app->params['curCurrency']];
        }
        return $optionals;
    }

    /**
     * 自选项目配置
     * @author Justin Jia<justin.jia@ipptravel.com>
     * @copyright 2017-09-07
     * @return array
     */
    public function setting()
    {
        return array(
            'optionalProject' => array(
                'instruction' => '按照当地法律规定，如果儿童身高、体重或年龄在标准范围内，必须使用相应的儿童座椅。',
                'currency' => 'USD',
                'items' => array(
                    '1' => array(
                        'id' => 1,
                        'name' => '婴儿座椅',
                        'info' => '通常适用于0-15个月的婴幼儿（新泽西州地区一般对0-2岁幼儿适用）',
                        'price' => 7,
                        'priceCaps' => 50,
                    ),
                    "2" => array(
                        'id' => 2,
                        'name' => '儿童座椅',
                        'info' => '通常适用于9个月-4岁，体重约9-25公斤的儿童',
                        'price' => 7,
                        'priceCaps' => 50,
                    ),
                    "3" => array(
                        'id' => 3,
                        'name' => '儿童增高坐垫',
                        'info' => '通常适用于5-9岁的儿童',
                        'price' => 7,
                        'priceCaps' => 50,
                    ),
                    "4" => array(
                        'id' => 4,
                        'name' => 'GPS导航仪',
                        'info' => '租车公司门店提供的GPS导航仪通常为当地语言版本',
                        'price' => 7,
                        'priceCaps' => 50,
                    ),
                ),
            ),
        );
    }
}