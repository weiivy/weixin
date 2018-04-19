<?php if(!empty($destinations)):?>
    <div class="small-group" id="small-group">
        <div class="wrap">
            <?php if($regionRoot == 'NA'):?>
                <h2 class="sg-tit"><span>独具匠心 </span>路路小众</h2>
            <?php elseif($regionRoot == 'EU'):?>
                <h2 class="sg-tit">新奇<span>目的地</span></h2>
            <?php endif;?>
            <ul>
                <?php foreach($destinations as $index => $value):?>
                <li>
                    <a <?php if($index == 0): ?>class="current"<?php endif;?> href="<?=$value['pagecontsurl']?>" target="_blank" style="background: url(<?=Yii::$app->helper->getImgDomain() . '/' . $value['pagecontsstag'][0]?>) center top no-repeat;">
                    <span class="day"><?=$value['pagecontsimg']?>天</span>
                    <div class="long">
                        <h3><?=$value['pagecontstitle']?></h3>
                        <p><?=nl2br($value['pagecontstag'])?></p>
                    </div>
                    <div class="short">
                        <h3><?=$value['pagecontsstitle']?></h3>
                        <p><?=nl2br($value['pagecontstab'])?></p>
                    </div>
                    <span class="comm-btn1">即刻启程</span>
                    </a>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
<?php endif; ?>