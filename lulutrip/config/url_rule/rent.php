<?php

return [
    'GET rental-car/id-<id>'                                                              => 'rentcar/rentcar/view',
    'POST rental-car/price'                                                               => 'rentcar/rentcar/price',
    'GET rental-car/booking/<shoppingId:\w+>'                                             => 'rentcar/order/schedulings',
    'POST rental-car/booking/step1'                                                       => 'rentcar/order/scheduling-submit',
    'GET rental-car/booking/count-price'                                                  => 'rentcar/booking/count-price',
    'GET rental-car/booking/<shoppingId:\w+>/promotions'                                  => 'rentcar/booking/get-promotions',
    'POST rental-car/booking/use-promotion'                                               => 'rentcar/booking/use-promotion',
    'POST rental-car/booking/delete-promotion'                                            => 'rentcar/booking/delete-promotion',
    'GET rental-car/order/<shoppingId:\w+>'                                               => 'rentcar/order/personsInfo',
    'POST rental-car/booking/step2'                                                       => 'rentcar/order/personsInfo-submit',
    'POST rental-car/order/user/quick-login'                                              => 'rentcar/order/user-quick-login',
    'GET rental-car/order/<orderId>/voucher'                                              => 'rentcar/order/view-voucher',
    'GET rental-car/order/<orderId>/invoice'                                              => 'rentcar/order/view-invoice',
    [
        'pattern' => 'rental-car/entry/<params:.*>',
        'route' => 'rentcar/rental/entry',
        'defaults' => ['params' => ''],
    ],
];