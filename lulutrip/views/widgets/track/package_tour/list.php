<script type="text/javascript">
    var dataLayer = dataLayer || [];
    dataLayer.push({
        //列表页：包团
        'PageType': 'Listingpage',
        'HashedEmail': '<?= $email;?>',
        'userId': '<?= $memberid;?>',
        'ProductIDList': <?= $productIds;?>,
        'Currency': '<?= Yii::$app->params['curCurrency'] == 'RMB' ?  'CNY' : Yii::$app->params['curCurrency'];?>'
    });
</script>


<?= Yii::$app->view->renderFile('@lulutrip/views/widgets/track/common.php');?>

<!-- LSM -->
<script language="javascript" type="text/javascript" src="//sdc.lulutrip.com/track/seed"></script>
<script language="javascript" type="text/javascript">
    lsm.sd();
</script>
<!-- LSM -->