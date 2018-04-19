<?php if(Yii::$app->controller->regionRoot == 'EU' && date('Y-m-d') >= '2017-08-05' && date('Y-m-d') <= '2018-02-28'):?>
    <div id="topbanner">
        <div class="week-active" style="background: url(//llt.quimg.com/llt-static/images/home/europe/topNav0207.jpg) no-repeat center center;">
            <div class="week-close">
                <a href="javascript:;" id="topban-close" style="background: url(/images/channel_index/week_close.png) no-repeat;"></a>
            </div>
        </div>
    </div>
<?php endif;?>

<div id="topbar" class="topbar">
    <div class="topbar-inner clearfix">
        <!--品牌logo-->
        <div class="topbar-logo clearfix">
            <span class="logo-lulutrip">
              <i></i>
            </span>
            <a class="logo-woqu" href="http://www.woqu.com/" target="_blank">
              <i></i>
            </a>
            <a class="logo-globerouter" href="https://www.globerouter.com/" target="_blank">
              <i></i>
            </a>
        </div>
        <div class="topbar-list clearfix">
            <div class="tb-switch tb-app">
                <span class="arrow-down">路路行APP</span>
                <div class="tb-hover">
                    <i class="app-qrcode"></i>
                </div>
            </div>
            <div class="tb-switch tb-webapp">
                <span class="arrow-down">小程序</span>
                <div class="tb-hover">
                    <i class="weapp-qrcode"></i>
                </div>
            </div>
            <div class="tb-switch tb-currency">
                <span class="arrow-down"><?= Yii::$app->params['curCurrencies']['sign']?> <?= Yii::$app->params['curCurrencies']['name']?></span>
                <div id="currencyList" class="tb-hover">
                    <?php foreach(Yii::$app->params['currencies'] as $key => $value) : ?>
                    <?php if($value['name'] != Yii::$app->params['curCurrencies']['name']) :?>
                    <a data-currency="<?= $key ?>" ><?= $value['sign']?> <?= $value['name'] ?></a>
                    <?php endif;?>
                    <?php endforeach;?>
                </div>
            </div>
            <div class="tb-switch tb-lang">
                <span class="arrow-down">
                    <i class="lang-icon"></i>
                    <?php if((new \common\event\Language)->get() == 'CN'):?>
                    简体
                    <?php else:?>
                    繁体
                    <?php endif;?>
                </span>
                <div class="tb-hover">
                    <?php if((new \common\event\Language)->get() == 'CN'):?>
                    <a id="setLang" data-lang="HK">繁体</a>
                    <?php else:?>
                    <a id="setLang" data-lang="CN">简体</a>
                    <?php endif;?>
                    <a href="http://www.globerouter.com/" target="_blank">English</a>
                </div>
            </div>
            <div class="tb-login">
                <?php if(!isset($members['memberid'])): ?>
                    <!-- 未登录 -->
                    <span class="divide"></span>
                    <a rel="nofollow" class="border" href="<?=\Yii::$app->params['service']['ssl']?>/user/login">登录</a>
                    <a rel="nofollow" href="<?=\Yii::$app->params['service']['ssl']?>/user/register">注册</a>
                <?php else:?>
                    <!-- 已登录 -->
                    <span class="divide">Hi&nbsp;&nbsp;&nbsp;<?php echo $members['screenname']?></span>
                    <a href="<?=\Yii::$app->params['service']['ssl']?>/my/home">[会员中心]</a>
                    <a href="<?=\Yii::$app->params['service']['ssl']?>/user/logout">[退出]</a>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>

<!-- 页头 -->
<header id="header" class="header">
    <div class="header-inner<?php if(Yii::$app->controller->id != 'channel'):?> fix-top-off<?php endif;?>" id="headerInner">
        <div class="wrap clearfix">
            <?php
            $regionUrls = ['NA' => '', 'EU' => '/europe', 'AU' => '/australia_newzealand'];
            ?>
            <a class="logo" href="<?=\Yii::$app->params['service']['www']. $regionUrls[$navigationtype]?>"></a>
            <div class="channel-list">
                <ul class="clearfix">
                    <li>
                        <a href="<?=\Yii::$app->params['service']['www']?>" id="linkToHome" <?php if($regionRoot == 'NA') {echo " class='active'";}?>>美加旅游</a>
                    </li>
                    <li>
                        <a href="<?=\Yii::$app->params['service']['www']?>/europe" <?php if($regionRoot == 'EU') {echo " class='active'";}?>>欧洲旅游</a>
                    </li>
                    <li>
                        <a href="<?=\Yii::$app->params['service']['www']?>/australia_newzealand" <?php if($regionRoot == 'AU') {echo " class='active'";}?>>澳新奇旅游</a>
                    </li>
                    <li class="fix-show">
                        <a href="<?=\Yii::$app->params['service']['www']?><?php if($regionRoot == 'EU'){echo '/theme/private_group';}elseif($regionRoot == 'AU'){echo '/private/tour_book/type-tour';}else{echo '/privatetour';}?>" <?php if(Yii::$app->controller->id == 'privatetour') {echo " class='active'";}?>>海外定制</a>
                    </li>
                </ul>
                <div class="guide-tips" id="guideTips">
                    <i></i>
                </div>
            </div>
            <?php if(!empty($banner)):?>
                <div class="header-ad-gif" id="headerAdGif">
                    <a target="_blank" href="<?= $banner[0]['link']?>">
                        <img src="<?= Yii::$app->helper->getImgDomain()?>/<?= $banner[0]['pic']?>">
                    </a>
                </div>
            <?php endif;?>
            <div class="header-search-wrap" id="headerSearchWrap"></div>
        </div>
    </div>
</header>

<?= Yii::$app->view->renderFile('@lulutrip/modules/channel/views/widgets/header/nav_new.php', ['navigationtype' => $navigationtype, 'tel' => $tel, 'ChannelSubNavPlate' => $ChannelSubNavPlate, 'MainNavigationPlate' => $MainNavigationPlate]);?>
