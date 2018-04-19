<?php if(!empty($event)):?>
    <script type="text/javascript">
        var dataLayer = dataLayer || [];
        dataLayer.push({
            'event': '<?=$event?>'
        });
    </script>
<?php endif;?>
<?= Yii::$app->view->renderFile('@lulutrip/views/widgets/track/common.php');?>

<!-- LSM -->
<script language="javascript" type="text/javascript" src="//sdc.lulutrip.com/track/seed"></script>
<script language="javascript" type="text/javascript">
    lsm.sd();
</script>
<!-- LSM -->

