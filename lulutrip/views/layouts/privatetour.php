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
    <?php $this->beginBody() ?>
    <?= (new \common\event\Language)->translation($content) ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>