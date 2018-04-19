<?php

namespace lulutrip\models\sale;

/**
 * Model Activities
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
class Activities extends \common\models\sale\Activities
{
    //是否无限期
    const ISALL_TRUE = 1;   //无限期
    const ISALL_FALSE = 2;   //有限期

    //网站
    const CHANNEL_1 = 1;  // lulutrip
    const CHANNEL_2 = 2;  // globerouter
    const CHANNEL_3 = 3;  // 66hao

    //平台
    const PLATFORM_ALL   = 1;   //全部
    const PLATFORM_LUPC  = 2;   //路路行PC
    const PLATFORM_LUH5  = 3;   //路路行H5

    //活动种类
    const KIND_1 = 1;  //网站活动
    const KIND_2 = 2;  //市场活动
    const KIND_3 = 3;  //秒杀活动




} 