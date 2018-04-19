<?php $joinType = array(1 => '接机参团', 2 => '上车点参团', 3 => '酒店参团'); ?>
<?php if(!empty($products)):?>
    <?php foreach($products as $key => $value):?>
        <div class="product-list <?= $value['sellOut'] == 1 ? 'product-sellout' : '' ?>">
            <a href="<?= Yii::$app->params['service']['www'] . $value['link']?>" target="_blank">
                <?php if($value['is_tui'] == 1 && $key < 3):?><span class="recommend"><i class="icon-style"></i></span><?php endif;?>
                <div class="img">
                    <img class="lazy" data-original="<?= $value['image'];?>" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/preload_l.gif'?>" width="360" height="240">
                    <?php if(!empty($value['discount'])):?>
                        <span class="discount <?php if(isset($value['discountActivity']) && !empty($value['discountActivity'])):?>J-tagtips<?php endif;?>" <?php if(isset($value['discountActivity']) && !empty($value['discountActivity'])):?>data-group="<p class='tit'><strong><?=$value['discountActivity']['title']?></strong></p><?=$value['discountActivity']['description']?>"<?php endif;?>><b><?= $value['discount']?>%</b>OFF</span>
                    <?php elseif(isset($value['tags']['tagSale'])): $tagSaleDiscount = array_filter(array_column($value['tags']['tagSale'], 'discountRate'));  $tagSaleDiscount = empty($tagSaleDiscount) ? 0 : min($tagSaleDiscount)?>
                        <?php if($tagSaleDiscount > 0):?><span class="discount"><b><?= (10-$tagSaleDiscount) * 10?>%</b>OFF</span><?php endif;?>
                    <?php endif;?>

                    <!--亲友小团标签-->
                    <?php if(isset($value['subChildType']) && !empty($value['subChildType'])):?>
                        <span class="privatetourcode <?php if($value['subChildType'] == 1):?>private-qy<?php elseif($value['subChildType'] == 2):?>private-gd<?php elseif($value['subChildType'] == 3):?>private-zj <?php endif;?>"></span>
                    <?php endif;?>
                    <?php if(isset($value['subChildType']) && $value['subChildType'] > 10): ?>
                        <span class="type-cover cover-<?=($value['subChildType']-10)?>"></span>
                    <?php endif; ?>
                    <span class="tourcode">产品编号：<?= $value['productKey']?></span>
                    <?php if(!empty($value['auroraScore'])): ?>
                    <span class="aurora">极光分数：<?=$value['auroraScore'] ?></span>
                    <?php endif; ?>
                    <!--3个产品才会显示路路行推荐的样式-->
                    <?php if($value['sellOut'] == 1): ?><span class="sellout"><i class="icon-style"></i></span><?php endif;?>
                </div>
                <div class="text">
                    <div class="point">
                        <span><i class="icon-setout"></i>出发地：<?= $value['startCity']?></span>
                        <?php if(!empty($value['endCity'])):?><span>离团地：<?= $value['endCity']?></span><?php endif;?>
                        <span>行程：<?= $value['duration']?>天</span>
                        <?php if(!empty($value['commentCount'])):?><span><i class="icon-comment"></i><?= $value['commentCount']?>人点评</span><?php endif;?>
                    </div>
                    <h2 title="<?= $value['title']?>"><?= $value['title']?></h2>
                    <?php if(!empty($value['tags']) || isset($value['activityTags'])):?>
                        <ul class="tag-list">
                            <!--   图片类   -->
                            <?php if(!empty($value['tags']['tagIcon'])):?>
                            <?php foreach($value['tags']['tagIcon'] as $tag):?>
                            <li class="<?= !empty($tag['descCN']) ? 'J-tagtips' : ''?> J-tagtips-icon" data-key="addit" data-group="<?= $tag['descCN']?>"><img src='<?= Yii::$app->helper->getImgDomain() . '/' . $tag['icon']?>' height="22"></li>
                            <?php endforeach;?>
                            <?php endif;?>
                            <!--   优惠类   -->
                            <?php if(isset($value['activityTags']) && isset($value['activityTags']['afterDiscount'])):?>
                                <?php foreach($value['activityTags']['afterDiscount'] as $afterDiscount):?>
                                <li  class=" tag-red <?= !empty($afterDiscount['discounts']) ? 'J-tagtips' : ''?> " data-key="addit" data-group="<p class='J-line'><em>活动期限：</em><?=$afterDiscount['activity']['time']?></p>
                                <?php foreach($afterDiscount['discounts'] as $discount):?>
                                    <p><em>活动力度：</em><?=$discount['strength']?></p>
                                    <p><em>使用方法：</em><?=$discount['instructions']?></p>
                                    <?php if(isset($discount['useLimit'])):?><p><em>参与条件：</em><?=$discount['useLimit']?></p><?php endif;?>
                                <?php endforeach;?>"><?= $afterDiscount['activity']['title']?></li>
                                <?php endforeach;?>
                            <?php endif;?>

                            <?php if(isset($value['activityTags']) && isset($value['activityTags']['typeDiscount'])):?>
                                <?php foreach($value['activityTags']['typeDiscount'] as $typeDiscount):?>
                                    <li  class=" tag-red <?= !empty($typeDiscount['discounts']) ? 'J-tagtips' : ''?> " data-key="addit" data-group="<p class='J-line'><em>活动期限：</em><?=$typeDiscount['activity']['time']?></p>
                                <?php foreach($typeDiscount['discounts'] as $discount):?>
                                    <p><em>活动力度：</em><?=$discount['strength']?></p>
                                    <p><em>使用方法：</em><?=$discount['instructions']?></p>
                                    <?php if(isset($discount['useLimit'])):?><p><em>参与条件：</em><?=$discount['useLimit']?></p><?php endif;?>
                                <?php endforeach;?>"><?= $typeDiscount['activity']['title']?></li>
                                <?php endforeach;?>
                            <?php endif;?>

                            <?php if(isset($value['activityTags']) && isset($value['activityTags']['typeReduce'])):?>
                                <?php foreach($value['activityTags']['typeReduce'] as $typeReduce):?>
                                    <li  class=" tag-red <?= !empty($typeReduce['discounts']) ? 'J-tagtips' : ''?> " data-key="addit" data-group="<p class='J-line'><em>活动期限：</em><?=$typeReduce['activity']['time']?></p>
                                <?php foreach($typeReduce['discounts'] as $discount):?>
                                    <p><em>活动力度：</em><?=$discount['strength']?></p>
                                    <p><em>使用方法：</em><?=$discount['instructions']?></p>
                                    <?php if(isset($discount['useLimit'])):?><p><em>参与条件：</em><?=$discount['useLimit']?></p><?php endif;?>
                                <?php endforeach;?>"><?= $typeReduce['activity']['title']?></li>
                                <?php endforeach;?>
                            <?php endif;?>


                            <?php if(!empty($value['tags']['tagSale'])):?>
                                <?php foreach($value['tags']['tagSale'] as $tag):?>
                                    <li data-id="<?=$tag['id']?>" data-href="<?php $tPrms = $params; $tPrms['saleact'] = $tag['id']; echo $dealMenusObj->mergeUrl($tPrms)?>" class=" tag-red <?= !empty($tag['descCN']) ? 'J-tagtips' : ''?> " data-key="addit" data-group="<div class='text'><?= $tag['descCN']?></div>"><?= $tag['nameCN']?></li>
                                <?php endforeach;?>
                            <?php endif;?>

                            <!-- 附加服务类 -->
                            <?php if(!empty($value['tags']['tagService'])):?>
                                <?php foreach($value['tags']['tagService'] as $tag):?>
                                    <li data-href="<?php $tPrms = $params; $tPrms['service'] = 2; echo $dealMenusObj->mergeUrl($tPrms)?>" class="tag-blue  J-tagtips" data-key="addit" data-group="<div class='text'><?= $tag['descCN']?></div>"><?= $tag['nameCN']?></li>
                                <?php endforeach;?>
                            <?php endif;?>

                            <!--  特色类   -->
                            <?php if(!empty($value['tags']['tagFeature'])):?>
                                <?php foreach($value['tags']['tagFeature'] as $tag):?>
                                     <li data-href="<?php $tPrms = $params; $tPrms['features'] = $tag['id']; echo $dealMenusObj->mergeUrl($tPrms)?>" class="<?= !empty($tag['descCN']) ? 'J-tagtips' : ''?> " data-key="addit" data-group="<div class='text'><?= $tag['descCN']?></div>"><?= $tag['nameCN']?></li>
                                <?php endforeach;?>
                            <?php endif;?>


                        </ul>
                    <?php endif;?>
                    <div class="feat" title="<?= $value['feature']?>"><?= nl2br($value['feature'])?></div>
                    <div class="pricebox">
                        <div class="check-date">
                            <span><?= $joinType[$value['joinType']]?> - </span>
                            <span class="date"><?= $value['tourDate']?></span>
                        </div>
                        <div class="price">
                            <?php if($value['marketPrice'] > $value['price']):?>
                                <del><?= Yii::$app->params['curCurrencies']['sign']?><span><?= ceil($value['marketPrice'])?></span></del>
                            <?php endif;?>
                            <strong><?php if(isset($value['discountActivity']) && !empty($value['discountActivity'])):?>折后价<?php endif;?><?= Yii::$app->params['curCurrencies']['sign']?><span><?= ceil($value['price'])?></span></strong>起
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php if($key == 0 && $currentPage == 1 && (!empty($firstAds))):?>
        <div class="product-ad" style="height:90px;">
            <div class="ad-list" id="productadWrapper">
                <ul>
                    <?php foreach($firstAds as $value):?>
                        <li><a <?php if(!empty($value['link'])): ?> href="<?= $value['link']?>" target="_blank"<?php else: ?> href="javascript:volid(0);" <?php endif; ?>><img width="930" height="90" src="<?= Yii::$app->helper->getImgDomain() ?>/<?= $value['pic']?>" ></a></li>
                    <?php endforeach;?>
                </ul>
            </div>
            <div class="ctrl-btn" id="ctrlBtn">
                <?php foreach($firstAds as $key => $value):?>
                    <span <?php if($key == 0):?>class="on"<?php endif;?>></span>
                <?php endforeach;?>
            </div>
        </div>
        <?php endif;?>
    <?php endforeach;?>
<?php else:?>
<div class="product-error">
  <p>啊哦，没有找到符合条件的结果，请<a href="javascript:history.back(-1);">返回</a>后再试！</p>
</div>
<?php endif;?>
