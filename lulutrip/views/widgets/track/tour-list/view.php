<script type="text/javascript">
    var dataLayer = dataLayer || [];
    dataLayer.push({
        //旅行团详情页
        'event': 'tourview2017',
        'PageType': 'Productpage',
        'HashedEmail': "<?= $email;?>",
        'userId': "<?= $memberid;?>",
        'ProductID': <?= $trackCode['productId'];?>,
        'travel_pagetype': 'productPage',  //目前pagetype都是'productPage'
        'travel_destid': "<?= $trackCode['productId'];?>",  //产品ID
        'travel_origin': "<?= $trackCode['cityCode'];?>", //产品出发城市
        'travel_totalvalue': "<?php if( $trackCode['offPercent'] < 1){ echo ceil($trackCode['offPercent'] * $trackCode['price']);} else {echo ceil($trackCode['price']);}?>", //产品显示价格
        'img_url': "<?= $trackCode['photo'];?>",
        'product_url': "<?= $trackCode['url'];?>?utm_source=360&utm_medium=dpa",
        'price_cny': "<?= $trackCode['priceRMB'];?>",
        'Currency': "<?= Yii::$app->params['curCurrency'] == 'RMB' ?  'CNY' : Yii::$app->params['curCurrency'];?>",
        'Location' : "<?= Yii::$app->params['IPArea']?>"
    });
</script>


<?= Yii::$app->view->renderFile('@lulutrip/views/widgets/track/common.php');?>

<!--新GA分析-->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-108655701-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-108655701-1');
</script>
<!--新GA分析 end -->

<!-- LSM -->
<script language="javascript" type="text/javascript" src="//sdc.lulutrip.com/track/seed"></script>
<script language="javascript" type="text/javascript">
    lsm.sd();
</script>
<!-- LSM -->

