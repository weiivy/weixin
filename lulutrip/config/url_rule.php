<?php
$ajax = include('url_rule/llt.php');
$channel = include('url_rule/channel.php');
$tour = include('url_rule/tour.php');
$order = include('url_rule/order.php');
$rent = include('url_rule/rent.php');
$base = include('url_rule/base.php');
$rent = include('url_rule/rent.php');
$cps = include('url_rule/cps.php');

return array_merge($ajax, $channel, $tour, $order, $rent, $base);