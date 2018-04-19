<!-- 澳大利亚旅游 -->
<?php if(!empty($pagecontsProduct)):?>
    <?php
        $tabs = array_column($pagecontsProduct, 'pagecontstab');
        $pagecontstag = array_column($pagecontsProduct, 'pagecontstag');
        $pagecontsurl = array_column($pagecontsProduct, 'pagecontsurl');
    ?>
<div class="hot-rec clearfix hot-rec-au-tour">
    <div class="wrap hot-rec-wrap clearfix" id="hot-rec-wrap">
        <h2 class="hr-tit">澳大利亚<span>旅游</span></h2>
        <ul class="hr-sel tab-menu">
            <?php foreach($tabs as $key => $tab):?>
                <li class="ls-sel-li <?php if($key == 0):?>current<?php endif;?>"><?=$tab?> <span></span>
                    <?php if($key == 4): ?><div class="hot"></div><?php endif; ?>
                </li>
            <?php endforeach;?>
        </ul>
        <div class="hr-con tab-box">
             <?php foreach($pagecontstag as $key => $products):?>
                <div class="hr-con-ul show <?php if($key!= 0):?>hide<?php endif;?>">
                    <?php foreach($products as $key2 => $product):?>
                        <?php if($key >0 && $key2 == 5):?>
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
            <h3 class="sum-tit">热门玩法</h3> 
            <ul class="hr-sum-cons">
                <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-AU_f-3541" target="_blank">◆ 澳洲东海岸：经典玩法&nbsp;<img class="ml5" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/hot.gif'?>"></a></li>
                <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-autas" target="_blank">◆ 塔斯马尼亚：小新西兰&nbsp;<img class="ml5" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/hot.gif'?>"></a></li>
                <li><a href="<?= Yii::$app->params['service']['www']?>/theme/travelguide_adelaide_kangarooisland" target="_blank">◆ 阿德莱德：南澳旅游局推荐路线&nbsp;<img class="ml5" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/new.gif'?>"></a></li>
                <li><a href="<?= Yii::$app->params['service']['www']?>/theme/ayers_rock_uluru_resort" target="_blank">◆ 乌鲁鲁：在世界中心呼唤爱</a></li>
                <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-AUS_c-PER" target="_blank">◆ 西澳：少女粉红湖探秘</a></li>
                <li><a href="<?= Yii::$app->params['service']['www']?>/activity/entry/region-AUS_sc-317" target="_blank">◆ 大堡礁：此生一定要去看一次&nbsp;<img class="ml5" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/hot.gif'?>"></a></li>
                <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-AU_f-3857" target="_blank">◆ 北美华人澳洲游热销榜&nbsp;<img class="ml5" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/hot.gif'?>"></a></li>
                <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-AU_f-3885" target="_blank">◆ 最受澳洲当地人喜爱的路线</a></li>
                <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-AUS_f-4032" target="_blank">◆ 第一次游澳新必玩线路</a></li>
            </ul>
            <h3 class="sum-tit">攻略</h3>
            <ul class="hr-sum-cons clearfix">
                <li><a href="http://article.lulutrip.com/view/id-3239" target="_blank">◆ 澳洲旅游签证申请攻略</a></li>
                <li><a href="http://article.lulutrip.com/view/id-11188" target="_blank">◆ 澳洲自由行线路推荐</a></li>
                <li><a href="http://article.lulutrip.com/view/id-10237" target="_blank">◆ 教你轻松搞定澳大利亚退税！</a></li>
            </ul>
        </div>
    </div>
</div>
<?php endif;?>