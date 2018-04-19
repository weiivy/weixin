<div class="hm-sub-cols">
    <?php if(in_array($keyName, ['加拿大', '美国'])) {foreach($regionArr['hover'] as $hotName => $hoverContent):?>
        <div class="col">
            <?php if(!empty($hoverContent['url'])) {?>
                <a href="<?= Yii::$app->params['service']['www']?><?= $hoverContent['url']?>" target="_blank"
                   class="col-tit"><?= $hotName ?></a>
            <?php }else{?>
                <span class="col-tit"><?= $hotName ?></span>
            <?php }?>
            <?php foreach($hoverContent['child'] as $children): ?>
                <div class="col-list">
                    <?php foreach($children as $content): ?>
                        <a href="<?= Yii::$app->params['service']['www']?><?= $content['url']?>" target="_blank"
                           <?php if(!empty($content['class'])):?>class="hot"<?php endif;?>><?= $content['name']?></a>
                    <?php endforeach;?>
                </div>
            <?php endforeach;?>
        </div>
    <?php endforeach;}?>
</div>

<?php if($keyName == '美国'):?>
<div class="hm-sub-hotplay" style="position: relative;">
    <div class="hotplay-tit">
        热门玩法
    </div>
    <ul class="hotplay-list clearfix">
        <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-NA_f-5500" target="_blank">2018年倒数团</a><span class="icon-play hot-play">HOT</span></li>
        <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-NA_f-5368" target="_blank">热辣迈阿密</a><span class="icon-play hot-play">HOT</span></li>
        <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/id-858_s-77" target="_blank">小众目的地新奥尔良</a><span class="icon-play new-play">NEW</span></li>
        <li><a href="<?= Yii::$app->params['service']['www']?>/themes/alaskan_aurora" target="_blank">阿拉斯加极光热抢</a><span class="icon-play hot-play">HOT</span></li>
        <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-USWest_f-5676" target="_blank">海岸星光号免费游美西</a></li>
        <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-US_c-SFO?minday=1&maxday=4" target="_blank">旧金山周边游</a></li>
        <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-US_c-LAS?minday=1&maxday=3" target="_blank">拉斯维加斯周边游</a></li>
        <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-Hawaii_s-118_f-2021?isshowline=-1" target="_blank">夏威夷火山岛探险</a></li>
        <li><a href="<?= Yii::$app->params['service']['www']?>/rental-car/entry" target="_blank">中文租车,自驾一号公路</a><span class="icon-play new-play">NEW</span></li>
    </ul>
    <a href="<?= Yii::$app->params['service']['www']?>/rental-car/entry" target="_blank" style="position: absolute; top: -111px; left: 213px;"><img src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/rent_car.gif'?>" ></a>
    <a href="<?= Yii::$app->params['service']['www']?>/rental-car/entry" target="_blank" style="position: absolute; top: -135px; left: 183px;"><img src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/rent_car.gif'?>" ></a>
    <a href="<?= Yii::$app->params['service']['www']?>/rental-car/entry" target="_blank" style="position: absolute; top: -158px; left: 183px;"><img src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/rent_car.gif'?>" ></a>
</div>

<?php elseif($keyName == '加拿大'):?>
    <div class="hm-sub-hotplay">
        <div class="hotplay-tit">
            热门玩法
        </div>
        <ul class="hotplay-list clearfix">
            <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-USEast_f-75" target="_blank">美加两国超值游</a></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-CA_c-YYZ_f-1355" target="_blank">入住《鬼怪》同款城堡酒店</a></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-NA_f-3561" target="_blank">环游加拿大</a><span class="icon-play new-play">NEW</span></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-CA_c-YVR?minday=1&maxday=3" target="_blank">温哥华周边游</a></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/themes/canada" target="_blank">燃情落基山</a><span class="icon-play hot-play">HOT</span></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-CA_f-5388" target="_blank">落基山峡谷走冰</a><span class="icon-play new-play">NEW</span></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-CA_f-20" target="_blank">冬季抄底入住城堡酒店</a><span class="icon-play hot-play">HOT</span></li>
        </ul>
    </div>
<?php elseif($keyName == '异域探奇'):?>
    <div class="hm-sub-hotplay">
        <div class="hotplay-tit">
            热门玩法
        </div>
        <ul class="hotplay-list clearfix big">
            <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-Alaska_s-921" target="_blank">阿拉斯加夏季北极特快列车</a><span class="icon-play hot-play">HOT</span></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/promotion/Africa_rg-KYA" target="_blank">非洲动物大迁徙</a><span class="icon-play new-play">NEW</span></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-Hawaii_f-3057?isshowline=-1" target="_blank">大岛梦幻探险</a><span class="icon-play new-play">NEW</span></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-MEX_d-1_s-299" target="_blank">花样姐姐林志玲同款行程</a><span class="icon-play hot-play">HOT</span></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/id-299" target="_blank">坎昆渡假玛雅金字塔</a></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/id-299_f-3269?isshowline=-1" target="_blank">坎昆豪华5星全包酒店，舒享无忧</a><span class="icon-play hot-play">HOT</span></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-PR" target="_blank">见证《少年派的奇幻漂流》荧光海</a><span class="icon-play hot-play">HOT</span></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/search/tour_f-3657?keyword=%E5%9D%8E%E6%98%86" target="_blank">坎昆超值5天度假只要$400+，天天出团</a></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/id-3173" target="_blank">独家古巴探秘</a></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-Hawaii_s-118_f-2021?isshowline=-1" target="_blank">火山岛灵感之旅</a><span class="icon-play hot-play">HOT</span></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/activity/entry/region-MEX" target="_blank">热！墨西哥自由行</a></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/activity/entry/region-LA_sc-741" target="_blank">新！巴西自由行</a></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/tour/destination/id-3173" target="_blank">畅游古巴: 发现哈瓦那之美</a><span class="icon-play hot-play">HOT</span></li>
            <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-Hawaii_f-2171?isshowline=-1" target="_blank">夏威夷机+酒</a><span class="icon-play hot-play">HOT</span></li>
        </ul>
    </div>
<?php endif;?>
<?php if(in_array($keyName, ['美国'])): ?>
    <div class="hm-sub-icon">
        <a href="<?= Yii::$app->params['service']['www']?>/visa/search/ct-POI_30096" target="_blank"><span
                class="icon-all icon-small icon-small-1"></span>签证</a>
        <a href="<?= Yii::$app->params['service']['www']?>/activity/entry_cat-tag1703" target="_blank"><span
                class="icon-all icon-small icon-small-2"></span>主题乐园</a>
        <a href="<?= Yii::$app->params['service']['www']?>/promotion/uscruise" target="_blank"><span
                class="icon-all icon-small icon-small-3"></span>邮轮</a>
        <a href="<?= Yii::$app->params['service']['www']?>/tickets/entry" target="_blank"><span
                class="icon-all icon-small icon-small-4"></span>门票</a>
    </div>
<?php elseif(in_array($keyName, ['加拿大'])): ?>
    <div class="hm-sub-icon">
        <a href="<?= Yii::$app->params['service']['www']?>/visa/search/ct-POI_30096" target="_blank"><span
                class="icon-all icon-small icon-small-1"></span>签证</a>
        <a href="<?= Yii::$app->params['service']['www']?>/promotion/uscruise" target="_blank"><span
                class="icon-all icon-small icon-small-3"></span>邮轮</a>
        <a href="<?= Yii::$app->params['service']['www']?>/tickets/entry" target="_blank"><span
                class="icon-all icon-small icon-small-4"></span>门票</a>
    </div>
<?php endif;?>