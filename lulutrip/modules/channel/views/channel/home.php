
<?= $this->registerJsFile(Yii::$app->controller->staticUrl . "home/america/index.entry.js");?>
<?= $this->registerCssFile(Yii::$app->controller->staticUrl . "home/america/index.entry.css", ['position'=>$this::POS_END]);?>

<!-- 主题内容 -->
<div id="content" class="content">
    <!--banner-->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/banner.php', ['mainBanner' => $mainBanner, 'subBanner' => $subBanner, 'notice' => (isset($notice) ? $notice : [])]);?>

    <!-- 限时抢购 justin-->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/purchase.php', ['purchases' => $purchases]);?>
    <!-- 本月赞品 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/monthrec_na.php', ['monthRec' => $monthRec]);?>
    <!-- 当季热门目的地 纯静-->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/themeplay.php');?>
    <!-- 热门推荐 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/NA_hot_recommend.php', ['recommendeds' => $recommendeds, 'sceneAll' => $sceneAll]);?>
    <!-- 路路小众 纯静 -->
    <?php //Yii::$app->view->renderFile('@channelModule/views/channel/common/destinations.php', ['destinations' => $destinations, 'regionRoot' => Yii::$app->controller->regionRoot]);?>
    <!-- 极光猎手 纯静 -->
    <?php // Yii::$app->view->renderFile('@channelModule/views/channel/common/aurora_hunter.php');?>
    <!-- 亲友小团 纯静 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/small_tour.php');?>
    <!-- 精选攻略 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/strategy.php', ['articles' => $articles, 'regionRoot' => Yii::$app->controller->regionRoot]);?>
    <!-- 行程管家 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/travelmanage.php', ['evaluations' => $evaluations]);?>
    <!-- 路路问答 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/lulunews.php', ['messages' => $messages]);?>
</div>