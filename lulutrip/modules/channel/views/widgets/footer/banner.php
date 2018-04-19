<?php if(Yii::$app->controller->regionRoot == 'AU') {?>
    <?php if(\Yii::$app->controller->id == 'tour-list'): ?>
        <div class="open-btm-banner" id="J-btm-open">
            <div class="banner-close-pic" style="width:182px;height:133px;background-image: url(//llt.quimg.com/llt-static/images/common/foot-banner/australia/open_0207.png);"></div>
        </div>
        <div class="pop-btm-banner" id="J-btm-banner" style="height:110px;">
            <a href="javascript:;" class="close" title="关闭" id="J-btm-close" style="top: 10px;"></a>
            <a href="<?= Yii::$app->params['service']['www'] ?>/tour/destination/region-AU_f-5834" target="_blank">
                <div class="banner-pic" style="background-image: url(//llt.quimg.com/llt-static/images/common/foot-banner/australia/banner_0207.jpg);"></div>
            </a>
        </div>
    <?php elseif(\Yii::$app->controller->id == 'channel'): ?>
        <div class="open-btm-banner" id="J-btm-open">
            <div class="banner-close-pic" style="width:182px;height:133px;background-image: url(//llt.quimg.com/llt-static/images/common/foot-banner/australia/open_0207.png);"></div>
        </div>
        <div class="pop-btm-banner" id="J-btm-banner" style="height:110px;">
            <a href="javascript:;" class="close" title="关闭" id="J-btm-close" style="top: 10px;"></a>
            <a href="<?= Yii::$app->params['service']['www'] ?>/tour/destination/region-AU_f-5834" target="_blank">
                <div class="banner-pic" style="background-image: url(//llt.quimg.com/llt-static/images/common/foot-banner/australia/banner_0207.jpg);"></div>
            </a>
        </div>
    <?php endif; ?>
<?php }elseif(Yii::$app->controller->regionRoot == 'NA') {?>
    <?php if(date('Y-m-d H:i:s', time()) > '2017-11-25 00:00:00'):?>
        <div class="open-btm-banner" id="J-btm-open">
            <div class="banner-close-pic" style="width:137px;height:100px;background-image: url(//llt.quimg.com/llt-static/images/common/foot-banner/america/open_02082.png);"></div>
        </div>
        <div class="pop-btm-banner" id="J-btm-banner" style="height:110px;">
            <a href="javascript:;" class="close" title="关闭" id="J-btm-close" style="top: 10px; margin-left: 565px;"></a>
            <a href="<?= Yii::$app->params['service']['www'] ?>/specials/springbreak#g=oz" target="_blank">
                <div class="banner-pic" style="background-image: url(//llt.quimg.com/llt-static/images/common/foot-banner/america/banner_02082.jpg);"></div>
            </a>
            <!-- <div style="position: absolute; width: 334px; height: 62px; top: 24px; left: 50%; margin-left: 124px;">
                <a href="<?= Yii::$app->params['service']['www'] ?>/tour/north_america/region-USEast" target="_blank" style="display: block; float: left; height: 22px; margin-bottom:18px; width: 75px; margin-right: 16px;"></a>
                <a href="<?= Yii::$app->params['service']['www'] ?>/tour/destination/id-7?isshowline=-1" target="_blank" style="display: block; float: left; height: 22px; margin-bottom:18px; width: 105px; margin-right: 17px;"></a>
                <a href="<?= Yii::$app->params['service']['www'] ?>/tour/destination/id-8?isshowline=-1" target="_blank" style="display: block; float: left; height: 22px; margin-bottom:18px; width: 104px;"></a>
                <a href="<?= Yii::$app->params['service']['www'] ?>/tour/north_america/region-CA" target="_blank" style="display: block; float: left; height: 22px; width: 106px; margin-right: 15px;"></a>
                <a href="<?= Yii::$app->params['service']['www'] ?>/tour/north_america/region-USEast_c-IAH" target="_blank" style="display: block; float: left; height: 22px; width: 106px; margin-right: 15px;"></a>
                <a href="<?= Yii::$app->params['service']['www'] ?>/tour/destination/id-21" target="_blank" style="display: block; float: left; height: 22px; width: 92px;"></a>
            </div> -->
        </div>
    <?php endif;?>
<?php }elseif(Yii::$app->controller->regionRoot == 'EU') {?>
    <?php if(date('Y-m-d H:i:s', time()) > '2017-11-25 00:00:00'):?>
        <div class="open-btm-banner" id="J-btm-open">
            <div class="banner-close-pic" style="width:170px;height:110px;background-image: url(//llt.quimg.com/llt-static/images/common/foot-banner/europe/open_0301.png);"></div>
        </div>
        <div class="pop-btm-banner" id="J-btm-banner" style="height:110px;">
            <a href="javascript:;" class="close" title="关闭" id="J-btm-close" style="top: 10px;"></a>
            <a href="<?= Yii::$app->params['service']['www'] ?>/tour/destination/region-EUSouth" target="_blank">
                <div class="banner-pic" style="background-image: url(//llt.quimg.com/llt-static/images/common/foot-banner/europe/banner_0301.jpg);"></div>
            </a>
        </div>
    <?php endif;?>
<?php } ?>