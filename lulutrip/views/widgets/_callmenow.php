<link href="<?= Yii::$app->helper->getFileUrl('/css/callmenow.css')?>" rel="stylesheet">
<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/callmenow.js')?>"></script>
<div class="callmenow" rel="init" <?= !empty($right) ? $right : ''; ?>>
<!--一键包团，个性化定制，包车。分区域：显示微信号-->
<?php if (isset($isWeixin) && $isWeixin == 1 && $callmenowRegion == 'NA'): ?>
<div class="webchat">
    <img class="nothover" src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/webchat.png')?>">
    <div class="hover">
        <div class="num">lulutripna</div>
        <div class="text">美洲行程顾问为您提供一对一专业规划！</div>
    </div>
</div>
<?php elseif (isset($isWeixin) && $isWeixin == 1 && $callmenowRegion == 'EU') :?>
<div class="webchat">
    <img class="nothover" src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/webchat.png')?>">
    <div class="hover">
        <div class="num">lulutripeu</div>
        <div class="text">欧洲行程顾问为您提供一对一专业规划！</div>
    </div>
</div>
<?php endif ?>


<!--<div class="fr cont">
<a class="call_btn fr f16 fs1" href="javascript:call_btn();">路路回电</a>
<div class="call_cont fr" onmouseover="isOut_call=false" onmouseout="isOut_call=true">
<a class="call_tel fr" href="javascript:call_btn();"></a>
<div class="call_text fl">
    <div class="call_name fl" onclick="call_select();"><span class="mr5">选择国家</span><b class="arrow-top"></b></div>
    <div class="call_input fl"><input type="text"></div>
</div>
<?php /*if(!empty($phoneAreaCodes)):*/?>
    <div class="call_name_show" style="display: none;" onmouseover="isOut_call=false" onmouseout="isOut_call=true">
        <ul>
            <?php /*foreach($phoneAreaCodes as $area => $code): */?>
            <li><span><?/*=$area*/?></span><i><?/*=$code*/?></i></li>
            <?php /*endforeach*/?>
        </ul>
        <em>&nbsp;</em>
    </div>
<?php /*endif;*/?>
<div class="call_text_on fl" style="display: none;"><span>美国</span></div>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>-->


<div class="call_share" style="display: none;">
    <div class="call_bg">
        <div class="con">选择国家后，留下你的电话，我们会立刻回复哦！</div>
        <div class="down"><div class="arrow_down"></div></div>
    </div>
</div>
<div class="clear"></div>
</div>