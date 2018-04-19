<?php foreach($navigation as $key => $value): ?>

    <li id="tip<?= $key ?>Btn">
        <a href="<?php if(empty($value['url'])) { ?>javascript:;<?php }else{ echo $value['url']; } ?>" class="a-li <?php if( $value['tag'] == $checkNavigationNum && $key != 0) { echo 'active';}?>">
            <?= $value['title']?>
            <?php if(($navigationtype == 'NA' && $value['title'] == '海外定制') || ($navigationtype == 'NA' && $value['title'] == '租车') || ($navigationtype == 'EU' && $value['title'] == '循环巴士')):?>
            <img src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/hot.gif'?>" class="icon-new" alt=""/>
            <?php endif;?>
        </a>
        <?php if(!empty($value['snavigation'])): ?>
            <div class="hide-area <?php if($value['title'] == '当地参团'){echo 'hide-special';}elseif($value['title'] == '酒店'){echo 'hide-hotel hide-normal';}elseif($value['title'] == '自由行'){echo 'hide-activity hide-normal';}else{echo 'hide-normal';}?> " id="tip<?= $key ?>">

        <?php if($value['title'] == '当地参团'){ ?>
            <?php foreach($topHover['tourNav'][$value['type']] as $states) { ?>
                <div class="hide-con <?php if($value['type'] == 'NA'){echo 'america';}elseif($value['type'] == 'AU'){echo 'aoxin';}?>">
                    <div class="con-part clearfix">
                        <div class="left"><a href="<?php if(empty($states[0]['url'])) {?>javascript:;<?php }else{echo Yii::$app->params['service']['www'].$states[0]['url'];}?>" target="_blank"><?= $states[0]['name']?></a></div>
                        <div class="right">
                            <?php foreach($states[1] as $item) { ?>
                                <a class="<?php if($item['class'] == 'red') {echo 'hot';}?>" href="<?php if(empty($item['url'])) {?>javascript:;<?php }else{echo Yii::$app->params['service']['www'].$item['url'];}?>" target="_blank" <?php if(Yii::$app->controller->regionRoot == 'AU') {?> style="width: 130px;"<?php } ?>><?= $item['name']?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php }elseif($value['title'] == '酒店') {?>
            <!-- 美洲酒店 -->
            <div class="hide-con <?php if($value['type'] == 'NA'){echo 'america';}elseif($value['type'] == 'EU'){echo 'europe';}elseif($value['type'] == 'AU'){echo 'aoxin';}?>">
                <?php foreach($topHover['hotelNav'][$value['type']] as $hotelKey => $countries) { ?>
                    <div class="con-part clearfix">
                        <div class="left"><b><?= $hotelKey?></b></div>
                        <?php if(!empty($countries)): ?>
                            <div class="right">
                                <?php foreach($countries as $arr) { ?>
                                    <a href="<?= $arr['url']?>" class="<?= $arr['class']?>" target="_blank"><?= $arr['name']?></a>
                                <?php } ?>
                            </div>
                        <?php endif;?>
                    </div>
                <?php } ?>
            </div>
        <?php }elseif($value['title'] == '自由行') {?>
            <?= Yii::$app->view->renderFile('@channelModule/views/widgets/header/eu_activity.php');?>
        <?php }else{ ?>
            <?php if(isset($value['snavigation'])):?>
                <div class="hide-con">
                    <?php foreach($value['snavigation'] as $value2) { ?>
                        <?php if(empty($value2['title'])) continue;?>
                        <a <?php if($value2['is_highlight'] == 1) {echo 'class="hot"';}?> href="<?= $value2['url']?>"><?= $value2['title']?></a>
                    <?php } ?>
                </div>
            <?php endif;?>
        <?php } ?>

       <!--数据库的snavigation-->
        <?php if($value['title'] == '当地参团') {?>
            <div class="hide-con">
                <div class="con-part clearfix">
                    <div class="left"><span>更多</span></div>
                    <div class="right">
                        <?php if(isset($value['snavigation'])): foreach($value['snavigation'] as $value2) { ?>
                            <a <?php if(isset($value2['is_highlight'])) {echo 'class="highlight"';}?> href="<?= $value2['url']?>"><?= $value2['title']?></a>
                        <?php } endif; ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php endif;?>
    </li>

<?php endforeach;?>
