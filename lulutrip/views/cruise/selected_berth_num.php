<?php
use lulutrip\components\Helper;
use yii\helpers\Html;
$cookies = Yii::$app->request->cookies;
?>
<link href="<?= Yii::$app->helper->getFileUrl('/css/cruise.css')?>" rel="stylesheet">
<div id="main" style="background-color:#eee; width:100%; min-width:1200px;">
    <div id="body_14" style="padding-bottom:40px;">
        <div class="bread_navs"> 
            <a href="http://www.lulutrip.com" class="check_more">首页</a>&gt; 选择出行日期 &gt; 选择客舱号码
        </div>
        <div class="cruise_selected clearfix">
            <div class="text">
                <h2 class="f18"><?php if ($itinerary['Itinerary']['NameCN']) {echo $itinerary['Itinerary']['NameCN'];} else {echo $itinerary['Itinerary']['Name'];}?></h2>
                <div class="mt20">
                    <p><span class="fc66">邮轮公司：</span><?php if ($itinerary['LineNameCN']) {echo $itinerary['LineNameCN'];} else {echo $itinerary['CruiseLineName'];}?></p>
                    <p><span class="fc66">邮轮：</span><?php echo $itinerary['ShipName']; ?><img src="<?= Yii::$app->helper->getFileUrl('/images/cruise/dest_star' . $itinerary['ShipRating'] . '.png')?>"></p>
                </div>
                <?php
                foreach ($itinerary['SailingDates']['Sailing'] as $item) {
                    if ($item['SailingID'] != $param['SailingID']) continue;
                    ?>

                    <div class="mt20">
                        <p><span class="fc66">出发时间：</span><?php echo $item['Departure']?></p>
                        <p><span class="fc66">结束时间：</span><?php echo $item['Arrival'];?></p>
                    </div>
                    <div class="mt20">
                        <p><span class="fc66">出发港口：</span><?php echo $itinerary['DeparturePortName'];?></p>
                        <p><span class="fc66">旅客：</span><?php echo $param['AdultsNum']; ?> 成人，<?php echo $param['ChildNum'];?> 儿童</p>
                    </div>
                    <?php
                    break;
                }?>
                <div class="mt20">
                    <p><span class="fc66">邮轮价格：</span><strong class="f16"><?= Yii::$app->params['curCurrencies']['sign'] . ($totalPrice['shipTotal'][Yii::$app->params['curCurrency']] - $totalPrice['NCF'][Yii::$app->params['curCurrency']])?></strong></p>
                    <p><span class="fc66">港口费：</span><strong class="f16"><?= Yii::$app->params['curCurrencies']['sign'] . $totalPrice['NCF'][Yii::$app->params['curCurrency']]?></strong></p>
                    <p><span class="fc66">税费和服务费：</span><strong class="f16"><?= Yii::$app->params['curCurrencies']['sign'] . $totalPrice['taxTotal'][Yii::$app->params['curCurrency']]?></strong></p>
                    <p class="fc60"><span>总计：</span><strong class="f16"><?= Yii::$app->params['curCurrencies']['sign'] . $totalPrice['total'][Yii::$app->params['curCurrency']]?></strong>（邮轮+港口费人均：<?= Yii::$app->params['curCurrencies']['sign'] . round($totalPrice['shipTotal'][Yii::$app->params['curCurrency']]/($param['AdultsNum'] + $param['ChildNum']), 2)?>，税/服务费人均：<?= Yii::$app->params['curCurrencies']['sign'] . round($totalPrice['taxTotal'][Yii::$app->params['curCurrency']]/($param['AdultsNum'] + $param['ChildNum']), 2)?>）</p>
                </div>
            </div>
            <div class="mt40 list">
                <div class="berth_num clearfix">
                    <div class="fl berth_l">
                        <p>选择舱位： <strong><?php echo $cat['TypeName'];?></strong></p>
                        <div class="mt15 berth_li">
                            <div class="t">
                                <p>甲板：<?php echo $cat['DeckName'];?></p>
                                <!--<p class="mt40"><img src="<?= Yii::$app->helper->getFileUrl('/images/cruise/berth_img.jpg')?>"></p>-->
                            </div>
                            <div class="sct cabin_num">
                                <div class="n">选择您的客舱号码：</div>
                                <dl>
                                    <dt><span>客舱</span><span>甲板</span></dt>
                                    <?php foreach ($cabins['CabinsList']['Cabin'] as $cabin) {?>
                                    <dd><?php if ($cabin['IsGuaranteed'] == false) {?><span class="f20"><?= $cabin['CabinNumber']?></span><span><?= $cabin['DeckName']?></span><?php } else{?><span class="isgurant"><strong>服从分配</strong>若旅客选择服从分配，您选择的房型会获得保证，但房间位置暂未确定，您的客舱号将在您登船时确认，但您有免费升舱的可能。</span><?php }?><a <?php if ($cabin['IsGuaranteed'] != false) {?> class="isgurant" <?php }?> onclick="doBerthnum()" href="/cruise/add_to_cart?<?php echo $cabin['nextUrl'];?>">确定</a></dd>
                                    <?php }?>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="fr d600 cabin_img">
                        <?php foreach ($cabins['CabinsList']['Cabin'] as $cabin) {?>
                        <div class="img_li">
                            <?php if ($cabin['IsGuaranteed'] == false) {?>
                            <h2>客舱:<?= $cabin['CabinNumber']?></h2>
                            <p><img src="<?= $cabin['DeckImg']?>"></p>
                            <?php }?>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="select_Win">
    <div class="select_icon">
        <span class="p00"></span>
        <span class="p01"></span>
        <span class="p02"></span>
    </div>
    <div class="select_text"></div>
</div>
<div class="bg_layer" id="bg_layer"></div>
<script type="text/javascript" language="javascript">
    <?php $this->beginBlock('js_view') ?>
    $(function(){
        /*表单下拉*/
        $("[id*='Jseat']").stop(true).on('click', function () {
            $(this).find("ul").slideToggle("fast");
        });
        $("[id*='Jseat']").find("a").stop(true).on('click', function () {
            var text = $(this).html();
            $(this).parents("[id*='Jseat']").find("input").val(text);
        });
        $(".cabin_num dd").hover(function(){
            var ind = $(this).index() - 1;
            $(this).addClass('on').siblings("dd").removeClass("on");
            $(".cabin_img .img_li:eq('"+ind+"')").show().siblings(".img_li").hide();
        });
    });
    function doBerthnum() {
        $(".select_Win").show();
        $(".bg_layer").show();
    };
    var isOut=true;
    document.onmousedown=function(){
        if($(".isOut_d").attr("display") != "none" && isOut == true )  {
            $(".isOut_d").hide();
        }
    };
    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['js_view'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>