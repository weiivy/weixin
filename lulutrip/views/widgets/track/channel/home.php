<script type="text/javascript">
    var dataLayer = dataLayer || [];
    dataLayer.push({
        //首页、欧洲频道页、澳新频道页
        'PageType': 'Homepage',
        'HashedEmail': '<?= $email;?>',
        'userId': '<?= $memberid;?>'
    });
</script>


<?= Yii::$app->view->renderFile('@lulutrip/views/widgets/track/common.php');?>

<!-- LSM -->
<script language="javascript" type="text/javascript" src="//sdc.lulutrip.com/track/seed"></script>
<script language="javascript" type="text/javascript">
    lsm.sd();
</script>
<!-- LSM -->