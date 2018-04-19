<?php
return [
    'GET privatetour/home'                                                                         => 'package-tour/home',
    'GET privatetour/view-<packid>'                                                                => 'package-tour/view',
    'GET privatetour'                                                                             => 'package-tour/index',
    'GET privatetour/ptourcode-<ptourcode>'                                                       => 'package-tour/ptour',
    'GET cruise' => 'cruise/index',
    'GET cruise/view/<code>' => 'cruise/view',
    'GET cruise/select/num' => 'cruise/select_num',
    'GET cruise/select/cabincat' => 'cruise/select_cabincategory',
    'GET cruise/select/cabin' => 'cruise/select_cabin',
    'GET cruise/add_to_cart' => 'cruise/add_to_cart',
    'GET cruise/get_deal' => 'cruise/get_deal',
    'GET cruise/get_search_total' => 'cruise/get_search_total',
    [
        'pattern' => 'cruise/search/<dst:\d+>/<crl:\d+>/<prt:\d+>',
        'route' => 'cruise/search',
        'defaults' => ['dst' => 0, 'crl' => 0, 'prt' => 0]
    ],
    [
        'class'    => 'common\components\RouteUrl',
        'pattern'  => 'aggregation/index/page-<page:\d+>',
        'route'    => 'aggregation/index',
        'defaults' => ['page' => 1],
    ],
    [
        'class'    => 'common\components\RouteUrl',
        'pattern'  => 'aggregation/index_EU/page-<page:\d+>',
        'route'    => 'aggregation/index_eu',
        'defaults' => ['page' => 1],
    ],
    [
        'class'    => 'common\components\RouteUrl',
        'pattern'  => 'customized/entry/region-<region:\w*>/days-<days:\w*>/startcity-<startcity:\w*>/page-<page:\d+>',
        'route'    => 'customized/customized/entry',
        'defaults' => ['region' => '', 'days' => '', 'startcity' => '', 'page' => 1],
    ],
    [
        'class'    => 'common\components\RouteUrl',
        'pattern'  => 'privatetour/entry/region-<region:\w*>/days-<days:\w*>/theme-<theme:\w*>/startcity-<startcity:\w*>/page-<page:\d+>',
        'route'    => 'package-tour/entry',
        'defaults' => ['region' => '', 'days' => '', 'theme' => '', 'startcity' => '', 'page' => 1],
    ],
];