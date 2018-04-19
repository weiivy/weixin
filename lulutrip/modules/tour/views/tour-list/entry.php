<?= $this->registerJsFile(Yii::$app->controller->staticUrl . "list/tour/index.entry.js");?>
<?= $this->registerCssFile(Yii::$app->controller->staticUrl . "list/tour/index.entry.css", ['position'=>$this::POS_END]);?>

<!-- 主题内容 -->
<div id="content" class="content clearfix">
    <!-- 面包屑 -->
    <?php if(!empty($breadData)):?>
        <div class="crumbs">
            <?php foreach($breadData as $key => $breads):?>
                <?php if(!empty($breads['url'])):?>
                    <?php if(($key+1) == count($breadData)):?>
                        <?=$breads['name']?>
                    <?php else:?>
                    <a href="<?=$breads['url']?>"><?=$breads['name']?></a>
                    <?php endif;?>
                <?php else:?>
                    <?=$breads['name']?>
                <?php endif;?>
            <?php endforeach;?>
        </div>
    <?php endif;?>
    <div class="conten-left">
        <!-- 筛选Tab -->
        <div class="list-filter-tabs" id="listFilterTabs">
            <?= Yii::$app->view->renderFile('@tourModule/views/tour-list/list-filter-tabs.php', ['menus' => $menus, 'params' => $params, 'regionRoot' => $regionRoot, 'tabId' => $tabId])?>
        </div>
        <?php $productCount =count($products); if($productCount > 0):?>
            <!-- 筛选器 -->
            <div class="list-filter-opts" id="listFilterOpts">
                <?= Yii::$app->view->renderFile('@tourModule/views/tour-list/list-filter-opts.php', ['menus' => $menus, 'params' => $params, 'regionRoot' => $regionRoot])?>
            </div>
            <!-- 排序 -->
            <div class="list-filter-sort" id="listFilterSort">
                <?= Yii::$app->view->renderFile('@tourModule/views/tour-list/list-filter-sort.php', ['menus' => $menus, 'params' => $params])?>
            </div>
        <?php endif;?>
        <!-- 列表 -->
        <div class="product-wrapper" id="productWrapper">
            <?= Yii::$app->view->renderFile('@tourModule/views/tour-list/product-wrapper.php', ['dealMenusObj' => $menus['dealMenusObj'],'products' => $products, 'currentPage' => $params['page'], 'firstAds' => (isset($firstAds) ? $firstAds : []), 'params' => $params, 'fixedAds' => (isset($fixedAds) ? $fixedAds:[])])?>
        </div>
        <!-- 分页 -->
        <?php if(isset($page)):?>
        <div id="qaPaginationWrap" class="pagination-wrap clearfix">
            <div>
                <?= $page['bottom']?>
            </div>
        </div>
        <?php endif;?>
    </div>
    <div class="conten-right">
        <input type="hidden" id="listRegionRoot" value="<?=$regionRoot?>"/>
        <!--极光视频-->
        <?php if($params['region'] == 'NA'):?>
            <?= Yii::$app->view->renderFile('@tourModule/views/tour-list/right-video1.php')?>
        <?php endif;?>
        <!--广告-->
        <div class="list-right-ad" id="listRightad">
            <?= Yii::$app->view->renderFile('@tourModule/views/tour-list/list-rightad.php', ['menus' => $menus, 'params' => $params, 'rightAds' => (isset($rightAds) ? $rightAds:[]), 'fixedAds' => (isset($fixedAds) ? $fixedAds:[])])?>
        </div>
        <!-- 人气热卖 -->
        <div class="hot-destination" id="hotDestination">
            <?= Yii::$app->view->renderFile('@tourModule/views/tour-list/hot-destination.php', ['hotDestination' => isset($hotDestination) ? $hotDestination : []])?>
        </div>
        <!-- 微定制 -->
        <div class="list-right-cust" id="listRightcust">
            <a href="<?= Yii::$app->params['service']['www']?>/privatetour" target="_blank"><img width="234" src="//img1.quimg.com/upload/201708/1502424245335.jpg" ></a>
        </div>
        <!-- 包团定制 -->
        <div class="list-right-private" id="listRightprivate">
            <a href="<?= Yii::$app->params['service']['www']?>/privatetour" target="_blank"><img width="234" src="<?=Yii::$app->params['staticDomain']?>/llt-static/images/list/llt-privatetour-<?=strtolower($regionRoot)?>.jpg" ></a>
        </div>
        <!--北美自由行入口-->
        <?php if(Yii::$app->controller->regionRoot == 'NA'):?>
            <div class="list-right-activity">
                <a href="<?= Yii::$app->params['service']['www']?>/cruise" target="_blank"><img width="234" src="<?=Yii::$app->params['staticDomain']?>/llt-static/images/list/ship_banner.jpg" ></a>
            </div>
            <div class="list-right-activity">
                <a href="<?= Yii::$app->params['service']['www']?>/tickets/entry/region-US_cat-tag1703" target="_blank"><img width="234" src="<?=Yii::$app->params['staticDomain']?>/llt-static/images/list/theme_tickets.jpg" ></a>
            </div>
            <div class="list-right-activity">
                <a href="<?= Yii::$app->params['service']['www']?>/tickets/entry/region-US_cat-tag1701" target="_blank"><img width="234" src="<?=Yii::$app->params['staticDomain']?>/llt-static/images/list/traffic_tickets.jpg" ></a>
            </div>
            <div class="list-right-activity">
                <a href="<?= Yii::$app->params['service']['www']?>/tickets/entry_cat-tag1709" target="_blank"><img width="234" src="<?=Yii::$app->params['staticDomain']?>/llt-static/images/list/show_tickets.jpg" ></a>
            </div>
        <?php endif;?>
        <!--欧洲自由行入口-->
        <?php if(Yii::$app->controller->regionRoot == 'EU'):?>
            <div class="list-right-activity">
                <a href="<?= Yii::$app->params['service']['www']?>/activity/entry/region-EU_cat-tag1705" target="_blank"><img width="234" src="<?=Yii::$app->params['staticDomain']?>/llt-static/images/list/eu_icon.jpg" ></a>
            </div>
            <div class="list-right-activity">
                <a href="<?= Yii::$app->params['service']['www']?>/activity/entry/region-EU_cat-tag1709" target="_blank"><img width="234" src="<?=Yii::$app->params['staticDomain']?>/llt-static/images/list/eu_show.jpg" ></a>
            </div>
            <?php if(in_array($params['region'], ['UK']) || (isset($params['id']) && $params['id'] == 51) || (isset($params['citiesArr']) && in_array('LON', $params['citiesArr']))):?>
                <div class="list-right-activity">
                    <a href="<?= Yii::$app->params['service']['www']?>/activity/entry/region-EU_st-UK" target="_blank"><img width="234" src="<?=Yii::$app->params['staticDomain']?>/llt-static/images/list/eu_tickets.jpg" ></a>
                </div>
            <?php endif;?>
        <?php endif;?>
        <!-- 包团车辆视频露出 -->
        <?php if(in_array($params['region'], ['NA', 'US']) && isset($params['features']) && $params['features'] == 2303):?>
            <div class="list-right-bus" id="listRightbus">
                <?= Yii::$app->view->renderFile('@tourModule/views/tour-list/right-video2.php')?>
            </div>
        <?php endif;?>
        <!-- 轻攻略 -->
        <div class="list-right-smallraiders" id="listRightsmallraiders">
            <?= Yii::$app->view->renderFile('@tourModule/views/tour-list/list-right-smallraiders.php', ['lightRaiders' => isset($lightRaiders) ? $lightRaiders : []])?>

        </div>
        <!-- 顾问 -->
        <div class="list-consultant" id="listConsultant"></div>
        <!-- 攻略 -->
        <div class="list-right-raiders" id="listRightraiders">
            <?= Yii::$app->view->renderFile('@tourModule/views/tour-list/list-right-raiders.php', ['recPlayLists' => isset($recPlayLists) ? $recPlayLists : []])?>
        </div>
        <?= Yii::$app->view->renderFile('@tourModule/views/tour-list/right-video.php')?>
    </div>
</div>