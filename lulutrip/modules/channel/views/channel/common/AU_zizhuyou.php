<!-- 新西兰旅游 -->
<?php if(!empty($pagecontsProductDiy)):?>
    <?php
    $tabs = array_column($pagecontsProductDiy, 'pagecontstab');
    $pagecontstag = array_column($pagecontsProductDiy, 'pagecontstag');
    $pagecontsurl = array_column($pagecontsProductDiy, 'pagecontsurl');
    ?>
<div class="hot-rec clearfix hot-rec-au-tour">
    <div class="wrap hot-rec-wrap clearfix" id="hot-rec-wrap2">
        <h2 class="hr-tit">新西兰<span>旅游</span></h2>
        <ul class="hr-sel tab-menu">
            <?php foreach($tabs as $key => $tab):?>
                <li class="ls-sel-li <?php if($key == 0):?>current<?php endif;?>"><?=$tab?> <span></span></li>
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
            <h3 class="sum-tit" style="margin-bottom: 10px;">热门玩法</h3> 
            <ul class="hr-sum-cons" style="margin-bottom: 20px;">
                <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-nzsouth" target="_blank">◆ 新西兰南岛: 自然风光最佳&nbsp;<img class="ml5" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/hot.gif'?>"></a></li>
                <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-nznorth" target="_blank">◆ 新西兰北岛：文化与地热&nbsp;<img class="ml5" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/hot.gif'?>"></a></li>
                <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-NZ_f-3557" target="_blank">◆ 南北岛全览：深度畅游</a></li>
                <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-NZ_f-3559" target="_blank">◆ 澳新连线：2个国家一起玩</a></li>
                <li><a href="<?= Yii::$app->params['service']['www']?>/activity/entry/region-AU_s-1303" target="_blank">◆ 新西兰皇后镇：必体验项目</a></li>
                <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-NZ_f-3855" target="_blank">◆ 北美华人最爱新西兰路线&nbsp;<img class="ml5" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/hot.gif'?>"></a></li>
                <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-NZ_f-3865" target="_blank">◆ 新西兰热销产品top排行榜</a></li>
                <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/region-AU_f-5750" target="_blank">◆ 逃离雾霾天，100%纯净新西兰&nbsp;<img class="ml5" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/new.gif'?>"></a></li>
                <li><a href="<?= Yii::$app->params['service']['www']?>/activity/entry/region-NZ_cat-tag1845" target="_blank">◆ 新西兰热门户外极限运动项目</a></li>
            </ul>
            <h3 class="sum-tit" style="margin-bottom: 10px;">攻略</h3>
            <ul class="hr-sum-cons clearfix">
                <li><a href="http://article.lulutrip.com/view/id-10183" target="_blank">◆ 新西兰签证攻略</a></li>
                <li><a href="http://article.lulutrip.com/view/id-4006" target="_blank">◆ 南岛PK北岛，哪一个更好玩</a></li>
                <li><a href="http://article.lulutrip.com/view/id-10039" target="_blank">◆ 新西兰最纯净风景，南岛必去景点指南</a></li>
                <li><a href="http://article.lulutrip.com/view/id-7665" target="_blank">◆ 新西兰购物攻略，买什么最划算!</a></li>
            </ul>
        </div>
    </div>
</div>
<?php endif;?>