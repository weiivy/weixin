<?= $this->registerCssFile(Yii::$app->controller->staticUrl . "home/australia/index.entry.css");?>
<?= $this->registerJsFile(Yii::$app->controller->staticUrl . "home/australia/index.entry.js");?>

<!-- 主题内容 -->
<div id="content" class="content">
    <!-- banner -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/banner.php', ['mainBanner' => $mainBanner, 'subBanner' => $subBanner, 'notice' => (isset($notice) ? $notice : [])]);?>

    <!-- 澳大利亚旅游 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/AU_destination.php', ['pagecontsProduct' => $pagecontsProduct])?>
    <!-- 新西兰旅游 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/AU_zizhuyou.php', ['pagecontsProductDiy' => $pagecontsProductDiy])?>
    <!-- 本月赞品 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/monthrec_au.php', ['monthRec' => $monthRec]);?>
    <!-- 亲友小团 纯静 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/small_tour.php', ['smallTour' => isset($smallTour) ? $smallTour : []]);?>

    <!-- 精选攻略 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/strategy.php', ['articles' => $articles, 'regionRoot' => Yii::$app->controller->regionRoot]);?>
    <!-- 路路问答 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/lulunews.php', ['messages' => $messages]);?>
</div>