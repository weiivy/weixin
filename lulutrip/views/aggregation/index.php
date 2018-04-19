<?php use yii\helpers\Html;?>
<link href="<?= Yii::$app->helper->getFileUrl('/css/aggregation.css'); ?>" rel="stylesheet">
<div class="ll-niche wrap">
    <h1>路路<span>小众</span></h1>
    <?php foreach($list as $value):?>
        <?php if($value['type'] == 1):?>
        <div class="niche-container clearfix " id="J_id<?= $value['id']?>">
            <h2><a href="<?= $value['url']?>" target="_blank"><?= Html::decode($value['title'])?></a></h2>
            <a href="<?= $value['url']?>" target="_blank" class="aimg"><img style="border: 1px solid #e9e9e9;" onerror="this.src='<?= Yii::$app->helper->getFileUrl('/images/no_pic.jpg')?>'" src="<?= Yii::$app->helper->getImgDomain() . '/' . $value['image']?>"></a>
            <div>
                <p><a href="<?= $value['url']?>" target="_blank"><?= Html::decode($value['description'])?></a></p>
                <a href="<?= $value['url']?>" target="_blank" class="explore">开始探索</a>
            </div>
        </div>
        <?php elseif($value['type'] == 2):?>
        <div class="niche-container clearfix">
            <h2><a href="<?= $value['url']?>" target="_blank"><?= Html::decode($value['title'])?></a></h2>
            <a href="<?= $value['url']?>" target="_blank" class="aimg"><img style="border: 1px solid #e9e9e9;" onerror="this.src='<?= Yii::$app->helper->getFileUrl('/images/no_pic.jpg')?>'" src="<?= Yii::$app->helper->getImgDomain() . '/' . $value['image']?>"></a>
            <div>
                <p><a href="<?= $value['url']?>" target="_blank"><?= Html::decode($value['description'])?></a></p>
                <a href="<?= $value['url']?>" target="_blank" class="explore">开始探索</a>
            </div>
        </div>
        <?php endif;?>
    <?php endforeach;?>
</div>
<?php if($pageCount > 1) :?>
<div class="bottom_pagenum">
    <div style="margin-left: -241.5px;" class="bg_navs">
        <?= $pageData?>
    </div>
</div>
<?php endif;?>