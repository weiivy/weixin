<?php if(!empty($hotDestinations)):?>
    <div class="gloable-hot">
        <div class="wrap">
            <h2 class="gh-title">全球热门Top10目的地<span></span></h2>
            <div class="gh-list">
                <?php if(count($hotDestinations) > 5):?>
                <a href="javascript:;" class="gt-left-go J-go"></a>
                <a href="javascript:;" class="gt-right-go J-go"></a>
                <?php endif;?>
                <div class="gh-pro-list">
                    <ul id="gh-hot-ul">
                        <?php foreach ($hotDestinations as $key => $hot):?>
                        <li>
                            <a href="<?= $hot['pagecontsurl']?>" target="_blank">
                                <img  class="<?php if($key < 6):?>lazy<?php else:?>lazy-hide<?php endif;?>" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/preload_l.gif'?>" data-original="<?= Yii::$app->helper->getImgDomain() . '/' . $hot['pagecontsimg']?>" width="224" height="298">
                                <h3><?= $hot['pagecontstab']?></h3>
                                <span class="num">NO.<?= $key + 1?></span>
                                <div>
                                    <h4><?= $hot['pagecontstitle']?></h4>
                                    <span class="line"></span>
                                    <p><?= nl2br($hot['pagecontstag'])?></p>
                                    <span class="more">更多</span>
                                </div>
                            </a>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>