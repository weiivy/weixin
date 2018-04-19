<?php if(!empty($recommendeds) && !empty($recommendeds['sceneInfos'])):?>
<!-- 热门推荐 -->
    <div class="hot-rec clearfix hot-rec-na-activity">
        <div class="wrap hot-rec-wrap clearfix" id="hot-rec-wrap">
            <h2 class="hr-tit">美洲自助游<span><b>热门推荐</b></span></h2>
            <ul class="hr-sel tab-menu">
                <?php $icon = array_column($recommendeds['sceneInfos'], 'icon'); foreach($recommendeds['tabs'] as $key => $sceneId):?>
                <li class="ls-sel-li <?php if($key == 0):?>current<?php endif;?>"><?= $sceneAll[$sceneId]?><span></span><img
                        src="<?=$icon[$key]?>" alt=""/></li>
                <?php endforeach;?>
            </ul>
            <div class="hr-con tab-box">
                <?php foreach($recommendeds['sceneInfos'] as $num => $value):?>
                    <div class="hr-con-ul <?php if($num != 0):?>hide<?php endif;?>">
                        <?php foreach($value['contents'] as $key => $product):?>
                            <li>
                                <div class="img">
                                    <a href="<?php if(isset($product['actid'])):?><?= Yii::$app->params['service']['www'] ?>/activity/view/id-<?= $product['actid'] ?>
                                        <?php elseif(isset($product['tourcode'])):?> <?= Yii::$app->params['service']['www'] . $product['link']?>
                                        <?php elseif(isset($product['star'])):?>
                                            <?= Yii::$app->params['service']['www'] ?>/hotel/booking/city-<?= $product['cityId'] ?>
                                            <?php if($product['star'] == 'star_3'): ?>?star=3
                                            <?php elseif($product['star'] == 'star_4'): ?>?star=4
                                            <?php elseif($product['star'] == 'star_5'): ?>?star=5
                                            <?php endif;?>
                                            &orderby=price
                                        <?php endif;?>" target="_blank">
                                        <q></q>
                                        <img class="<?php if($num == 0):?>lazy<?php else:?>lazy-hide<?php endif;?>" data-original="<?php if(isset($product['actid'])): ?><?= $product['af_cover'] ?><?php elseif(isset($product['tourcode'])): ?><?= $product['image']?><?php elseif(isset($product['star'])): ?><?= $product['cover'] ?><?php endif;?>" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/preload_l.gif'?>" alt="<?php if(isset($product['actid'])):?><?= $product['actname'] ?><?php elseif(isset($product['tourcode'])):?><?= $product['title']?><?php elseif(isset($product['star'])):?>
                                            <?= $sceneAll[$recommendeds['tabs'][$num]] ?>
                                            <?php if($product['star'] == 'star_3'): ?> 三星
                                            <?php elseif($product['star'] == 'star_4'): ?>四星
                                            <?php elseif($product['star'] == 'star_5'): ?>五星
                                            <?php endif;?>酒店
                                        <?php endif;?>"/></a>
                                    <span class="na-act-icon "><img src="<?=$value['icon']?>" alt=""/></span>

                                </div>
                                <div class="img-bottom">
                                    <p><a href="<?php if(isset($product['actid'])):?><?= Yii::$app->params['service']['www'] ?>/activity/view/id-<?= $product['actid'] ?>
                                         <?php elseif(isset($product['tourcode'])):?><?= Yii::$app->params['service']['www'] . $product['link']?>
                                        <?php elseif(isset($product['star'])):?>
                                            <?= Yii::$app->params['service']['www'] ?>/hotel/booking/city-<?= $product['cityId'] ?>
                                            <?php if($product['star'] == 'star_3'): ?>?star=3
                                            <?php elseif($product['star'] == 'star_4'): ?>?star=4
                                            <?php elseif($product['star'] == 'star_5'): ?>?star=5
                                            <?php endif;?>
                                            &orderby=price
                                        <?php endif;?>" target="_blank">
                                            <?php if(isset($product['actid'])):?><?= $product['actname'] ?>
                                            <?php elseif(isset($product['star'])):?>
                                                <?= $sceneAll[$recommendeds['tabs'][$num]] ?>
                                                <?php if($product['star'] == 'star_3'): ?> 三星
                                                <?php elseif($product['star'] == 'star_4'): ?>四星
                                                <?php elseif($product['star'] == 'star_5'): ?>五星
                                                <?php endif;?>酒店
                                                <?php elseif (isset($product['tourcode'])):?>
                                                <?= $product['title']?>
                                            <?php endif;?>
                                        </a></p>
                                    <span><i><?= Yii::$app->params['curCurrencies']['sign']?></i>
                                        <?php if(isset($product['actid'])): ?><?= $product['af_prices']['min'][Yii::$app->params['curCurrency']] ?>
                                        <?php elseif(isset($product['star'])): ?><?= $product['startprice'][Yii::$app->params['curCurrency']] ?>
                                            <?php elseif ($product['tourcode']): ?><?= $product['minprice']['min'][Yii::$app->params['curCurrency']]?>
                                        <?php endif;?>
                                        </span>
                                </div>
                            </li>
                        <?php endforeach;?>
                    </div>
                <?php endforeach;?>
            </div>
            <div class="clearfix"></div>
            <div class="hr-na-act-bot clearfix" style="margin-top: 40px;">
                <div class="bot-left">
                    <h4>行前必备</h4>
                    <p>出&nbsp;行&nbsp;无&nbsp;忧</p>
                </div>
                <div class="bot-right clearfix">
                    <a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-NA_d-1" target="_blank">
                        <span class="a-icon a-icon-1"></span>
                        <p>一日游</p>
                    </a>
                    <a href="<?= Yii::$app->params['service']['www']?>/activity/entry/region-NA" target="_blank">
                        <span class="a-icon a-icon-2"></span>
                        <p>门票</p>
                    </a>
                    <a href="<?= Yii::$app->params['service']['www']?>/themes/tickets" target="_blank">
                        <span class="a-icon a-icon-3"></span>
                        <p>秀票</p>
                    </a>
                    <a href="<?= Yii::$app->params['service']['www']?>/tickets/entry_cat-tag1701" target="_blank">
                        <span class="a-icon a-icon-4"></span>
                        <p>城市通票</p>
                    </a>
                    <a href="<?= Yii::$app->params['service']['www']?>/privatetour" target="_blank">
                        <span class="a-icon a-icon-5"></span>
                        <p>定制</p>
                    </a>
                    <a href="<?= Yii::$app->params['service']['www']?>/private/bus/region-NA" target="_blank">
                        <span class="a-icon a-icon-6"></span>
                        <p>包车</p>
                    </a>
                    <a href="<?= Yii::$app->params['service']['www']?>/rental-car/entry" target="_blank">
                        <span class="a-icon a-icon-7"></span>
                        <p>租车</p>
                    </a>
                    <a href="<?= Yii::$app->params['service']['diy']?>/transfer" target="_blank">
                        <span class="a-icon a-icon-8"></span>
                        <p>接送机</p>
                    </a>
                    <a href="<?= Yii::$app->params['service']['www']?>/hotel" target="_blank">
                        <span class="a-icon a-icon-9"></span>
                        <p>酒店</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>