<?php if(!empty($monthRec)):?>
<div class="month-rec">
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
                        <a href="<?= Yii::$app->params['service']['www']?><?=$value['product']['link'] ?>" target="_blank" class="clearfix">
                            <div class="img">
                                    <b></b>
                                    <img class="<?php if($key == 0): ?>lazy<?php else: ?>lazy-hide<?php endif; ?>" src="//s01.quimg.com/images/preload_l.gif" data-original="<?= $value['product']['tf_cover'] ?>" alt="<?=$value['product']['tourtitle_cn'] ?>" />
                            </div>
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
                                    <div class="pro-way pro-d clearfix">
                                        <span class="pro-d-name">
                                            行程：
                                        </span>
                                        <p><?=$value['pagecontsstitle'] ?></p>
                                    </div>
                                    <div class="pro-sum pro-d clearfix">
                                        <span class="pro-d-name">
                                            新发现：
                                        </span>
                                        <p><?=$value['desc'] ?></p>
                                    </div>
                                    <div class="pro-data pro-d clearfix">
                                        <span class="pro-d-name">
                                            出发日期：
                                        </span>
                                        <b><?=$value['seasondates'] ?></b>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>