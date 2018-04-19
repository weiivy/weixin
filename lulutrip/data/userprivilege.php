<?php
/**
 * 用户级别相关
 * @copyright (c) 2017, lulutrip.com
 * @author  Serena Liu<serena@lulutrip.com>
 */
$userprivilege = array(1 => '积分兑换', 2 => '专题活动',
		3 => '1.5倍积分', 4 => '路路行特刊', 5 => 'WIFI租赁',
		6 => '生日优惠', 7 => '节日红包', 8 => '专属客服',
		9 => '专享派对', 10 => '路路杂志', 11 => '1倍积分',
		12 => '2倍积分',16=>'1.25倍积分'
);

//$privilege = array(
//		0 => array(1, 11, 6, 7),
//		1 => array(1, 16, 2, 6, 7),
//		2 => array(1, 3, 2, 4, 6, 7, 10),
//		3 => array(1, 12, 2, 4, 6, 7, 8, 9, 10),
//		4 => array(1, 12, 2, 4, 6, 7, 8, 9, 10),
//);

$privilege = array(
    0 => array(1, 11),
    1 => array(1, 16),
    2 => array(1, 3),
    3 => array(1, 12),
    4 => array(1, 12, 2, 4, 6, 7, 8, 9, 10),
);

$promotion_products = array(
		0 => '旅行团（Tours）',
		1 => '自由行（Activities）',
		2 => '酒店（hotels）',
		3 => '包车（Cars）',
		4 => '一键包团',
);

$wificategoryid = 0;	//WIFI租赁 类目id=93, 2015.1.15设置为0，运营那边暂时还没这个wifi产品打折优惠