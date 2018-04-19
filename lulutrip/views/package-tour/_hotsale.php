<?php
use yii\helpers\Html;
?>
<?php if(!empty($hotSales)):?>
<div class="tr4 pt_hotsale_data">
    <div class="title">热门包团定制产品</div>
    <div class="list">
        <ul>
            <?php $hsindex =1; foreach($hotSales as $value):?>
                <?php if($hsindex > ($curPage-1)*5 && $hsindex <= $curPage*5):?>
                <li>
                    <div class="fl number1"><?= $hsindex?></div>
                    <div class="fl list_d">
                         <a href="<?= $value['link']?>" class="check_more5"><?= Html::decode($value['packmaintitle_cn'])?></a>
                         <span class="n_fc13 ml"><span><?= Yii::$app->params['curCurrencies']['sign']?></span><?= $value['pack_lowprice'][Yii::$app->params['curCurrency']]?></span>
                    </div>
                     <div class="clear"></div>
                </li>
                <?php endif; $hsindex++;?>
            <?php endforeach;?>
        </ul>
    </div><!--end list-->
    <?php if($totalPage > 1):?>
    <div class="icon_pagenum">
        <div class="fl">
            <a href="javascript:get_hotpackagetours_data('<?= $prePage?>');" class="pre_page">&lt;</a>
        </div>
        <div class="fl cur_page">
            < <?= $curPage?> / <?= $totalPage?> >
        </div>
        <div class="fr">
            <a href="javascript:get_hotpackagetours_data('<?= $nePage?>');" class="next_page">&gt;</a>
        </div>
        <div class="clear"></div>
    </div><!--end icon_pagenum-->
    <?php endif;?>
</div><!--end tr4-->
<?php endif;?>