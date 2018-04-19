<?php if($destinations): ?>
    <div class="destination-rec">
        <div class="wrap">
            <h2 class="dest-tit">小众产品<b>推荐</b></h2>
            <div id="dr-tab" class="tab-container">
                <ul class="tab-menu">
                    <?php foreach($destinations as $index => $value):?>
                       <li <?php if($index == '0'):?>class="current"<?php endif; ?>><?php echo $index+1; ?></li>
                    <?php endforeach;?>
                </ul>
                <div class="tab-box">
                    <?php foreach($destinations as $index => $value):?>
                        <div class="show <?php if($index != '0'){ echo 'hide'; }?>">
                            <div class="detail fr">
                                <a href="<?=$value['pagecontsurl']?>" target="_blank" class="tit"><?=$value['pagecontstitle']?></a>
                                <div class="desc">
                                    <a href="<?=$value['pagecontsurl']?>" target="_blank"><?=nl2br($value['pagecontstag'])?></a>
                                </div>
                                <div>
                                    <a href="<?=$value['pagecontsurl']?>" target="_blank" class="comm-btn1 comm-btn-lg">查看行程</a>
                                </div>
                            </div>
                            <div class="slider J-dr-slider">
                                <ul class="slides clearfix">
                                    <?php foreach($value['pagecontsstag'] as $pic):?>
                                        <li><a href="<?=$value['pagecontsurl']?>" target="_blank"><img class="lazy" data-original="<?= $pic?>" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/preload_l.gif'?>" width="670" height="378"></a></li>
                                    <?php endforeach;?>
                                </ul>
                                <ul class="controls">
                                    <li></li>
                                    <li></li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
