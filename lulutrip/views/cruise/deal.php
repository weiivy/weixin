<ul>
                                <?php foreach ($deal as $value) {
    if ($value['DealType'] != 'LastMinute') {
        continue;
    }
    ?>
    <li>
        <a href="/cruise/view/<?= $value['viewCode']?>" target="_blank"><span><?php if ($value['DestinationNameCN']) {echo $value['DestinationNameCN'];} else {echo $value['DestinationName'];}?></span> - <?php if ($value['ItineraryNameCN']) {echo $value['ItineraryNameCN'];} else {echo $value['ItineraryName'];}?></a>
        <span class="price"><?= Yii::$app->params['curCurrencies']['sign'] . $value['PricePublish'][Yii::$app->params['curCurrency']]?></span>
        <span><?php echo $value['SailingDuration'];?></span>
    </li>
<?php }?>
</ul>