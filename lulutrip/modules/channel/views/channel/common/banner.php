<!-- banner -->
<?php if(!empty($mainBanner)):?>
    <div class="banner">
        <div class="banner-wrapper" id="bannerWrapper">
            <ul class="banner-list">
                <?php foreach($mainBanner as $bigBanner):?>
                    <li>
                        <a href="<?= $bigBanner['content']['link']?>" target="_blank" style="background: url(<?= Yii::$app->helper->getImgDomain()?>/<?= $bigBanner['content']['image']?>) 50% 50% no-repeat"></a>
                    </li>
                <?php endforeach;?>
            </ul>
            <div class="ctrl-btn" id="ctrlBtn">
                <?php foreach($mainBanner as $key => $value):?>
                <span <?php if($key+1 == 1):?>class="on"<?php endif;?>></span>
                <?php endforeach;?>
            </div>
            <div class="exchange-arrow">
                <span class="exchange-btn" id="prev"></span>
                <span class="exchange-btn" id="next"></span>
            </div>
        </div>
    </div>
<?php endif;?>
<!-- 顶部公告 -->
<?php if(!empty($notice)):?>
    <div id="topnotice" class="topnotice">
        <div class="wrap">
            <?php if($notice['type'] == 2):?>
                <marquee id="affiche" align="left" behavior="scroll" direction="left" height="30" width="1200" loop="-1" scrollamount="10" scrolldelay="100" onmouseout="this.start()" onmouseover="this.stop()" >
                    <div><?=$notice['content']?><?php if(!empty($notice['redirect_url'])):?><a href="<?=$notice['redirect_url']?>" target="_blank"><?=$notice['redirect_title']?></a><?php endif;?></div>
                </marquee>
            <?php elseif($notice['type'] == 1):?>
                <p><?=$notice['content']?><?php if(!empty($notice['redirect_url'])):?><a href="<?=$notice['redirect_url']?>" target="_blank"><?=$notice['redirect_title']?></a><?php endif;?><?php if(!empty($notice['code_image'])):?>或<a href="javascript:;" id="topnotice-weixin"><?=$notice['code_title']?><i class="icon-style" style="width:73px;height: 93px;margin-left: -36px;"><img width="73" height="93" src="<?=$notice['code_image']?>"></i></a><?php endif;?>与我们联系，给您带来不便，敬请谅解！</p>
            <?php endif;?>
        </div>
    </div>
<?php endif;?>
<!-- banner下广告栏 -->
<div id="hot-adv" class="hot-adv clearfix ">
    <div class="wrap">
        <ul <?php if(count($subBanner) == 2):?>class="big" <?php endif;?>>
            <?php foreach($subBanner as $value):?>
                <li>
                    <a href="<?= $value['link']?>" target="_blank">
                        <i></i>
                        <img src="<?= Yii::$app->helper->getImgDomain();?>/<?= $value['pic']?>"/>
                    </a>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>