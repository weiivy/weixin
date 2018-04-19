<?php if(!empty($pagecontsProduct)):?>
    <?php
        $tabs = array_column($pagecontsProduct, 'pagecontstab');
        $pagecontstag = array_column($pagecontsProduct, 'pagecontstag');
        $pagecontsurl = array_column($pagecontsProduct, 'pagecontsurl');
    ?>
    <!-- 目的地推荐 -->
    <div class="hot-rec clearfix hot-rec-eu-tour">
        <div class="wrap hot-rec-wrap clearfix" id="hot-rec-wrap">
            <h2 class="hr-tit">当地参团<span>精选目的地</span></h2>
            <ul class="hr-sel tab-menu">
                <?php foreach($tabs as $key => $tab):?>
                    <li class="ls-sel-li <?php if($key == 0):?>current<?php endif;?>"><?=$tab?>
                        <?php if($key == 2 || $key == 5): ?><div class="hot"></div><?php endif; ?>
                    </li>
                <?php endforeach;?>
            </ul>
            <div class="hr-con tab-box">
                <?php foreach($pagecontstag as $key => $products):?>
                    <div class="hr-con-ul show <?php if($key!= 0):?>hide<?php endif;?>">
                        <?php foreach($products as $key2 => $product):?>
                            <?php if($key2 == 5):?>
                                <!-- 最后一个更多产品 开始 -->
                                <li >
                                    <div class="show-more">
                                        <a href="<?= $pagecontsurl[$key]?>" target="_blank">
                                            <div class="show-more-inside">
                                                <p>查看更多<?= $tabs[$key]?>路线<span class="p-icon"></span></p>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                                <!-- 最后一个更多产品 结束 -->
                            <?php else:?>
                            <li>
                                <div class="img">
                                    <a href="<?= Yii::$app->params['service']['www']?><?=$product['link']?>" target="_blank"><q></q>
                                        <img class="<?php if($key == 0):?>lazy<?php else:?>lazy-hide<?php endif;?>" data-original="<?= $product['imgage']?>" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/preload_l.gif'?>" alt="<?= \yii\helpers\Html::decode($product['subject'])?>"/>
                                    </a>
                                    <span class="tip"><?=$product['title']?></span>
                                    <?php if(!empty($product['discount'])):?>
                                        <span class="rec-sale"><?=$product['discount']?>%<b>OFF</b></span>
                                    <?php endif;?>
                                    <?php if(!empty($product['startCity'])):?>
                                        <span class="cfd">出发地：<?=$product['startCity'] ?></span>
                                    <?php endif;?>
                                </div>
                                <div class="img-bottom">
                                    <p><a href="<?= Yii::$app->params['service']['www']?><?=$product['link']?>" target="_blank"><?= \yii\helpers\Html::decode($product['subject'])?></a></p>
                                    <span><i><?= Yii::$app->params['curCurrencies']['sign']?></i> <?= $product['price']['min'][Yii::$app->params['curCurrency']]?></span>
                                </div>
                            </li>
                            <?php endif;?>
                        <?php endforeach;?>
                    </div>
                <?php endforeach;?>
            </div>
            <div class="hr-sum">
                <ul class="hr-sum-cons">
                    <div class="sum-tit sum-tit-big">旅行日历</div>
                    <p>对的时间，遇见对的风景</p>
                </ul>
                <ul class="hr-sum-cons">
                    <div class="sum-tit">3月出发</div>
                    <li><a href="<?= Yii::$app->params['service']['www']?>/tour/view/tourcode-8649" target="_blank">◆ 意大利·7天深度全览&nbsp;<img class="ml5" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/hot.gif'?>"></a></li>
                    <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_d-7_f-337" target="_blank">◆ 西葡·10城全景7日纵览&nbsp;<img class="ml5" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/hot.gif'?>"></a></li>
                    <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_d-5%7C6%7C7_f-342" target="_blank">◆ 法意瑞·经典5-7日游</a></li>
                </ul>
                <ul class="hr-sum-cons clearfix">
                    <div class="sum-tit">4月出发</div>
                    <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-302" target="_blank">◆ 英国·5-10日三岛纵览&nbsp;<img class="ml5" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/hot.gif'?>"></a></li>
                    <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_c-FRANK%7CStuttgar%7CMUC_f-5858" target="_blank">◆ 童话德瑞·一国深度&nbsp;<img class="ml5" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/hot.gif'?>"></a></li>
                    <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-739" target="_blank">◆ 西欧全景·荷兰赏花</a></li>
                </ul>
                <ul class="hr-sum-cons clearfix">
                    <div class="sum-tit">5月出发</div>
                    <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-GR?saleact=saletype6" target="_blank">◆ 希腊·7天自助游套餐&nbsp;<img class="ml5" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/new.gif'?>"></a></li>
                    <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_d-3_f-523" target="_blank">◆ 苏格兰高地·3日深度&nbsp;<img class="ml5" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/hot.gif'?>"></a></li>
                    <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-1305" target="_blank">◆ 南法·薰衣草之旅</a></li>
                </ul>
                <ul class="hr-sum-cons clearfix">
                    <div class="sum-tit">6月出发</div>
                    <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-765" target="_blank">◆ 北欧四国·峡湾之王</a></li>
                    <li><a href="<?= Yii::$app->params['service']['www']?>/search/tour?keyword=%E6%B3%A2%E7%BD%97%E7%9A%84%E6%B5%B7" target="_blank">◆ 东欧·波罗的海小众游&nbsp;<img class="ml5" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/new.gif'?>"></a></li>
                    <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-EU_f-1321" target="_blank">◆ 夏季冰岛·午夜阳光</a></li>
                </ul>
            </div>
        </div>
    </div>
<?php endif;?>