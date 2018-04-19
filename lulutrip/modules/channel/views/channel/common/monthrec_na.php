<?php if (!empty($monthRec)):?>
<div class="weekly-rec">
    <div class="wrap">
        <h2 class="dest-tit">本月赞品<span>Never Stop Exploring</span></h2>
        <div id="mr-tab" class="mr-container">
            <ul class="tab-menu mr-sel" id="mr-sel">
                <?php foreach($monthRec['tabs'] as $index => $tab):?>
                    <li <?php if($index == '0'):?>class="current"<?php endif; ?>><?=$tab?><b></b></li>
                <?php endforeach;?>
            </ul>
            <div class="tab-box">
                <?php foreach($monthRec['contents'] as $key => $value):?>
                <div class="show <?php if($key !== 0):?>hide<?php endif;?>">
                    <div class="product">
                        <a href="<?= Yii::$app->params['service']['www']?><?=$value['product']['link'] ?>" target="_blank">
                            <div class="pro-sums">
                                <div class="pro-days">
                                    <span class="<?php if((int)$value['product']['tourlen'] < 10): ?>big<?php else: ?>middle<?php endif; ?>"><?=$value['product']['tourlen'] ?></span><span>天</span>
                                </div>
                                <div class="pro-tit"><?=$value['pagecontstitle'] ?></div>
                                <div class="pro-tips">
                                    <?php foreach($value['tags'] as $tag):?>
                                        <span class="pro-tip"><?=$tag ?></span>
                                    <?php endforeach;?>
                                </div>
                                <div class="pro-detail">
                                    <div class="pro-sum">
                                        <p><?=$value['desc'] ?></p>
                                    </div>
                                    <div class="pro-data pro-d clearfix">
                                        <span class="pro-d-name">
                                            出发日期：
                                        </span>
                                        <b><?=$value['seasondates'] ?></b>
                                    </div>
                                </div>
                                <div class="pro-money">
                                    <span class="pro-price"><?= Yii::$app->params['curCurrencies']['sign']?><?= $value['product']['prices']['min'][Yii::$app->params['curCurrency']]?></span><span class="pro-word">起</span>
                                </div>
                                <div class="pro-buy">
                                    查看详情
                                </div>
                            </div>
                            <div class="img">
                                <b></b>
                                <img class="<?php if($key == 0): ?>lazy<?php else: ?>lazy-hide<?php endif; ?>" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/preload_l.gif'?>" data-original="<?= $value['product']['tf_cover'] ?>" alt="<?=$value['product']['tourtitle_cn'] ?>" style="display: inline;width:430px;height: 300px;">
                            </div>
                        </a>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
