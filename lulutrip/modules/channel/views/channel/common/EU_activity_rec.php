<?php if(!empty($activityRec)):?>
<div class="hot-rec clearfix hot-rec-eu-activity">
    <div class="hot-rec-wrap wrap clearfix" id="hot-rec-wrap">
        <h2 class="hr-tit">自助游<span>精选目的地</span></h2>
        <ul class="hr-sel tab-menu">
            <?php foreach($activityRec['tabs'] as $index => $tab):?>
            <li class="ls-sel-li <?php if($index == '0'):?> current<?php endif; ?>"><?=$tab ?>
                <?php if($index == 2 || $index == 5): ?><div class="hot"></div><?php endif; ?>
            </li>
            <?php endforeach;?>
        </ul>
        <div class="hr-con tab-box">
            <?php foreach($activityRec['contents'] as $key => $products):?>
            <div class="hr-con-ul show <?php if($key!= 0):?>hide<?php endif;?>">
                <?php foreach($products as $product):?>
                <li>
                    <div class="img">
                        <a href="<?=Yii::$app->params['service']['www']?><?=$product['link'] ?>" target="_blank"><q></q><img class="<?php if($key == 0): ?>lazy<?php else: ?>lazy-hide<?php endif; ?>" src="//s01.quimg.com/images/preload_l.gif" data-original="<?= $product['tf_cover'] ?>" alt="<?php echo htmlspecialchars_decode($product['tourtitle_cn']) ?>"/></a>
                        <?php if(!empty($product['grp_discount'])):?>
                            <span class="eu-act-sale"><?php echo (100 - $product['grp_discount'])*0.1 ?>折</span>
                        <?php endif;?>
                    </div>
                    <div class="img-bottom">
                        <p><a href="<?=Yii::$app->params['service']['www']?><?=$product['link'] ?>" target="_blank"><?= \yii\helpers\Html::decode($product['tourtitle_cn']) ?></a></p>
                        <div class="eu-act-icon"><?=$product['title'] ?></div>
                        <?php if(!empty($product['hotReason'])): ?>
                        <div class="eu-act-sum" style="height: 36px;overflow: hidden;">
                            <a href="<?=Yii::$app->params['service']['www']?><?=$product['link'] ?>" target="_blank">必去理由：<b><?= \yii\helpers\Html::decode($product['hotReason']); ?></b></a>
                        </div>
                        <?php endif; ?>
                        <span><i><?= Yii::$app->params['curCurrencies']['sign']?></i> <?= $product['prices']['min'][Yii::$app->params['curCurrency']]?></span>
                    </div>
                </li>
                <?php endforeach;?>
                <div class="clearfix"></div>
                <a href="<?=$activityRec['urls'][$key] ?>" target="_blank" class="eu-act-show-more">查看更多<?= $activityRec['tabs'][$key] ?>自由行&nbsp;></a>
            </div>
            <?php endforeach;?>
        </div>
        <div class="clearfix"></div>
        <div class="hr-eu-act-bot clearfix" style="margin-top: 50px;">
            <div class="bot-left">
                <h4>行前必备</h4>
                <p>出&nbsp;行&nbsp;无&nbsp;忧</p>
            </div>
            <div class="bot-right clearfix">
                <a href="<?= Yii::$app->params['service']['www']?>/traffic/entry/region-EU_cat-tag1711" target="_blank">
                    <span class="a-icon a-icon-1"></span>
                    <p>接送机</p>
                </a>
                <a href="<?= Yii::$app->params['service']['www']?>/activity/entry/region-EU_cat-tag1785" target="_blank">
                    <span class="a-icon a-icon-3"></span>
                    <p>一日游</p>
                </a>
                <a href="<?= Yii::$app->params['service']['www']?>/visa-search/ct-p30097" target="_blank">
                    <span class="a-icon a-icon-4"></span>
                    <p>旅游签证</p>
                </a>
                <a href="<?= Yii::$app->params['service']['www']?>/hotel" target="_blank">
                    <span class="a-icon a-icon-6"></span>
                    <p>酒店</p>
                </a>
                <a href="http://lulutrip.eurail.com/cn" target="_blank">
                    <span class="a-icon a-icon-7"></span>
                    <p>欧铁</p>
                </a>
                <a href="https://diy.lulutrip.com/insurance" target="_blank">
                    <span class="a-icon a-icon-8"></span>
                    <p>保险</p>
                </a>
                <a href="<?= Yii::$app->params['service']['www']?>/tickets/entry/region-EU" target="_blank">
                    <span class="a-icon a-icon-2"></span>
                    <p>门票</p>
                </a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>