<?php

return [
    'GET payment/result' => 'order/payment/result',
    'GET order/<orderId>/voucher' => 'order/order/view-voucher',
    'GET order/<orderId>/invoice' => 'order/order/view-invoice',
    'POST tour/order/user/quick-login' => 'llt/user/quick-login'
];