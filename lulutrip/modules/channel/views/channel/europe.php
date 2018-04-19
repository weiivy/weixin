<?= $this->registerCssFile(Yii::$app->controller->staticUrl . "home/europe/index.entry.css");?>
<?= $this->registerJsFile(Yii::$app->controller->staticUrl . "home/europe/index.entry.js");?>

<!-- 主题内容 -->
<div id="content" class="content">
    <!--banner-->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/banner.php', ['mainBanner' => $mainBanner, 'subBanner' => $subBanner, 'notice' => (isset($notice) ? $notice : [])]);?>
    <!-- 目的地推荐 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/EU_destination_rec.php', ['pagecontsProduct' => $pagecontsProduct, 'sceneAll' => $sceneAll]);?>
    <!-- 本月赞品 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/monthrec.php', ['monthRec' => $monthRec]);?>
    <!-- 欧洲循环线 -->
    <div class="bus-line">
        <div class="bus-line-detail">
            <div class="navsbar">
                <div class="total">
                    <h3 class="tit ac">欧洲循环巴士游</h3>
                    <p>七条线路，七天一圈，周周出发自由搭配，玩遍欧洲25国、61城每天79欧，含交通、住宿、导游</p>
                    <a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-5902" target="_blank" class="comm-btn1 comm-btn-mlg">查看全部循环线</a>
                </div>
                <div class="detail">
                    <ul>
                        <li class="red">
                            <a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-281" target="_blank">
                                <h4>西欧（法德荷比卢）</h4>
                                <div>
                                    <p>短时间玩遍法国、德国、比利时、荷兰、卢森堡感受西欧独特风情。</p>
                                    <span class="comm-btn1">查看红线产品</span>
                                </div>
                            </a>
                        </li>
                        <li class="green">
                            <a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-280" target="_blank">
                                <h4>法意瑞（法国瑞士意大利）</h4>
                                <div>
                                    <p>畅游意大利、瑞士、南法海岸，深度体验古罗马、文艺复兴艺术、品位地中海浪漫风光。</p>
                                    <span class="comm-btn1">查看绿线产品</span>
                                </div>
                            </a>
                        </li>
                        <li class="blue">
                            <a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-282" target="_blank">
                                <h4>东欧（德瑞奥捷匈）</h4>
                                <div>
                                    <p>拥抱东欧古老帝国情调，玩遍布拉格、布达佩斯、维也纳，铁力士山童话美景。</p>
                                    <span class="comm-btn1">查看蓝线产品</span>
                                </div>
                            </a>
                        </li>
                        <li class="yellow">
                            <a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-284" target="_blank">
                                <h4>西葡（西班牙葡萄牙）</h4>
                                <div>
                                    <p>环游西班牙，葡萄牙，弹性自由，入团地点多，行程最深度！</p>
                                    <span class="comm-btn1">查看黄线产品</span>
                                </div>
                            </a>
                            <span></span>
                        </li>
                        <li class="purple">
                            <a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-283" target="_blank">
                                <h4>英国（英格兰苏格兰）</h4>
                                <div>
                                    <p>完整英伦之旅，一览英格兰苏格兰的人文历史与自然美景。</p>
                                    <span class="comm-btn1">查看紫线产品</span>
                                </div>
                            </a>
                        </li>
                        <li class="pink">
                            <a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-1059" target="_blank">
                                <h4>北欧（瑞典丹麦挪威）</h4>
                                <div>
                                    <p>一次玩遍挪威，瑞典等北欧国家，深入体验最壮观峡湾与冰川奇景。</p>
                                    <span class="comm-btn1">查看粉线产品</span>
                                </div>
                            </a>
                        </li>
                        <li class="orange">
                            <a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-1061" target="_blank">
                                <h4>巴塞南法（法国西班牙）</h4>
                                <div>
                                    <p>游玩法国和西班牙的最浪漫路线，饱览古堡、酒庄、花海和沙滩风情。</p>
                                    <span class="comm-btn1">查看橙线产品</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="lines-map">
                <img src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/home/europe/bus_tour_map_bgi.jpg'?>">
                <div class="map-line line-red">
                    <a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-281" target="_blank"></a>
                </div>
                <div class="map-line line-green">
                    <a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-280" target="_blank"></a>
                </div>
                <div class="map-line line-blue">
                    <a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-282" target="_blank"></a>
                </div>
                <div class="map-line line-yellow">
                    <a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-284" target="_blank"></a>
                </div>
                <div class="map-line line-purple">
                    <a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-283" target="_blank"></a>
                </div>
                <div class="map-line line-pink">
                    <a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-1059" target="_blank"></a>
                </div>
                <div class="map-line line-orange">
                    <a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-1061" target="_blank"></a>
                </div>
                <div class="transfer paris"><img src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/home/europe/paris.png'?>" alt=""></div>
                <div class="transfer frankfurt"><img src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/home/europe/frankfurt.png'?>" alt=""></div>
                <div class="transfer lucerne"><img src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/home/europe/lucerne.png'?>" alt=""></div>
                <div class="transfer barcelona"><img src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/home/europe/barcelona.png'?>" alt=""></div>
            </div>
        </div>
    </div>


    <!-- 自助游精选目的地 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/EU_activity_rec.php', ['activityRec' => $activityRec]);?>

    <!-- 亲友小团 纯静 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/small_tour.php');?> 

    <!-- 极光猎手 纯静 -->
    <?php // Yii::$app->view->renderFile('@channelModule/views/channel/common/aurora_hunter.php');?>
    <!-- 新奇目的地 -->
    <?php //Yii::$app->view->renderFile('@channelModule/views/channel/common/destinations.php', ['destinations' => $destinations, 'regionRoot' => Yii::$app->controller->regionRoot]);?>

    <!-- 精选攻略 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/strategy.php', ['articles' => $articles, 'regionRoot' => Yii::$app->controller->regionRoot]);?>
    <!-- 路路问答 -->
    <?= Yii::$app->view->renderFile('@channelModule/views/channel/common/lulunews.php', ['messages' => $messages]);?>
</div>
