<?php if(!empty($lightRaiders)):?>
    <div class="small-radiers">
      <div class="tip"><?=$lightRaiders['enName']?></div>
      <div class="name">第一次去<?=$lightRaiders['name']?>怎么玩?</div>
      <div class="more"><a href="<?= Yii::$app->params['service']['www'] . $lightRaiders['url']?>">点击了解详情</a></div>
    </div>
<?php endif?>
