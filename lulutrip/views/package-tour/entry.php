<?php
use lulutrip\components\Helper;
use yii\helpers\Html;
$get = Yii::$app->request->get();
?>
<div id="main" style="background-color:#f1f5fe; width:100%; min-width:1200px;">
<div id="body_14">
<div class="pt_bread_navs">
    <?= \yii\widgets\Breadcrumbs::widget([
        'itemTemplate' => "<li  class='fl'>{link} ></li>", // template for all links
        'activeItemTemplate' => "<li class=\" fl active\">{link}</li>",
        'homeLink' => [
            'label' => '首页',
            'url' => Yii::$app->params['service']['www'],
            'template' => "<li  class='fl'>{link} ></li>",
            'class' => 'check_more'
        ],
        'links' => [
            [
                'label' => '包团定制',
                'url' => ['privatetour/home'],
                'template' => "<li class='fl'>{link} ></li>",
                'class' => 'check_more'
            ],
            '包团定制列表',
        ], 'options' => ['class' => 'bread_navs']  ]) ?>
</div>
    <div class="mt20" id="ptFilters">
        <div class="ptFilters">
            <?php foreach($filters as $key => $filter):?>
                <?php $filterAlias = array('region' => '游玩区域', 'days' => '行程天数', 'theme' => '游玩主题', 'startcity' => '出发城市')?>
                <div class="option_d">
                    <span class="fl"><?= $filterAlias[$key]?>：</span>
                    <div class="detail_op fl">
                        <?php foreach($filter as $k => $value):?>
                            <?php if($k == 'all'){?>
                            <a href="<?= $value['url']?>" <?php if(empty($get[$key])):?>class="op_cur"<?php endif;?>><?= $value['name']?></a>
                            <?php }else{?>
                            <a href="<?= $value['url']?>" <?php  if(!empty($get[$key]) && $get[$key] == $k):?>class="op_cur <?= $get[$key]?>"<?php endif;?>><?= $value['name']?></a>
                            <?php }?>
                        <?php endforeach;?>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
    <?php if(!empty($packagetours)):?>
    <div class="private_entry_left">
        <div class="ptHome_trips">
            <?php foreach($packagetours as $packagetour) {?>
                <div class="ptHome_t_d">
                    <div class="fl" style="position:relative;">

                        <?php if($packagetour['pack_recommend'] == 1) { ?>
                            <img class="tip"  src="<?= Yii::$app->helper->getFileUrl('/images/private_tour_new/lulu_rec.png')?>" alt="">
                        <?php } ?>
                        <a href="<?= $packagetour['link']?>" target="_blank"><img src="<?= Yii::$app->helper->getImgDomain() ?>/<?= $packagetour['thumb']?>" onerror="this.src='<?php echo Yii::$app->request->getHostInfo(); ?>/images/no_pic.jpg';" alt="<?= Html::decode($packagetour['packmaintitle_cn'])?>" title="<?= Html::decode($packagetour['packmaintitle_cn'])?>" class="lazy" style="width:300px; height:200px;" /></a>
                        <div class="hover-d" style="display:none;">
                            <div class="text"> 产品编号  <?= 800000 + $packagetour['packid']?><br />
                                出发城市  <?= $cities[$packagetour['startcity']]?><br />
                                产品主题  <?= $themesData[$packagetour['pack_theme']]?> </div>
                        </div>
                    </div>
                    <div class="fl ptHome_t_d_r" style="width:400px; height: 150px; border-right: 1px solid #eee; padding-right:10px;">
                        <div>
                            <div class="fl cn_tit"><a href="<?= $packagetour['link']?>" target="_blank"><?= Html::decode($packagetour['packmaintitle_cn'])?></a></div>
                            <div class="clear"></div>
                        </div>
                        <!--标签输出 start-->
                        <div class="mt10">
                            <span class="tag-span tag_blue ptview_theme"><?=$themesData[$packagetour['pack_theme']] ?></span>
                            <?php if(!empty($packagetour['pf_tags']['sale'])) { ?>
                                <?php  foreach($packagetour['pf_tags']['sale'] as $tval) { ?>
                                    <span class="J_tag_span tag-span llt-hovertips <?php if(empty($tval['icon'])) { echo 'tag_red';}?>">
                                              <?php if(!empty($tval['icon'])) { ?><img src="<?= Yii::$app->request->getHostInfo(); ?>/<?= $tval['icon']?>" alt="<?= $tval['name']?>" height="20"/><?php }else{?><?= $tval['name']?><?php } ?>
                                        <div class="llt-tips ort-center">
                                            <p class="inner-content">
                                                <i class="l-arrow"></i>
                                                <?= $tval['desc']?>
                                            </p>
                                        </div>
                                          </span>
                                <?php } ?>
                            <?php } ?>

                            <?php if(!empty($packagetour['pf_tags']['discount'])) { ?>
                                <?php foreach($packagetour['pf_tags']['discount'] as $tval) { ?>
                                    <span class="J_tag_span tag-span llt-hovertips <?php if(empty($tval['icon'])) { echo 'tag_blue';}?>">
                                              <?php if(!empty($tval['icon'])) { ?><img src="<?= Yii::$app->request->getHostInfo(); ?>/<?= $tval['icon']?>" alt="<?= $tval['name']?>" height="20"/><?php }else{?><?= $tval['name']?><?php } ?>
                                        <?php if(empty($tval['desc'])) { ?>
                                            <div class="llt-tips ort-center">
                                                <p class="inner-content">
                                                    <i class="l-arrow"></i>
                                                    <?= $tval['desc']?>
                                                </p>
                                            </div>
                                        <?php } ?>
                                          </span>
                                <?php } ?>
                            <?php } ?>

                            <?php if(!empty($packagetour['pf_tags']['feature'])) { ?>
                                <?php foreach($packagetour['pf_tags']['feature'] as $tval) { ?>
                                    <span class="J_tag_span tag-span llt-hovertips <?php if(empty($tval['icon'])) { echo 'tag_blue';}?>">
                                              <?php if(!empty($tval['icon'])) { ?><img src="<?= Yii::$app->request->getHostInfo(); ?>/<?= $tval['icon']?>" alt="<?= $tval['name']?>" height="20"/><?php }else{?><?= $tval['name']?><?php } ?>
                                        <?php if(empty($tval['desc'])) { ?>
                                            <div class="llt-tips ort-center">
                                                <p class="inner-content">
                                                    <i class="l-arrow"></i>
                                                    <?= $tval['desc']?>
                                                </p>
                                            </div>
                                        <?php } ?>
                                          </span>
                                <?php } ?>
                            <?php } ?>


                            <?php if(!empty($packagetour['pf_tags']['service'])) { ?>
                                <span class="J_tag_span llt-hovertips tag-span tag_blue">
                                          <a href="javascript:void(0);" rel="shareit"><?= count($packagetour['pf_tags']['service'])?>项 路路行独家服务</a>
                                          <div class="llt-tips ort-left t-lg">
                                              <div class="inner-content">
                                                  <i class="l-arrow"></i>
                                                  <?php foreach($packagetour['pf_tags']['service'] as $tval) { ?>
                                                      <div class="vr_icon01 labelb">
                                                          <a class="J_service" target="_blank">
                                                              <?php if(empty($tval['icon'])) { ?>
                                                                  <div class="fl">
                                                                      <img src="<?= Yii::$app->helper->getImgDomain()?>/<?= $tval['icon']?>">
                                                                  </div>
                                                              <?php } ?>
                                                              <div class="fl labelhg">
                                                                  <strong><?= $tval['name']?></strong>
                                                              </div>
                                                              <?php if(empty($tval['desc'])) { ?><div class="fl"><?php if($tval['name'] == '即时确认' && $value['tour_ic_days'] > 0) {?>提前 <?= $value['tour_ic_days']?> 天完成订购，<?php } ?><?= $tval['desc']?></div><?php } ?>
                                                              <div class="clear"></div>
                                                          </a>
                                                      </div>
                                                  <?php } ?>

                                              </div>
                                          </div>
                                      </span>
                            <?php } ?>
                        </div>
                        <!--标签输出 end-->
                        <div class="ptHome_brief"><?= $packagetour['packsummary_cn']?></div>

                    </div>
                    <div class="fl" style="width:226px; padding-top:40px;">
                        <div class="mt20">

                            <div class="ptHome_price"><span class="sign"><?= Yii::$app->params['curCurrencies']['sign']?></span> <span class="num"><?= $packagetour['pack_lowprice'][Yii::$app->params['curCurrency']]?></span><span style="color:#333;vertical-align:middle;margin-left:10px;">起/人</span></div>
                            <div style="width:79px; margin:15px auto;"><a href="<?= $packagetour['link']?>" target="_blank" class="comm-btn1">我要报价</a> </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>

            <?php } ?>
        </div>
        <div class="bottom_pagenum">
            <div style="margin-left: -241.5px;" class="bg_navs">
            <?= $pageData?>
            </div>
        </div>
    </div>
    <?php else:  ?>
        <div class="private_entry_left">
            <div class="product_wrapper">
                <div class="product_list_wrapper">
                    <div class="no_result mt20">
                        <div class="f22">很抱歉！<span>没有找到相关产品 !</span> 请修改筛选条件。</div>
                        <div class="mt25"><a href="<?= Yii::$app->params['service']['www']?>" class="button_back">返回首页</a></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
    <div class="private_entry_right">
        <div class="ll_server">
            <a href="/privatetour/home" target="_blank" class="comm-btn2 comm-btn-lg">
                点击了解详情
            </a>
        </div>
        <div class="entry">
            <p>没有合适的行程<br>需要设计师定制？</p>
            <a href="<?= Yii::$app->params['service']['www']?>/private/tour_book/type-tour" target="_blank" class="comm-btn2 comm-btn-lg comm-btn-special">个性定制入口</a>
        </div>
        <div class="bus">
            <p>语言无障碍  司机听我走<br>包车服务  也许更适合你！</p>
            <a href="<?= Yii::$app->params['service']['www']?>/private/bus" target="_blank" class="comm-btn2 comm-btn-lg comm-btn-special">了解包车服务</a>
        </div>
        <!--end privateBus-->
        <div id="hotsale_data">

        </div>

    </div>
    <div class="clear"></div>
    <div class="h40"></div>
</div>
<script type="text/javascript" language="javascript">
<?php $this->beginBlock('js_view') ?>
$(function() {
    $("img.lazy").lazyload({effect:'fadeIn'});
    var refresh = <?= Yii::$app->request->get('refresh', 0)?>;
    $.get(newDomain + "/ajax/get_hotsales?page=1&refresh="+refresh, function(data){
        if(data != '') {$("#hotsale_data").html(data);}
        var h2=$("#body_14 .private_entry_right").height();
        var h3=$("#body_14 .private_entry_left").height()-60;
        if(h2>h3){
            $("#body_14 .private_entry_right").css({"position":"static","z-index":"auto","bottom":"auto","left":"auto"});
        }
    });
    $(".main_tourlist .any_list").each(function() {
        $(this).mouseenter(function(){
            $(this).css({"box-shadow":"0 0 8px #b2b2b2"});
        }).mouseleave(function(){
            $(this).css({"box-shadow":"0px 1px 3px 0px rgba(0, 0, 0, 0.2)"});
        })
    });
    $(".jsqrTit").mouseenter(function(){
        $(".jsqrTips").slideDown("fast");
    }).mouseleave(function(){
        $(".jsqrTips").hide();
    })
    $(window).scroll(function(){
        var headH=$("#pt_header").height();
        var breadH=$(".pt_bread_navs").height()+15;
        var searchH=$(".search_result").css("display")=="none"?0:$(".search_result").height()+14;
        var searchH2=$(".no_search_result").css("display")=="none"?0:$(".no_search_result").height()+14;
        var play_fH=$(".play_filters").height()+18+15;
        var tour_fH=$(".tour_filters").height()+30;
        var scrollTop=$(document).scrollTop();
        var clientH=$(window).height();
        if(headH+breadH+searchH+searchH2+play_fH-scrollTop<=0){
            $(".tour_filters").addClass("fixStyle");
        }
        else{
            $(".tour_filters").removeClass("fixStyle");
        }
    })

    /*判断字数*/
    $(".ptHome_t_d_r .en_tit").each(function() {
        var maxTextnum=60;
        if($(this).text().length>maxTextnum){
            $(this).text($(this).text().substring(0,maxTextnum));
            $(this).html($(this).text()+' ...');
        }
    });
    // $(".ptHome_t_d_r .cn_tit a").each(function() {
    //     var maxTextnum=22;
    //     if($(this).text().length>maxTextnum){
    //         $(this).text($(this).text().substring(0,maxTextnum));
    //         $(this).html($(this).text());
    //     }
    // });
    $(".ptHome_brief").each(function() {
        var maxTextnum=70;
        if($(this).text().length>maxTextnum){
            $(this).text($(this).text().substring(0,maxTextnum));
            $(this).html($(this).text()+' ...');
        }
    });

    /*鼠标经过列表图片 出现浮层*/
    $(".ptHome_t_d").each(function() {
        var num=$(".ptHome_t_d").index(this);
        $(this).hover(function() {
            $(".ptHome_t_d .hover-d:eq("+num+")").fadeIn("fast");
        },function(){
            $(".ptHome_t_d .hover-d:eq("+num+")").fadeOut("fast",function(){
                $(this).stop(true,true);
            });
        });
    });

});

function changeRightPos2(curh1,curh2,cheight,cwidth,wl,scrollleft,isRight,isRight2){
    if(curh1<=cheight){
        if(curh2<=cheight){
            $("#body_14 .private_entry_right").css({"position":"absolute","z-index":"99","bottom":"60px","left":wl+13})
        }
        else{
            if(cwidth<1200){
                $("#body_14 .private_entry_right").css({"position":"fixed","z-index":"99","left":wl+13-scrollleft,"bottom":0});
            }
            else{
                $("#body_14 .private_entry_right").css({"position":"fixed","z-index":"99","left":(cwidth-1200)/2+wl+13,"bottom":0});
            }

        }
    }
    else{
        $("#body_14 .private_entry_right").css({"position":"static","z-index":"auto","bottom":"auto","left":"auto"})
    }
}

function get_bar_data(id, totaltour, region) {
    $.get("/ajax/get_tourlist_bar/id-"+id, function(data){
        data = trim(data);
        data = eval("("+data+")");
        var ih = '<li><h1>'+data.scenename+'旅游（<span id="bar_totaltour">'+totaltour+'</span>）</h1></li>';
        if(region != 'EU') {
            for(var key in data) {
                if(key == 'acts' && data[key] > 0) {ih += '<li><a href="/activity/entry/scene-'+id+'" class="pft_2_off" target="_blank">'+data.scenename+'自由行</a></li>';}
                if(key == 'hotel' && data[key] > 0) {ih += '<li><a href="/hotel/book/city-'+data.citycode+'" class="pft_2_off" target="_blank">'+data.scenename+'酒店</a></li>';}
                if(key == 'bus' && data[key] > 0) {ih += '<li><a href="/private/bus/scene-'+id+'" class="pft_2_off" target="_blank">'+data.scenename+'包车</a></li>';}

            }
        }
        $("#tourlist_bar_ul").html(ih);
    });
}

function get_hotpackagetours_data(page) {
    var refresh = <?= Yii::$app->request->get('refresh', 0)?>;
    $.get(newDomain + "/ajax/get_hotsales?page="+page + "&refresh=" + refresh, function(data){
        $("#hotsale_data").html(data);
    });
}

function gotoPage(pageLink, totalPage)
{
    var page = Number($('#pagenavi_input').val());
    if(page == 0 || page > totalPage)
    {
        return;
    }
    var href = pageLink.replace('{{page}}', page);
    location.href=href;
}
<?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['js_view'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>