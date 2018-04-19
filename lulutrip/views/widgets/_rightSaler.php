<div class="fl" style="position:relative; z-index:99;">
    <div class="name"><?=$rightSaler['name_en']?></div>
    <div class="f16 mt10"><?=$rightSaler['country']?>当地顾问</div>
    <div class="mt10"><a href="<?= Yii::$app->params['service']['www']?>/adviser/home/id-<?=$rightSaler['id']?>" class="comm-btn2 comm-btn-sm" target="_blank">查看介绍</a></div>
</div>
<div class="image"><img src="<?= Yii::$app->helper->getImgDomain()?>/<?=$rightSaler['avatar_3']?>" width="100" style="margin-top:-10px;"></div>
<div class="clear"></div>