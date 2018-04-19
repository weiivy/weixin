<?php use \api\library\Help;?>
<script type="text/javascript">
    var dataLayer = dataLayer || [];
</script>
<?php if(!isset($noShowGa)):?>
    <?php if($event == 'paysuccess2017'):?>
        <script type="text/javascript">
            dataLayer.push(<?=json_encode($transaction)?>);
            dataLayer.push(<?=json_encode($transactionPage)?>);
        </script>
    <?php else:?>
        <script type="text/javascript">
            dataLayer.push({
                'event': '<?=$event?>'
            });
        </script>
    <?php endif;?>
<?php endif;?>


<?= Yii::$app->view->renderFile('@lulutrip/views/widgets/track/common.php');?>
<?php if(!isset($noShowGa)):?>

    <!--支付成功-->
    <?php $setOrderInfoCurrency = 0;?>
    <?php if(!empty($order->totalamounts)) {$totalamounts = json_decode($order->totalamounts, true);} foreach($totalamounts as $totalamount):?>
        <?php if($totalamount['currency'] == 'USD'):?>
            <?php $setOrderInfoCurrency = $totalamount['amount']; break;?>
        <?php endif;?>
    <?php endforeach;?>
    <?php if($event == 'paysuccess2017'):?>
        <?php if($order->sourcefrom == 'tour-new'):?>
            <script type="text/javascript">
                pubsage_conv.push(['setOrderInfo',[['<?=$order->orderconf?>', '<?=$booking->tourcode?>', '<?=$booking->product_title?>', '<?=$setOrderInfoCurrency?>']]]);
            </script>
        <?php elseif($order->sourcefrom == 'rentcar'):?>
            <script type="text/javascript">
                pubsage_conv.push(['setOrderInfo',[['<?=$order->orderconf?>', '<?=$booking->carid?>', '<?=$booking->carname?>', '<?=$setOrderInfoCurrency?>']]]);
            </script>
        <?php endif;?>
    <?php endif;?>
<?php endif;?>

<!-- LSM -->
<script language="javascript" type="text/javascript" src="//sdc.lulutrip.com/track/seed"></script>
<script language="javascript" type="text/javascript">
    lsm.sd();
</script>
<!-- LSM -->

