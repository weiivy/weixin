<?php
return [
    'GET tour/view/tourcode-<tourCode:\d+>'         => 'tour/detail/view',
    'GET tour/booking/<shoppingId:\w+>'             => 'tour/order/scheduling',
    'POST tour/booking/step1'                       => 'tour/order/scheduling-submit',
    'GET tour/order/<shoppingId:\w+>'               => 'tour/order/personsInfo',
    'POST tour/booking/step2'                       => 'tour/order/personsInfo-submit',
    'POST tour/order/user/quick-login'              => 'tour/order/user-quick-login',
    'GET tour/booking/<shoppingId:\w+>/promotions'  => 'tour/booking/get-promotions',
    'GET tour/booking/<shoppingId:\w+>/points'      => 'tour/booking/get-points',
    'GET tour/booking/<shoppingId:\w+>/check'       => 'tour/booking/check',
    'GET tour/booking/<shoppingId:\w+>/discount'    => 'tour/booking/get-discount',
    [
        'pattern' => 'tour/destination/<params:.*>',
        'route' => 'tour/tour-list/list',
        'defaults' => ['params' => ''],
    ],
    [
        'pattern' => 'tour/north_america/<params:.*>',
        'route' => 'tour/tour-list/list',
        'defaults' => ['params' => ''],
    ],
];