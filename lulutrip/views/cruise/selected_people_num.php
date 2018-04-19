<?php
use lulutrip\components\Helper;
use yii\helpers\Html;
$cookies = Yii::$app->request->cookies;
?>
<link href="<?= Yii::$app->helper->getFileUrl('/css/cruise.css')?>" rel="stylesheet">
<div id="main" style="background-color:#eee; width:100%; min-width:1200px;">
    <div id="body_14" style="padding-bottom:40px;">
        <div class="bread_navs"> 
            <a href="http://www.lulutrip.com" class="check_more">首页</a>&gt; 选择出行日期 &gt; 选择出行人数
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
                    if ($item['SailingID'] != $param['sal']) continue;
                ?>
                    
                <div class="mt20">
                    <p><span class="fc66">出发时间：</span><?php echo $item['Departure']?></p>
                    <p><span class="fc66">结束时间：</span><?php echo $item['Arrival'];?></p>
                </div>
                <div class="mt20">
                    <p><span class="fc66">出发港口：</span><?php echo $itinerary['DeparturePortName'];?></p>
                </div>
                <?php
                    break;
                }?>
            </div>
            <form method="get" action="/cruise/select/cabincat" name="numForm">
            <div class="mt40 list">
                <div class="pop_num">
                    <div class="tit">请选择客舱人数</div>
                    <div class="cont">
                        <div class="clearfix">
                            <div class="pop_Adult_list">
                                <div class="pop_adult clearfix">
                                    <span>成人：</span>
                                    <div class="showseat" id="Jseat_adult">
                                        <input type="text" id="AdultsNum" name="AdultsNum" placeholder="选择" data-name="成人" data-num="num" readonly="">
                                        <ul class="isOut_d" id="AdultsNum_ul" onmouseover="isOut=false" onmouseout="isOut=true">
                                            <?php for ($i = 1; $i <= $itinerary['line']['tc_line_MaxGuestPerCabin']; $i++) {?>
                                            <li><a><?= $i?></a></li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                    <div class="pop_tips" id="AdultsNum_tips"></div>
                                </div>
                                <div class="mt15 clearfix" id="AdultsNum_add"></div>
                            </div>
                            <div class="pop_Adult_list">
                                <div class="pop_adult clearfix">
                                    <span>儿童：</span>
                                    <div class="showseat" id="Jseat_child">
                                        <input type="text" id="ChildNum" name="ChildNum" placeholder="选择" data-name="儿童" data-num="num2" readonly="" value="0">
                                        <ul class="isOut_d" id="ChildNum_ul" onmouseover="isOut=false" onmouseout="isOut=true">
                                            <?php for ($i = 0; $i < $itinerary['line']['tc_line_MaxGuestPerCabin']; $i++) {?>
                                                <li><a><?= $i?></a></li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                    <span class="ml10 fc88">（0-17）</span>
                                </div>
                                <div class="mt15 clearfix" id="ChildNum_add"></div>
                            </div>
                        </div>
                        <div class="tips_num_peop"></div>
                        <div class="mt15 tips">
                            <i class="icon"><img src="<?= Yii::$app->helper->getFileUrl('/images/cruise/pop_tips.jpg')?>"></i>
                            <div class="tips_txt">
                                <strong>温馨提示：</strong>如果您需要同时结算两个及以上邮轮产品或舱房，请务必致电路路行客服为您进行操作！如果您自行结算所造成任何问题，您需自行承担责任，为此带来的不便，敬请谅解！路路行7x24小时客服热线：400-821-8973
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="CruiseLineID" value="<?= $param['crl']?>" />
                <input type="hidden" name="CruiseDestinationID" value="<?= $param['dst']?>" />
                <input type="hidden" name="SailingID" value="<?= $param['sal']?>" />
                <input type="hidden" name="ItineraryID" value="<?= $param['iti']?>" />
                <div class="mt10 pop_discount">
                    <p><strong>折扣查询</strong></p>
                    <p>如果您满足以下价格条件，请勾选符合的项目，或可享有特别优惠</p>
                    <p>&nbsp;</p>
                    <p>查看美国居民特别优惠</p>
                    <p>如果旅客中有美国居民，请选择她/他所属的州/省，以查看是否有符合居民特别费率。</p>
                    <div class="mt5 d235">
                        <div class="showseat" id="Jseat_add">
                            <em>选择州/省</em>
                            <input type="hidden" data-num="statecode" name="StateCode">
                            <ul class="isOut_d" onmouseover="isOut=false" onmouseout="isOut=true">
                                <?php foreach ($states as $state) {
                                    if ($state['country_code'] != 'US') continue;
                                ?>
                                <li><a data-code="<?= $state['state_code']?>"><?= $state['state_name']?></a></li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                    <div class="mt20">
                        <p>查看老人特别优惠</p>
                        <p><label><input type="checkbox" name="IsSenior" value="1"><span class="ml10">同行人员中有年满55岁的乘客</span></label></p>
                    </div>
                    <!--<div class="mt20">
                        <p>请指明您是否为旧乘客，我们才能替您查看现有的折扣票价。</p>
                        <p>返程乘客<input class="ml10" type="text" name=""></p>
                    </div>-->
                    <div class="mt20">
                        <p>查看航空公司雇员及其直系亲属可享受的折扣价格。不同邮轮公司的优惠条件或有不同（限定条件适用）。</p>
                        <p><label><input type="checkbox" name="IsInterline" value="1"><span class="ml10">联运</span></label></p>
                    </div>
                    <div class="mt20">
                        <p>查看荣誉军人及其直系亲属的专享折扣价格（限定条件适用）。</p>
                        <p><label><input type="checkbox" name="IsMilitary" value="1"><span class="ml10">美国军人</span></label></p>
                    </div>
                </div>
                <div class="mt10 btn clearfix">
                    <a href="/cruise/view/<?= $itinerary['viewCode']?>" class="btn_back"><返回更改出发日期</a>
                    <a href="javascript:;" onclick="doSelectPeople();" class="btn_next">继续</a>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="select_Win">
    <div class="select_icon">
        <span class="p00"></span>
        <span class="p01"></span>
        <span class="p02"></span>
    </div>
    <div class="select_text">小路正在帮你查询邮轮最优惠的价格,请稍后哦</div>
</div>
<div class="bg_layer" id="bg_layer"></div>
<script type="text/javascript" language="javascript">
    var GuestAge_state = <?= $itinerary['line']['tc_line_PassengerAgeMandatory']?>;
    <?php $this->beginBlock('js_view') ?>
    $(document).ready(function(){
        /*表单下拉*/
        $("[id*='Jseat']").live('click', function () {
            $(this).find("ul").slideToggle("fast");
        });
        $("[id*='Jseat']").find("a").live('click', function () {
            var text = $(this).html();
            var _ipt = $(this).parents("[id*='Jseat']").find("input");
            var _id = _ipt.attr("id");
            var _name = _ipt.data("name");
            var _maxGuest = <?= $itinerary['line']['tc_line_MaxGuestPerCabin']?>;
            if(_ipt.data("num") == 'statecode'){
                _ipt.val($(this).data("code"));
                $(this).parents("[id*='Jseat']").find("em").html(text);
            }else{
                _ipt.val(text);
            };
            if(_ipt.data("num") == 'num' && GuestAge_state == true){
                var htl = "";
                for (var i = 1; i <= $("#"+_id).val(); i++) {
                    htl +="<div class='mt10 clearfix'><div class='pop_adult'><span>"+_name+i+"--年龄：</span><div class='showseat' id='Jseat_adult'><input type='text' class='GuestAge' name='Ages[Age][][GuestAge]' placeholder='选择' readonly=''><ul class='isOut_d' onmouseover='isOut=false' onmouseout='isOut=true'><?php for($i = 18; $i < 100; $i++) {?><li><a><?= $i?></a></li><?php }?></ul></div><div class='pop_tips GuestAge_tips'></div></div></div>";
                }
                $("#"+_id+"_add").html(htl);
            };
            if(_ipt.data("num") == 'num2' && GuestAge_state == true){
                var htl = "";
                for (var i = 1; i <= $("#"+_id).val(); i++) {
                    htl +="<div class='mt10 clearfix'><div class='pop_adult'><span>"+_name+i+"--年龄：</span><div class='showseat' id='Jseat_adult'><input type='text' class='GuestAge' name='Ages[Age][][GuestAge]' placeholder='选择' readonly=''><ul class='isOut_d' onmouseover='isOut=false' onmouseout='isOut=true'><?php for($i = 0; $i < 18; $i++) {?><li><a><?= $i?></a></li><?php }?></ul></div><div class='pop_tips GuestAge_tips'></div></div></div>";
                }
                $("#"+_id+"_add").html(htl);
            };
            if(_ipt.data("num") == 'num'){
                var hm = "";
                var _hmdd = _maxGuest - parseInt(_ipt.val());
                for (var i = 0; i <= _hmdd; i++) {
                    hm +="<li><a>"+i+"</a></li>";
                }
                $("#ChildNum_ul").html(hm);
            };
            if(_ipt.data("num") == 'num2'){
                var hm = "";
                var _hmdd = _maxGuest - parseInt(_ipt.val());
                for (var i = 1; i <= _hmdd; i++) {
                    hm +="<li><a>"+i+"</a></li>";
                }
                $("#AdultsNum_ul").html(hm);
            };
        });
    });
    // 表单提交--移动元素  
    function moveHtml(id){  
        var scroll_offset = $("." + id).offset().top;  
        $("body,html").animate({  
            scrollTop : scroll_offset
        }, 500);  
    } 
    function doSelectPeople() {
        var done = true;
        if (!$("#AdultsNum").val()) {
            $("#AdultsNum").addClass('input_error');
            $("#AdultsNum_tips").html("请选择人数").show();
            done = false;
        }else{
            $("#AdultsNum").removeClass('input_error');
            $("#AdultsNum_tips").html("").hide();
        }
        $(".GuestAge").each(function(){
            if (!$(this).val()) {
                $(this).addClass('input_error');
                $(this).parents(".pop_adult").find(".GuestAge_tips").html("请选择年龄").show();
                done = false;
            }else{
                $(this).removeClass('input_error');
                $(this).parents(".pop_adult").find(".GuestAge_tips").html("").hide();
            }

        });
        var maxGuest = <?= $itinerary['line']['tc_line_MaxGuestPerCabin']?>;
        if(parseInt($("#AdultsNum").val())+parseInt($("#ChildNum").val())> maxGuest){
            $(".tips_num_peop").addClass("input_error").html("**出行人数不能大于"+maxGuest+"人").show();
            done = false;
        }else{
            $(".tips_num_peop").removeClass("input_error").html("").hide();
        }
        
        if (done) {
            $(".select_Win").show();
            $(".bg_layer").show();
            document.forms.numForm.submit();
        }else{
            moveHtml("input_error");
        }
    }
    var isOut=true;
    document.onmousedown=function(){
        if($(".isOut_d").attr("display") != "none" && isOut == true )  {
            $(".isOut_d").hide();
        }
    };
    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['js_view'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>