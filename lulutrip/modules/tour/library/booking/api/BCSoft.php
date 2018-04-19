<?php

namespace lulutrip\modules\tour\library\booking\api;

use Curl\Curl;
use lulutrip\modules\tour\library\booking\ShoppingData;
use Yii;

/**
 * 黑猫 API
 * @package lulutrip\modules\tour\library\booking\api
 * @author Victor Tang<victor.tang@ipptravel.com>
 * @copyright (c) 2018, lulutrip.com
 */
class BCSoft {
    /**
     * @var string
     */
    private $server;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * BCSoft constructor.
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2018-02-09
     */
    public function __construct()
    {
        $this->server = Yii::$app->params['service']['BCSoft']['server'];
        $this->email = Yii::$app->params['service']['BCSoft']['email'];
        $this->apiKey = Yii::$app->params['service']['BCSoft']['apiKey'];
    }

    /**
     * 检查产品库存
     * @author Victor Tang<victor.tang@ipptravel.com>
     * @copyright 2018-02-08
     * @param ShoppingData $shoppingData
     * @throws \Exception
     */
    public function productInventory(ShoppingData $shoppingData) {
        $curl = new Curl();
        $supplierInfo = GetSupplierInfo::data($shoppingData);

        if ($supplierInfo['supplyInfo']['apiProductId'] > 0) {
            $inventory = GetInventory::data($shoppingData);
            $curl->get("{$this->server}/product/inventory", [
                'email' => $this->email,
                'apikey' => $this->apiKey,
                'productId' => $supplierInfo['supplyInfo']['apiProductId'],
                'optionId' => $inventory['inventors']['master']['items'][0]['apiItemId'],
                'year' => date('Y', strtotime($shoppingData->sdate)),
                'month' => date('m', strtotime($shoppingData->sdate))
            ]);

            if ($curl->response->info->success == 1) {
                Yii::info("黑猫产品库存查询成功: " . json_encode($curl->response), __METHOD__);

                $checkProductInventory = function () use ($curl, $shoppingData) {
                    foreach ($curl->response->data as $inventory) {
                        if ($inventory->serviceDate = $shoppingData->sdate && $inventory->inventory >= $shoppingData->adultCount + $shoppingData->childCount) {
                            return true;
                        }
                    }
                    return false;
                };

                if ($checkProductInventory() == false) {
                    throw new \Exception("黑猫产品库存不足");
                }
            } else {
                Yii::error("黑猫产品库存查询失败: " . json_encode($curl->response), __METHOD__);
                throw new \Exception($curl->response->info->message);
            }
        }
    }
}