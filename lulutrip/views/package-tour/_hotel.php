<div class="hotelDetail_iframe" style="display:none;" id="hotelDetail_iframe">
    <div class="pos">
        <?php if(!empty($photos)):?>
            <div class="hotel_image">
                <?php foreach($photos as $key => $value):?>
                    <div <?php if($key != 0):?>style="display:none"<?php endif;?> id="hotel_image_d_<?= $key+1?>" class="hotel_image_d"><img style="width:434px; height:288px;" src="<?= Yii::$app->helper->getImgDomain()?>/<?php if(!empty($value['image'])):?><?= $value['image']?><?php else:?>images/no_pic.jpg<?php endif;?>" alt="<?= $value['caption_cn']?>"></div>
                <?php endforeach;?>
                <div class="hotel_img_navs">
                    <div class="fl ml5">
                        <a class="ico_sceneimg" id="ico_preHotelimg" href="javascript:;" style="cursor: default;"><img src="<?= Yii::$app->helper->getFileUrl('/images/index_14/bg_pre_ico.png')?>"></a>
                    </div>
                    <div class="fr mr5">
                        <a class="ico_sceneimg" id="ico_nextHotelimg" href="javascript:;" style="cursor: default;"><img src="<?= Yii::$app->helper->getFileUrl('/images/index_14/bg_next_ico.png')?>"></a>
                    </div>
                    <div class="navsbar">
                        <ul>
                            <?php foreach($photos as $k => $val):?>
                            <li><a <?php if($k == 0):?>class="cur_img"<?php endif;?> href="javascript:changeHotelImages(<?= $k+1?>);"><img style="width:89px; height:59px;" src="<?= Yii::$app->helper->getImgDomain()?>/<?php if(!empty($val['image'])):?><?= $val['thumb']?><?php else:?>images/no_pic.jpg<?php endif;?>" alt="<?= $val['caption_cn']?>"></a></li>
                            <?php endforeach;?>
                        </ul>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div><!--end hotel_image-->
        <?php endif;?>
        <div class="f18 n_fc08 mt20">
            <?= $hotel['hfullname_cn']?><img src="<?= Yii::$app->helper->getFileUrl('/images/icon_stars_' . $hotel['star'] . '.gif')?>" class="ml5">
        </div>
        <div class="mt10"><?= $hotel['hoteldesc_cn']?></div>
        <div class="mt10 fs2 n_fc01 f12"><!--服务：免费接送机、免费早餐、免费WIFI<br />-->
            地址：<?= $hotel['address']?><br>
            电话：<?= $hotel['telephone']?></div>
    </div>
    <div class="close_icon2">
        <a href="javascript:hideMoreIframe('hotelDetail');">×</a>
    </div>
</div>