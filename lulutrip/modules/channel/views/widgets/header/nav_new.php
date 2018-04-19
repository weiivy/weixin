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
            ?>旅游&nbsp;全部目的地</span>
            <?= $ChannelSubNavPlate; ?>
        </div>
        <?=$MainNavigationPlate ?>
        <div class="tel-area">
            <div class="tel-dd">
                    <span>
                        <i class="icon-all"></i>
                        <span id="sidebar-callNum"><?= \Yii::$app->helper->getCustomerServicePhone();?></span>
                    </span>

                <div class="tel-list">
                    <h2 class="rhr t-bt">全球 7x24小时客服电话</h2>
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
