<?php if(!empty($articles)):?>
    <div class="strategy <?php if (Yii::$app->controller->regionRoot == 'EU'):?>strategy-eu<?php endif;?>">
        <div class="wrap">
            <h2 class="dest-tit">
                <?php if (Yii::$app->controller->regionRoot  == 'NA'):?>
                    <span>美洲旅游</span>精选攻略
                <?php elseif (Yii::$app->controller->regionRoot == 'EU'):?>
                    <span>路路行带你了解</span> 更当地的欧洲
                <?php elseif (Yii::$app->controller->regionRoot == 'AU'):?>
                    <span>澳新旅游</span>精选攻略
                <?php endif;?>
            </h2>
            <?php if (Yii::$app->controller->regionRoot  == 'EU'):?>
                <p class="under-tit">路路行独家出品，欧洲最深度，最当地的玩法介绍，本本干货！</p>
            <?php endif;?>
            <ul>
                <?php foreach($articles as $value):?>
                    <li>
                        <a href="<?= Yii::$app->params['service']['article']?><?= $value['link'] ?>" target="_blank">
                            <img class="lazy" data-original="<?= Yii::$app->helper->getImgDomain() . '/' . $value['article_image'] ?>" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/preload_l.gif'?>" width="384" height="256" >
                            <b><?= nl2br($value['article_img_title'])?></b>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
<?php endif;?>