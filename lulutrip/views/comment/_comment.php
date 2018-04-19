<?php
use lulutrip\components\Helper;
use yii\helpers\Html;
?>
<div class="group_evaluation g_eva">
    <div>
        <div class="fl info_left">
            <img src="<?= Yii::$app->helper->getFileUrl('/images/index_14/group_evaluation_tit.gif')?>" />
            <div class="ac f18 mt10">用户评价</div>
        </div>
        <div class="fr info_right">
            <?php if(!empty($tourComms)):?>
            <?php foreach($tourComms as $value):?>
                <div class="customer_ev">
                    <div class="fl d80">
                        <?php if($value['avatar']):?>
                            <div class="ac"><img style="height:71px; width:71px; border-radius:35px;"  src="<?= Yii::$app->helper->getImgDomain()?>/<?= $value['avatar']?>"></div>
                        <?php else:?>
                            <div class="ac"><img style="height:71px; width:71px; border-radius:35px;"  src="<?= Yii::$app->helper->getFileUrl("/images/my_profile/file_img" . rand(1,4) . ".jpg")?>"></div>
                        <?php endif;?>
                        <div class="f14 ac mt5"><?= Html::decode($value['screenname'])?></div>
                    </div>
                    <div class="fl customer_ev_right">
                        <div class="m20">
                            <div>
                                <div class="fl f14"><?= Html::decode($value['subject'])?></div>
                                <div class="fl ml10 fs2"><?php if($type == 'tour'):?>旅行团<?php elseif($type == 'package'):?>标准化包团<?php elseif($type == 'bus'):?>包车<?php endif;?>评分<img class="ml5" src="<?= Yii::$app->helper->getFileUrl('/images/icon_stars_' . $value["ratings"]["scenery"] . '.gif')?>"/></div>
                                <div class="fl ml10 fs2">Lulutrip评分<img class="ml5" src="<?= Yii::$app->helper->getFileUrl('/images/icon_stars_' . $value["ratings"]["lulutrip"] . '.gif')?>"></div>
                                <div class="clear"></div>
                            </div>
                            <div class="mt10 lh25 fs2"><?= Html::decode($value['content'])?></div>
                        </div>
                        <div class="ico_arrow_left"><img src="<?= Yii::$app->helper->getFileUrl('/images/index_14/ico_jiantou_left2.gif')?>"/></div>
                    </div>
                    <div class="clear"></div>
                </div><!--end customer_ev-->
                <?php if(!empty($value['reply'])):?>
                    <div class="lulu_custom">
                        <div class="fr lulu_head">
                            <div class="ac"><img src="<?= Yii::$app->helper->getFileUrl('/images/index_14/lulu_custom_head.gif')?>"/></div>
                            <div class="f14 ac mt5">路路行客服</div>
                        </div>
                        <div class="fr lulu_custom_right">
                            <div class="m20">
                                <div class="mt10 lh25 fs2"><?= Html::decode($value['reply'])?></div>
                            </div>
                            <div class="ico_arrow_right"><img src="<?= Yii::$app->helper->getFileUrl('/images/index_14/ico_jiantou_right.gif')?>"/></div>
                        </div>
                        <div class="clear"></div>
                    </div><!--end lulu_custom-->
                <?php endif;?>
            <?php endforeach;?>
            <?php else:?>
            <div class="customer_ev">暂无团友评价</div>
            <?php endif;?>

        </div>
        <div class="clear"></div>
    </div>  <!--end 分页以上-->
    <?php if($pageData):?>
    <div class="bottom_pagenum tony-mt20">
        <div class="bg_navs">
            <div class="fl numbers">
                <?= $pageData?>
                <div class="fl skip_page">
                    <?php if($type == 'tour'):?>
                        <label>到 <input type="text" id="tour_view_tourcomment_pageto" /> 页</label><input type="button" onClick="get_tourcomment(-1);" class="ml10" value="确认" />
                    <?php elseif($type == 'package'):?>
                        <label>到 <input type="text" id="package_view_packagecomment_pageto" /> 页</label><input type="button" onClick="get_packagecomment(-1);" class="ml10" value="确认" />
                    <?php elseif($type == 'bus'):?>
                        <label style="display: inline-block;">到 <input type="text" id="bus_view_buscomment_pageto" /> 页</label><input type="button" onClick="get_buscomment(-1);" class="ml10" value="确认" />
                    <?php endif;?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div><!--end bottom_pagenum-->
    <?php endif;?>
    <div class="h50"></div>
</div>

<script type="text/javascript" language="javascript">
    <?php $this->beginBlock('js_comment') ?>
    $(function(){
       $(".bottom_pagenum .bg_navs").each(function() {
           var width=$(this).width();
           var mlnum=-(width/2);
           $(this).css({
               marginLeft: mlnum,
               left: '50%'
           });
       }); 
    });
    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['js_comment'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>
</div>
