<?php if(!empty($festivals)):?>
    <div class="travel-local">
        <div class="wrap">
            <h2 class="dest-tit">Travel as a Local<span>融入当地</span></h2>
            <div id="tl-tab" class="tab-container">
                <ul class="tl-sel tab-menu" id="tl-sel">
                    <?php foreach($festivals['tabs'] as $index => $value):?>
                    <li <?php if($index == '0'):?>class="current"<?php endif; ?>><?=$value?></li>
                    <?php endforeach;?>
                </ul>
                <div class="tab-box">
                    <?php foreach($festivals['contents'] as $index => $value):?>
                    <div class="show <?php if($index !== 0):?>hide<?php endif;?>">
                        <div class="product">
                            <a class="big-a" href="<?=$value['pagecontsurl']?>" target="_blank"><img class="lazy" data-original="<?= Yii::$app->helper->getImgDomain() . '/' . $value['pagecontsimg'] ?>" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/preload_l.gif'?>" width="954" height="268"></a>
                            <ul class="dest-right">
                                <?php foreach($value['pagecontsstag'] as $product):?>
                                <li>
                                    <div class="img">
                                        <a href="<?php if(in_array($product['type'], array('act', 'tour'))){echo $product['link']; }elseif($product['type'] == 'packagetours'){echo '/privatetour/view-' . $product['packid']; }?>" target="_blank"><img class="lazy" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/preload_l.gif'?>" data-original="<?= Yii::$app->helper->getImgDomain() . '/' . $product['tf_cover'] ?>" alt="<?php if(in_array($product['type'], array('act', 'tour'))){echo $product['tourtitle_cn'];}elseif($product['type'] == 'packagetours'){ echo $product['packmaintitle_cn'];}?>"></a>
                                        <span class="tip"><?php if($product['type'] == 'tour'){ echo '当地参团'; }elseif($product['type'] == 'act'){echo '自由行'; }elseif($product['type'] == 'packagetours'){echo '一键包团'; } ?></span>
                                    </div>
                                    <div class="img-bottom">
                                        <p><a href="<?php if(in_array($product['type'], array('act', 'tour'))){ echo $product['link'];}elseif($product['type'] == 'packagetours'){ echo '/privatetour/view-' . $product['packid']; }?>" target="_blank"><?php if(in_array($product['type'], array('act', 'tour'))){ echo $product['tourtitle_cn']; }elseif($product['type'] == 'packagetours'){ echo $product['packmaintitle_cn']; }?></a></p>
                                        <span><i><?= Yii::$app->params['curCurrencies']['sign']?></i> <?=$product['prices']['min'][Yii::$app->params['curCurrency']]?></span>
                                    </div>
                                </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                        <div class="introduce">
                            <h3><?=$value['pagecontstitle']?></h3>
                            <p><?php echo nl2br($value['pagecontstag'])?></p>
                            <a href="<?= $value['pagecontsurl']?>" target="_blank" class="comm-btn2">去看看</a>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>