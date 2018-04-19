<?php
use lulutrip\components\Helper;
use yii\helpers\Html;
$cookies = Yii::$app->request->cookies;
?>
<link href="<?= Yii::$app->helper->getFileUrl('/css/cruise.css')?>" rel="stylesheet">
<div id="main" style="background-color:#eee; width:100%; min-width:1200px;">
    <div id="body_14" style="padding-bottom:40px;">
        <div class="bread_navs">
            <a href="http://www.lulutrip.com" class="check_more">首页</a> &gt; 美加邮轮
        </div>
        <?= \common\widgets\Alert::widget()?>
        <div class="cruise_home clearfix">
            <div class="cruise_left">
                <?= Yii::$app->view->renderFile('@lulutrip/views/cruise/_form.php', ['destination' => $destination, 'dep' => $dep, 'tod' => $tod, 'length' => $length, 'line' => $line, 'port' => $port, 'filter' => $filter, 'selectedFilter' => $selectedFilter, 'newFilter' => $newFilter, 'phones' => $phones]);?>
                <div class="mt20 cruise_new">
                    <div class="tit">邮轮攻略</div>
                    <div class="cont">
                        <ul>
                            <li><a target="_blank" href="http://article.lulutrip.com/view/id-10007">史上最详细的全球邮轮签证办理条件在这，世界各国邮轮签证要求一览</a></li>
                            <li><a target="_blank" href="http://article.lulutrip.com/view/id-9617">另类地中海邮轮路线，带你走进静谧的世外桃源之旅</a></li>
                            <li><a target="_blank" href="http://article.lulutrip.com/view/id-9637">最美加勒比海邮轮旅游指南，跟随杰克船长寻找不老之泉水</a></li>
                            <li><a target="_blank" href="http://article.lulutrip.com/view/id-9341">豪华欧洲邮轮旅游路线 一张船票看遍欧洲春色</a></li>
                            <li><a target="_blank" href="http://article.lulutrip.com/view/id-9333">你的征途是星辰大海！意大利邮轮旅游让你吃喝玩乐一键get</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="cruise_right">
                <div id="cruise_banner">
                    <ul>
                        <li><a href="javascript:;" style="background: url('<?= Yii::$app->helper->getFileUrl('/images/cruise/banner.jpg')?>') 50% 50% no-repeat"></a></li>
                    </ul>
                </div>
                <div class="cruise_discount">
                    <div class="cruise_line">
                        <p class="lin_1"><span></span></p>
                        <p class="lin_2"><span></span></p>
                    </div>
                    <div class="cruise_list">
                        <div class="list_ul" id="cruise_bestdeal_list">
                            <div class="tit clearfix">
                                <h2><img src="<?= Yii::$app->helper->getFileUrl('/images/cruise/icon_time.png')?>">限时特惠</h2>
                                <span>价格</span>
                                <span>天数</span>
                            </div>
                            <div style="text-align: center;" id="best_deal_loading"><img src="<?= Yii::$app->helper->getFileUrl('/images/loading.gif')?>"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .form_msg {
        display: none;
    }
</style>
<script type="text/javascript" language="javascript">
    <?php $this->beginBlock('js_view') ?>
    $(function(){
        /*表单下拉*/
        $("[id*='Jseat']").find("input").stop(true).on('click', function () {
            $(this).siblings("ul").slideDown("fast");
        });
        $("[id*='Jseat']").find("a").stop(true).live('click', function () {
            var text = $(this).html();
            $(this).parents("[id*='Jseat']").find("input").val(text);
            $(this).parents("[id*='Jseat']").find("ul").slideUp("fast");
        });
        /*banner效果*/
        var index = 0;
        var picTimer;
        var sWidth;
        var len = $("#cruise_banner ul li").length;
        var btn = "<div class='btn'>";
        for (var i = 0; i < len; i++) {
            btn += "<span></span>";
        }
        btn += "</div>";
        $("#cruise_banner").append(btn);
        sWidth = $(".cruise_right").width();

        $('#cruise_banner').width(sWidth);
        $('#cruise_banner ul li').width(sWidth);

        $("#cruise_banner .btn span").mouseover(function () {
            index = $("#cruise_banner .btn span").index(this);
            showPics(index, sWidth);
        }).eq(0).trigger("mouseover");

        $("#cruise_banner ul").css("width", sWidth * (len));

        $("#cruise_banner").hover(function () {
            $('#cruise_banner .wrap').addClass('active');
            clearInterval(picTimer);
        }, function () {
            $('#cruise_banner .wrap').removeClass('active');
            picTimer = setInterval(function () {
                if (index == len - 1) {
                    index = -1;
                }
                showPics(index + 1, sWidth);
                index++;
            }, 5000);
        }).trigger("mouseleave");
        function showPics(index, sWidth) {
            $("#cruise_banner ul").css("width", sWidth * (len));
            var nowLeft = -index * sWidth;
            $("#cruise_banner ul").stop(true, false).animate({"left": nowLeft}, 300);
            $("#cruise_banner .btn span").stop(true, false).removeClass('on').eq(index).stop(true, false).addClass('on');
        }
        $.get("/cruise/get_deal", function(data){
            $("#best_deal_loading").hide();
            if(data != '') {
                $("#cruise_bestdeal_list").append(data);
            }
        });
    });
    var isOut=true;
    document.onmousedown=function(){
        if($(".isOut_d").attr("display") != "none" && isOut == true )  {
            $(".isOut_d").hide();
        }
    };
    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['js_view'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>