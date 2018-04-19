<!-- 头部导航 -->
<div id="header-menu" class="header-menu">
    <?php if(!empty($navigationtype)):?>
    <div class="header-menu-inner clearfix">
        <div class="hm-left<?php if(Yii::$app->controller->id != 'channel'):?> J-hmLeft hide-sn<?php endif;?>">
        <span class="hm-left-title"><?php
            if($navigationtype == 'NA'){
                echo "美加";
            } elseif($navigationtype == 'EU') {
                echo "欧洲";
            } elseif($navigationtype == 'AU') {
                echo "澳新";
            }
            $barIndex = 1;
            ?>旅游&nbsp;全部目的地</span>
            <div class="hm-left-bar<?php if(Yii::$app->controller->id != 'channel'):?> hide J-hmLeftBar<?php endif;?>">
                <?php foreach($topHover['categoryNav'][$navigationtype] as $keyName => $regionArr): ?>
                    <div class="hm-bar-item hm-bar-<?= $barIndex ?> ">
                        <?php $barIndex++;?>
                        <div class="hm-item-sub hm-item-sub-<?= strtolower($navigationtype)?>" <?php if($keyName == '异域探奇'): ?>style="min-width: 540px;"<?php endif;?> <?php if($keyName == '北美定制'): ?>style="min-width: 600px;"<?php endif;?>>

                            <!-- 美洲start -->
                            <?php if(in_array($keyName, ['美国', '加拿大'])) {?>
                                <?= Yii::$app->view->renderFile('@channelModule/views/widgets/header/nav_am1.php', ['regionArr' => $regionArr, 'keyName' => $keyName]);?>

                            <?php }elseif($keyName == '异域探奇') {?>
                                <?= Yii::$app->view->renderFile('@channelModule/views/widgets/header/nav_am3.php', ['regionArr' => $regionArr, 'keyName' => $keyName]);?>

                            <?php }elseif($keyName == '北美定制') {?>
                                <?= Yii::$app->view->renderFile('@channelModule/views/widgets/header/nav_am2.php', ['regionArr' => $regionArr, 'keyName' => $keyName]);?>

                            <?php } ?>
                            <!-- 美洲end -->

                            <?php if($keyName == '欧洲定制') {?>
                                <?= Yii::$app->view->renderFile('@channelModule/views/widgets/header/nav_eu5.php', ['regionArr' => $regionArr, 'keyName' => $keyName]);?>
                            <?php }elseif($keyName == '西欧') {?>
                                <?= Yii::$app->view->renderFile('@channelModule/views/widgets/header/nav_eu1.php', ['regionArr' => $regionArr, 'keyName' => $keyName]);?>
                            <?php }elseif($keyName == '南欧') {?>
                                <?= Yii::$app->view->renderFile('@channelModule/views/widgets/header/nav_eu2.php', ['regionArr' => $regionArr, 'keyName' => $keyName]);?>
                            <?php }elseif($keyName == '中东欧') {?>
                                <?= Yii::$app->view->renderFile('@channelModule/views/widgets/header/nav_eu3.php', ['regionArr' => $regionArr, 'keyName' => $keyName]);?>
                            <?php }elseif($keyName == '北欧') {?>
                                <?= Yii::$app->view->renderFile('@channelModule/views/widgets/header/nav_eu4.php', ['regionArr' => $regionArr, 'keyName' => $keyName]);?>
                            <?php }elseif($keyName == '澳大利亚') {?>
                                <?= Yii::$app->view->renderFile('@channelModule/views/widgets/header/nav_au1.php', ['regionArr' => $regionArr, 'keyName' => $keyName]);?>
                            <?php }elseif($keyName == '新西兰') {?>
                                <?= Yii::$app->view->renderFile('@channelModule/views/widgets/header/nav_au2.php', ['regionArr' => $regionArr, 'keyName' => $keyName]);?>
                            <?php }elseif($keyName == '澳新定制') {?>
                                <?= Yii::$app->view->renderFile('@channelModule/views/widgets/header/nav_au5.php', ['regionArr' => $regionArr, 'keyName' => $keyName]);?>
                            <?php }elseif($keyName == '自由行') {?>
                                <?= Yii::$app->view->renderFile('@channelModule/views/widgets/header/nav_au3.php', ['regionArr' => $regionArr, 'keyName' => $keyName]);?>
                            <?php }elseif($keyName == '新奇之旅') {?>
                                <?= Yii::$app->view->renderFile('@channelModule/views/widgets/header/nav_au4.php', ['regionArr' => $regionArr, 'keyName' => $keyName]);?>
                            <?php } ?>

                            <?php if($regionArr['images']['url']): ?>
                                <a href="<?= Yii::$app->params['service']['www']?><?= $regionArr['images']['url']?>" target="_blank" class="hm-sub-banner">
                                    <img src="<?= Yii::$app->params['staticDomain'].$regionArr['images']['src']?>">
                                </a>
                            <?php endif;?>
                        </div>
                        <div class="hm-item-recommend hm-item-recommend-<?= strtolower($navigationtype)?>">
                            <?php if(!empty($regionArr['tag'])) { ?>
                                <a href="<?= Yii::$app->params['service']['www']?><?= $regionArr['tag']['url']?>" target="_blank" <?php if(!empty($regionArr['tag']['class'])):?>class="hm-recommend-tip"<?php endif;?>><?= $regionArr['tag']['name']?></a>
                            <?php } ?>
                            <div class="hm-name">
                                <?php if(!empty($regionArr['url'])) { ?>
                                    <a href="<?= Yii::$app->params['service']['www']?><?= $regionArr['url'] ?>" target="_blank" class=""><?= $keyName ?></a>
                                <?php } else { ?>
                                    <?= $keyName ?>
                                <?php } ?>
                            </div>

                            <div class="hm-recommend-list clearfix">
                                <?php foreach($regionArr['main'] as $recommendData): ?>
                                    <a href="<?= Yii::$app->params['service']['www']?><?= $recommendData['url']?>" target="_blank"  class="hm-rl-place <?php if(!empty($recommendData['class'])) {echo 'hot';}?>"><?= $recommendData['name']?></a>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
        <ul class="hm-right">
            <?= Yii::$app->view->renderFile('@channelModule/views/widgets/header/right.php', ['topHover' => $topHover, 'navigation' => $navigation, 'checkNavigationNum' => $checkNavigationNum, 'navigationtype' => $navigationtype]);?>
        </ul>
        <div class="tel-area">
            <div class="tel-dd">
                    <span>
                        <i class="icon-all"></i>
                        <span id="sidebar-callNum"><?= \Yii::$app->helper->getCustomerServicePhone();?></span>
                    </span>

                <div class="tel-list">
                    <div class="rhr t-bt">全球 7x24小时客服电话</div>
                    <?php $areacode = ['NA', 'CN', 'EU', 'AU'];?>
                    <?php foreach ($areacode as $code):?>
                    <div class="rhr">
                        <?php foreach ($tel as $value):?>
                        <?php if($value['code'] == $code):?>
                        <p class="tel-row">
                            <span class="t-a"><?= $value['areaname']?>: </span>
                            <span class="t-n"><?= $value['phone']?></span>
                        </p>
                        <?php endif;?>
                        <?php endforeach;;?>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
</div>
