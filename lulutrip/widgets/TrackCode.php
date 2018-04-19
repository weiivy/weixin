<?php
/**
 * @copyright (c) 2017, lulutrip.com
 * @author  martin ren<martin@lulutrip.com>
 */

namespace lulutrip\widgets;

use api\library\Help;
use lulutrip\models\CPhotos;
use lulutrip\models\order\Ordersum;
use Curl\Curl;
use lulutrip\components\WebUser;
use lulutrip\modules\tour\library\booking\ShoppingData;
use yii\base\Widget;
use Yii;
use yii\helpers\Json;

class TrackCode extends Widget
{
    private $_user;

    public function run()
    {
        if(YII_ENV != 'prod') {
            return false;
        }

        $this->_user = (new WebUser)->getCurrentUser();
        switch (Yii::$app->controller->id) {
            case 'package-tour':
                if(in_array(Yii::$app->controller->action->id, ['home', 'entry', 'view'])) {
                    return $this->_packageTour();
                }
            break;
            case 'channel':
                if(in_array(Yii::$app->controller->action->id, ['home', 'europe', 'australia_newzealand'])) {
                    return $this->_channel();
                }
            break;
            case 'detail':
            case 'tour-list':
                if(in_array(Yii::$app->controller->action->id, ['list'])) {
                    return $this->_tourList();
                }
                if(in_array(Yii::$app->controller->action->id, ['view'])) {
                    return $this->_tourView();
                }
                break;
            case 'payment':
                if(in_array(Yii::$app->controller->action->id, ['result'])) {
                    return $this->_payment();
                }
            case 'order':
                if(in_array(Yii::$app->controller->action->id, ['scheduling', 'personsInfo'])) {
                    $event = '';
                    switch(Yii::$app->controller->action->id)
                    {
                        case 'scheduling':
                            $event = 'tourbooking2017';
                            break;
                        case 'personsInfo':
                            $event = 'tourorder2017';
                            break;

                    }
                    return $this->_common($event);
                }
            default:
                return $this->_common(Yii::$app->controller->id . '-' . Yii::$app->controller->action->id);
        }
    }

    private function _packageTour()
    {
        $user     = $this->_user;
        $email    = '';
        $memberid = '';
        if($user) {
            $email    = $user['email'] ? md5($user['email']) : '';
            $memberid = $user['memberid'];
        }

        if(Yii::$app->controller->action->id === 'view') {
            $productIds = Yii::$app->controller->action->productIds;
            return $this->render('@lulutrip/views/widgets/track/package_tour/detail', [
                'email'       => $email,
                'memberid'    => $memberid,
                'productId'   => $productIds,
                'packagetour' => Yii::$app->controller->action->packagetour,
            ]);
        }

        $productIds = Json::encode(Yii::$app->controller->action->productIds);
        return $this->render('@lulutrip/views/widgets/track/package_tour/list', [
            'email'      => $email,
            'memberid'   => $memberid,
            'productIds' => $productIds,
        ]);
    }


    /**
     * 频道页trackcode
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-07-14
     *
     */
    private function _channel()
    {
        $user     = $this->_user;
        $email    = '';
        $memberid = '';
        if($user) {
            $email    = $user['email'] ? md5($user['email']) : '';
            $memberid = $user['memberid'];
        }
        return $this->render('@lulutrip/views/widgets/track/channel/home', [
            'email'      => $email,
            'memberid'   => $memberid,
        ]);
    }

    /**
     * 频道页trackcode
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-07-14
     *
     */
    private function _tourList()
    {
        $user     = $this->_user;
        $email    = '';
        $memberid = '';
        if($user) {
            $email    = $user['email'] ? md5($user['email']) : '';
            $memberid = $user['memberid'];
        }

        $productIds = Json::encode(Yii::$app->controller->action->productIds);
        return $this->render('@lulutrip/views/widgets/track/tour-list/list', [
            'email'      => $email,
            'memberid'   => $memberid,
            'productIds' => $productIds,
        ]);
    }

    /**
     * 详情页trackcode
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-08-22
     */
    private function _tourView()
    {
        $user     = $this->_user;
        $email    = '';
        $memberid = '';
        if($user) {
            $email    = $user['email'] ? md5($user['email']) : '';
            $memberid = $user['memberid'];
        }

        $trackCode = Yii::$app->controller->trackCode;
        return $this->render('@lulutrip/views/widgets/track/tour-list/view', [
            'email'      => $email,
            'memberid'   => $memberid,
            'trackCode'  => $trackCode,
        ]);
    }

    /**
     * 支付成功和支付失败GA
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-10-19
     */
    public function _payment()
    {
        $gaParams = Yii::$app->controller->action->gaParams;
        $orderId = $gaParams['orderId'];
        $result = $gaParams['result'];

        //获取订单信息
        $order = Ordersum::findOne(['orderid' => $orderId]);

        //处理币种
        if(empty($gaParams['currency'])) {
            $gaParams['currency'] = empty($order->payment_currency) ? $order->currency : $order->payment_currency;
        }
        $currency = $gaParams['currency'] == 'RMB' ? 'CNY' : $gaParams['currency'];

        //订单金额
        if(empty($gaParams['totalAmount'])) {
            $gaParams['totalAmount'] = empty($order->payment_amount) ? $order->totalamount : $order->payment_amount;
        }
        $paymentAmount = $gaParams['totalAmount'];

        //检查paysuccess ga日志是否存在
        $gaLogCount = Yii::$app->helper->curlPost(Yii::$app->config->api . '/log/check-ga', ['orderConf' => $order->orderconf, 'source' => 'paysuccess']);
        if($gaLogCount['count'] > 0) return $this->render('@lulutrip/views/widgets/track/order/booking', ['noShowGa' => 1]);

        //不是新旅行团、租车订单走common
        if(!in_array($order->sourcefrom, ['tour-new', 'rentcar'])) return $this->_common();
        //新旅行团
        if($order->sourcefrom == 'tour-new'){
            $booking = $order->booking;
            $bookingRooms = $booking->getBookingRooms();
            $totalPersons = $bookingRooms['total']['adultCount'] + $bookingRooms['total']['childCount'] + $bookingRooms['total']['luluCount'];

            //产品信息
            $curl = new Curl();
            $curl->setHeader('Content-Type', 'application/json');
            $url = Yii::$app->params['service']['tourapi'] . "/gtravel/lulu/product/{$booking->tourcode}/pinfo";
            $curl->get($url);
            $data = json_decode(json_encode($curl->response), true);
            //记录日志
            Yii::info('API-GET:' . $url . '===' . json_encode(['Content-Type' => 'application/json']). '===' . json_encode($data), __METHOD__);


            $productList = [];
            $totalamounts = json_decode($order->totalamounts, true);
            foreach($totalamounts as $totalamount) {
                $productList['products_list_' . $totalamount['currency']] = [
                    [
                        'id'    => $booking->product_id,
                        'price' => $totalamount['amount'],
                        'quantity' => $totalPersons
                    ],
                ];
            }
            $totalamounts = array_column($totalamounts, 'amount', 'currency');
            $trackCode = [
                'name'       => $booking->product_title . "(旅行团" . $booking->tourcode . ")" . $data['data']['basic']['area'][0]['luluCode'],
                'id'         => $booking->tourcode,
                'price'      => round($paymentAmount/$totalPersons, 2),
                'brand'      => $booking['supplier_id'],
                'category'   => $data['data']['basic']['area'][0]['luluCode'],
                'quantity'   => $totalPersons,

            ];
            $event = ($result == 'SUCCESS' ? 'paysuccess2017' : 'payfailed2017');
            $member = $order->member;
            $transactionPage = [
                "event" => $event,
                "PageType" => "Transactionpage",
                "HashedEmail" => (!empty($member) ? md5($member->email) : ""),
                "userId"  => (!empty($member) ? $member->memberid : ""),
                "ProductTransactionProducts" => $productList['products_list_'.$order->currency],
                "ProductTransactionProductsGB" => $productList['products_list_GBP'],
                "ProductTransactionProductsDE" => $productList['products_list_EUR'],
                "TransactionID"  => $order->orderconf,
                "img_url" => $data['data']['photo']['photo'],
                "product_url" => Yii::$app->config->www . '/tour/view/tourcode-'. $data['data']['basic']['productCode']."?utm_source=360&utm_medium=dpa",
                "price_cny" => Help::exchangeCurrency($booking->bkamt, $order->currency, 'RMB', 'round2'),
                "rev_cny" => $totalamounts['RMB'],
                "Currency" => $currency,
                "Location" =>  Yii::$app->params['IPArea'],
            ];
            $transaction = [
                "event" => "transaction",
                "currencyCode" => $currency,
                "ecommerce" => [
                    "currencyCode" => $currency,
                    "purchase"     => [
                        "currencyCode" => $currency,
                        "actionField"  => [
                            "id" => $order->orderconf . (Yii::$app->params['curLang'] == 'HK' ? 'HK' : ''),
                            "affiliation" => $order->paytype,
                            "revenue"  => $paymentAmount
                        ],
                        "products" => [
                            $trackCode
                        ]
                    ],
                ],
            ];


        }elseif($order->sourcefrom == 'rentcar' ){
            $booking = $order->orderRentcar[0];
            $totalPersons = 1;

            $productList = [];
            $totalamounts = json_decode($order->totalamounts, true);
            foreach($totalamounts as $totalamount) {
                $productList['products_list_' . $totalamount['currency']] = [
                    [
                        'id'    => $booking->carid,
                        'price' => $totalamount['amount'],
                        'quantity' => $totalPersons
                    ],
                ];
            }
            $trackCode = [
                'name'       => $booking->carname . "(租车" . $booking->carid . ")",
                'id'         => $booking->carid,
                'price'      => $paymentAmount,
                'brand'      => $booking['supplier_id'],
                'category'   => '柯信租车',
                'quantity'   => $totalPersons,

            ];
            $event = ($result == 'SUCCESS' ? 'paysuccess2017' : 'payfailed2017');
            $member = $order->member;
            $transactionPage = [
                "event" => $event,
                "PageType" => "Transactionpage",
                "HashedEmail" => (!empty($member) ? md5($member->email) : ""),
                "userId"  => (!empty($member) ? $member->memberid : ""),
                "ProductTransactionProducts" => $productList['products_list_'.$order->currency],
                "ProductTransactionProductsGB" => $productList['products_list_GBP'],
                "ProductTransactionProductsDE" => $productList['products_list_EUR'],
                "TransactionID"  => $order->orderconf,
                "Currency" => $currency,
                "Location" =>  Yii::$app->params['IPArea'],
            ];
            $transaction = [
                "event" => "transaction",
                "currencyCode" => $currency,
                "ecommerce" => [
                    "currencyCode" => $currency,
                    "purchase"     => [
                        "currencyCode" => $currency,
                        "actionField"  => [
                            "id" => $order->orderconf . (Yii::$app->params['curLang'] == 'HK' ? 'HK' : ''),
                            "affiliation" => $order->paytype,
                            "revenue"  => $paymentAmount
                        ],
                        "products" => [
                            $trackCode
                        ]
                    ],
                ],
            ];

        }

        $post = [
            'method'=> __METHOD__,
            'orderconf' => $order->orderconf,
            'source' => 'paysuccess',
            'content' => [
                'transactionPage' => $transactionPage,
                'transaction'     => $transaction,
                'event' => $event,
                'products'  => [$trackCode],
                'totalAmount' => $order->totalamounts
            ]
        ];
        $result = Yii::$app->helper->curlPost(Yii::$app->config->api . '/log/save-ga-log', $post);
        return $this->render('@lulutrip/views/widgets/track/order/booking', [
            'order' => $order,
            'booking' => $booking,
            'event' => $event,
            'transaction'     => $transaction,
            'transactionPage' => $transactionPage
        ]);
    }

    /**
     * GTM
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-10-19
     * @param string $event
     * @return string
     */
    public function _common($event = '')
    {
        return $this->render('@lulutrip/views/widgets/track/common/common', [
            'event' => $event
        ]);
    }
}


