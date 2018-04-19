<?php
use yii\helpers\Html;
use lulutrip\assets\AppAsset;
AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!doctype html>
<!--<html lang="<?= Yii::$app->language ?>">-->
<html xmlns:wb="http://open.weibo.com/wb">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="chinaz-site-verification" content="b63a303c-edc8-4e52-afc3-2570bdc30b7b" />
    <!--<?= Html::csrfMetaTags() ?>-->
    <title><?= \Yii::$app->controller->pageTitle?></title>
    <?php $this->registerMetaTag(array("name"=>"keywords","content"=>\Yii::$app->controller->pageKeywords));?>
    <?php $this->registerMetaTag(array("name"=>"description","content"=>\Yii::$app->controller->pageDesc));?>
    <?php $this->head() ?>
</head>
<body>
<!--[if lt IE 9]>
  <p style="text-align: center;font-size: 12px;line-height: 30px;color: #666;">您正使用过时的浏览器访问路路行旅游网。建议您<a target="_blank" href="http://browsehappy.com/">升级浏览器</a>来获得更好的用户体验，发现一个全新的路路行旅游。</p>
<![endif]-->
<?php $this->beginBody() ?>
<?= (new \common\event\Language())->translation(\lulutrip\modules\channel\widgets\HeaderWidgets::widget())?>
<?= (new \common\event\Language())->translation($content)?>
<?= (new \common\event\Language())->translation(\lulutrip\modules\channel\widgets\FooterWidgets::widget())?>

<script src="<?=Yii::$app->params['staticDomain']?>/llt-static/scripts/jquery-1.8.3.min.js" charset="utf-8"></script>

<?php $this->endBody() ?>
<?= \lulutrip\widgets\TrackCode::widget();?>
</body>
</html>
<?php $this->endPage() ?>
