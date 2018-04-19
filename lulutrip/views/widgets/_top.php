<link href="<?= Yii::$app->helper->getFileUrl('/css/index_14.css')?>" rel="stylesheet">
<link href="<?= Yii::$app->helper->getFileUrl('/css/import.css')?>" rel="stylesheet">
<link href="<?= Yii::$app->helper->getFileUrl('/css/channel_common.css')?>" rel="stylesheet">
<link href="<?= Yii::$app->helper->getFileUrl('/css/search.css')?>" rel="stylesheet">
<link href="<?= Yii::$app->helper->getFileUrl('/css/private_tour_new.css')?>" rel="stylesheet">
<link href="<?= Yii::$app->helper->getFileUrl('/css/channel_nav_style.css')?>" rel="stylesheet">

<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/jquery.min.js', 1)?>"></script>
<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/My97DatePicker/WdatePicker.js')?>"></script>
<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/jquery.form.js')?>"></script>
<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/jquery-ui3.js')?>"></script>
<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/common.js')?>"></script>
<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/channel_common.js')?>"></script>
<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/search_top_list.js')?>"></script>
<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/jquery.lazyload.min.js')?>"></script>
<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/sidebar.js')?>"></script>
<!-- 顶部公告 -->
<?php if(date('Y-m-d H:i') <= '2017-08-26 17:30'):?>
    <div id="topnotice" class="topnotice">
        <p>维护公告：因客服系统维护升级，美西时间 8/26 早上8:30A - 5:30P 客服电话暂停服务。 如需服务，可随时通过<a href="javascript:;" id="topnotice-kefu">在线客服</a>或<a href="javascript:;" id="topnotice-weixin">微信服务号<i class="icon-style" style="z-index:99;"></i></a>与我们联系，给您带来不便，敬请谅解！</p>
    </div>
<?php endif;?>
<?php if (Yii::$app->controller->regionRoot == 'EU' && date('Y-m-d') >= '2017-04-28' && date('Y-m-d') <= '2017-05-01'):?>
<div class="week_active" style="display:none;">
    <div class="week_close">
        <a href="javascript:;" onclick="close_ActiveBanner()"></a>
    </div>
</div>
<?php endif;?>
<script language="javascript">
    if($.cookie('top_close') == undefined && $.cookie('top_close') == null) {
        $(".week_active").show();
    }

    function close_ActiveBanner() {
        $.cookie('top_close',1, {expires: 1, 'path' : '/'});
        $(".week_active").hide();
    }
</script>
<!-- 顶部导航 -->
<div class="header clearfix">
    <div class="wrap">
        <div class="menu fl">
            <ul class="header-left">
                <li>
                    <?php if(!empty($members)) { ?>
                    <div class="member">
                        <label>Hi&nbsp;&nbsp;<?php echo $members['screenname']?></label>
                        <a href="<?=\Yii::$app->params['service']['ssl']?>/my/home">[会员中心]</a>
                        <a href="<?=\Yii::$app->params['service']['ssl']?>/user/logout">[退出]</a>
                    </div>
                    <?php } else { ?>
                    <a rel="nofollow" class="border" href="<?=\Yii::$app->params['service']['ssl']?>/user/login">登录</a><span>|</span><a rel="nofollow" href="<?=\Yii::$app->params['service']['ssl']?>/user/register">注册</a>
                    <?php }?>
                </li>
            </ul>
        </div>
        <div class="header_right fr">
            <div class="hv-sh">
                <span>手机版</span>
                <div class="menu_more">
                    <img src="<?= Yii::$app->helper->getFileUrl('/images/common/app.jpg')?>">
                </div>
            </div>
            <div class="money-dd">
                <span class="ccy"><?= Yii::$app->params['curCurrencies']['name']?></span>
                <i class="arrow-down"></i>
                <div class="common_list money-list">
                    <?php foreach(Yii::$app->params['currencies'] as $key => $value) : ?>
                        <?php if($value['name'] != Yii::$app->params['curCurrencies']['name']) :?>
                        <a href="javascript:setCurrency('<?= $key ?>');"><?= $value['name'] ?></a>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
            </div>
            <div class="hv-sh">
                <?php if((new \common\event\Language)->get() == 'CN'):?>
                    <a class="border" href="javascript:setLang('HK');">繁</a>
                <?php else:?>
                    <a class="border" href="javascript:setLang('CN');">简</a>
                <?php endif;?>
                <span>|</span>
                <a href="http://www.globerouter.com/" target="_blank">EN</a>
            </div>
        </div>
    </div>
</div>
<!-- 顶部导航 -->
<!-- 主导航 -->
<div class="nav clearfix nav_main_common">
<div class="wrap clearfix">
<div class="nav-wrap">
<div class="nav-left">
    <?php
        $regionUrls = ['NA' => '', 'EU' => '/europe', 'AU' => '/australia_newzealand'];
    ?>
    <a href="<?=\Yii::$app->params['service']['www'] . $regionUrls[$navigationtype]?>" target="_blank"><img src="<?=Yii::$app->helper->getFileUrl('/images/common/logo_0715.png')?>" width="200" height="59" alt="路路行"></a>
</div>
<div class="nav-right">
<?php if(!empty($navigationtype)):?>
<div class="nav_left">
    <ul class="clearfix">
        <li class="fl">
            <a href="<?=\Yii::$app->params['service']['www']?>" onclick="urlHome();" <?php if($regionRoot == 'NA') {echo " class='active'";}?>>美加旅游</a>
        </li>
        <li class="fl">
            <a href="<?=\Yii::$app->params['service']['www']?>/europe"<?php if($regionRoot == 'EU') {echo " class='active'";}?>>欧洲旅游</a>
        </li>
        <li class="fl">
            <a href="<?=\Yii::$app->params['service']['www']?>/australia_newzealand"<?php if($regionRoot == 'AU') {echo " class='active'";}?>>澳新奇旅游</a>
        </li>
    </ul>
</div>
<?php endif;?>
<div class="search_top">
    <?php $currentTime = date('Y-m-d H:i:s', time()); if (!empty($banner[0]) && ($banner[0]['start_time'] <= $currentTime && $banner[0]['end_time'] >= $currentTime)):?>
    <div class="head_right_phone">
        <a target="_blank"  href="<?= $banner[0]['link']?>"><img src="<?= Yii::$app->helper->getImgDomain()?>/<?= $banner[0]['pic']?>"></a>
    </div>
    <?php endif;?>
    <div class="search_ul">
        <div class="ul_text"><span class="showText">当地参团</span><i class="arrow-down"></i></div>
        <div class="ul_li">
            <ul class="showSeat" onmouseover="isOut=false" onmouseout="isOut=true">
                <li onclick="selectSeat(1,'当地参团');">当地参团</li>
                <li onclick="selectSeat(4,'当地玩乐');">当地玩乐</li>
                <li onclick="selectSeat(5,'门票');">门票</li>
                <li onclick="selectSeat(6,'交通/接送');">交通/接送</li>
                <li onclick="selectSeat(7,'酒店');">酒店</li>
            </ul>
            <input type="hidden" id="_topsearchenter" value="1" autocomplete="off">
        </div>
    </div>
    <div class="search_top_f" onmouseover="isOut=false" onmouseout="isOut=true">
        <input type="text" class="ui-autocomplete-input" id="searchkey_top" placeholder="关键词/产品编号" autocomplete="off">
        <div class="search_on moni_sel" onmouseover="isOut=false" onmouseout="isOut=true">请输入关键词/产品编号</div>
        <a class="btn" onclick="topsearch()" href="javascript:void(0);"></a>
    </div>
    <?php if(!empty($navigationtype) && $searchFlag):?>
    <div class="search_city" id="search_city_1" onmouseover="isOut=false" onmouseout="isOut=true">
        <div class="city_top_list">
            <div class="hot_theme_in">
                <span>热门主题</span>
                <ul>
                    <?php foreach($search301 as $key => $value):?>
                    <li><a href="<?= Yii::$app->params['service']['www']?>/search/tour?keyword=<?= $key?>&s=r_search" target="_blank"><?= $key?></a></li>
                    <?php endforeach;?>
                    <div class="clear"></div>
                </ul>
                <div class="clear"></div>
            </div>
            <div>
                <div class="search_rmtj">热门推荐</div>
                <?php foreach($searchNav['tour'] as $key => $val):?>
                <div class="city_top_dl">
                    <span><?= $val['title']?></span>
                    <dl>
                        <?php foreach($val['atom'] as $atomval):?>
                        <dd><em data-val="<?= $atomval?>"><?= $atomval?></em></dd>
                        <?php endforeach;?>
                    </dl>
                    <div class="clear"></div>
                </div>
               <?php endforeach;?>
            </div>
        </div>
    </div>
    <?php endif;?>
    <div class="search_city" id="search_city_4" onmouseover="isOut=false" onmouseout="isOut=true">
        <div class="city_top_list">
            <div class="hot_theme_in">
                <span>热门主题</span>
                <ul>
                    <?php foreach($search301 as $key => $value):?>
                    <li><a href="<?= Yii::$app->params['service']['www']?>/search/tour?keyword=<?= $key?>&s=r_search" target="_blank"><?= $key?></a></li>
                    <?php endforeach;?>
                    <div class="clear"></div>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="search_rmtj">热门推荐</div>
            <?php foreach($searchNav['activity'] as $key => $val):?>
            <div class="city_top_dl">
                <span><?= $val['title']?></span>
                <dl>
                    <?php foreach($val['atom'] as $atomval):?>
                    <dd><em data-val="<?= $atomval?>"><?= $atomval?></em></dd>
                    <?php endforeach;?>
                </dl>
                <div class="clear"></div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
    <div class="search_city" id="search_city_5" onmouseover="isOut=false" onmouseout="isOut=true">
        <div class="city_top_list">
            <div class="hot_theme_in">
                <span>热门主题</span>
                <ul>
                    <?php foreach($search301 as $key => $value):?>
                        <li><a href="<?= Yii::$app->params['service']['www']?>/search/tour?keyword=<?= $key?>&s=r_search" target="_blank"><?= $key?></a></li>
                    <?php endforeach;?>
                    <div class="clear"></div>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="search_rmtj">热门推荐</div>
            <?php foreach($searchNav['tickets'] as $val):?>
            <div class="city_top_dl">
                <span><?= $val['title']?></span>
                <dl>
                    <?php foreach($val['atom'] as $key => $atomval):?>
                    <dd><em data-val="<?= $atomval?>"><?php if(!is_numeric($key)):?><a href="<?= $key?>"><?= $atomval?></a><?php else:?><?= $atomval?><?php endif;?></em></dd>
                    <?php  endforeach?>
                </dl>
                <div class="clear"></div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>


<!--导航 浮层-->
<div id="header-menu" class="header-menu">
    <div class="header-menu-inner clearfix">
        <?php if(!empty($navigationtype)):?>
        <div class="hm-left J-hmLeft hide-sn"><!-- 如果是列表页加上hide-sn  默认隐藏 -->
            <?php if(!empty($topHover['categoryNav'])) { ?>
                <span class="hm-left-title">
        <?php
        if($navigationtype == 'NA'){
            echo "美加";
        } elseif($navigationtype == 'EU') {
            echo "欧洲";
        } elseif($navigationtype == 'AU') {
            echo "澳新";
        }
        ?>旅游&nbsp;全部目的地</span>
            <?= $ChannelSubNavPlate; ?>
        <?php } ?>
        </div>
        <!--参团-->
        <?=$MainNavigationPlate ?>
        <?php else:?>
        <ul class="sn-right">
            <li>
                <a class="a-li locationHomePage">首页</a>
            </li>
            <li>
                <a href="<?= Yii::$app->params['service']['www']?>/america" class="a-li">美加旅游</a>
            </li>
            <li>
                <a href="<?= Yii::$app->params['service']['www']?>/europe" class="a-li">欧洲旅游</a>
            </li>
            <li>
                <a href="<?= Yii::$app->params['service']['www']?>/australia_newzealand" class="a-li">澳新奇旅游</a>
            </li>
            <li>
                <a href="http://diy.lulutrip.com/" class="a-li" target="_blank">自由行</a>
            </li>
        </ul>
        <?php endif;?>
        <div class="tel-area">
            <div class="tel-dd">
                <span>
                    <img src="<?= Yii::$app->helper->getFileUrl('/images/phone.png') ?>" class="i-tel" width="15" height="15" alt="">
                    <?= Yii::$app->helper->getCustomerServicePhone();?>
                </span>
                <div class="tel-list">
                    <h2 class="rhr t-bt">全球 7x24小时客服电话</h2>
                    <?php if (!empty($serviceTel)):?>
                        <?php $area = array('NA', 'CN', 'EU', 'AU');?>
                        <?php foreach($area as $item):?>
                            <div class="rhr">
                                <?php foreach($serviceTel as $tel):?>
                                    <?php if ($tel['code'] == $item):?>
                                    <p class="tel-row">
                                        <span class="t-a"><?= $tel['areaname']?></span>
                                        <span class="t-n"><?= $tel['phone']?></span>
                                    </p>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </div>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--导航-->


<div class="footer_register_mobile" id="footer_register_mobile" style="display: none;">
    <form method="post" action="http://www.lulutrip.com/user/bindPhoneEmail">
        <div class="cont fs1" id="step1" style="display: none;">
            <h1 class="f20">请输入您的电子邮箱信息</h1>
            <p class="f14">绑定您的邮箱，您可以顺利接收订购凭证及路路行的优惠信息； 此外，您还可以用该邮箱进行账号登录。</p>
            <div class="input_li" style="height: 70px;">
                <input type="text" name="email" placeholder="请输入电子邮箱">
                <input type="hidden" name="memberid" value="">
                <div class="input_text"><i></i>输入的邮箱不符合规范</div>
            </div>
            <div class="btn"><a class="btn_a" href="javascript:;" onclick="sendBindEmail()">确认电子邮箱</a><a class="re_a" href="javascript:;" onclick="hideFrame('footer');">暂时跳过</a></div>
        </div>
    </form>
    <form method="post" action="http://www.lulutrip.com/my/sendBindEmail">
        <div class="cont fs1" id="step2" style="display: none;">
            <h1 class="f20">请查看您的验证邮件</h1>
            <p class="f14">出于安全考虑，请点击发送给您的邮件中的链接，完成邮箱验证。邮箱验证成功后，可获得100积分哦。</p>
            <div class="input_li" style="height: 70px;">
                <input type="text" name="email" disabled="">
            </div>
            <div class="btn"><a class="btn_a" href="javascript:;" onclick="resendBindEmail()">重新发送验证邮件</a><a class="re_a" href="javascript:;" onclick="hideFrame('footer');">知道了</a></div>
        </div>
        <div class="close_btn_dw"><a href="javascript:;" onclick="hideFrame('footer');"><img src="<?=Yii::$app->helper->getFileUrl('/images/common/icon_close.png')?>"></a></div>
        <div class="loading_top loading_fs fs1" style="display:none;"><img src="<?=Yii::$app->helper->getFileUrl('/images/common/ico_loading.gif')?>" style="width:32px; height:32px; margin-left:25px;">&nbsp;&nbsp;正在发送...</div>
        <div class="loading_top loading_fscg fs1 ac" style="display:none;">发送成功</div>
    </form>
</div>
<script language="javascript">
    <?php $this->beginBlock('js_view') ?>
    $('.locationHomePage').click(function () {
        //老客户点击跳转首页时设置cookie, 让自动跳转频道页失效
        $.cookie('visitHomePage', 'ok', {path: '/'});
        location.href = '<?=Yii::$app->params['service']['www']?>';
    });
    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['js_view'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>
