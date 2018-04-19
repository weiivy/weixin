<?php if(isset($purchases['endtime']) && strtotime($purchases['endtime']) > time()):?>
    <div id="limit-spike" class="limit-spike">
        <div class="wrap" id="ls-tab">
            <ul class="ls-sel tab-menu" id="ls-sel">
                <?php foreach($purchases as $key => $value):?>
                    <?php if ($key == 'endtime') continue; ?>
                    <li class="ls-sel-li <?= $key == '热门'? 'current' : ''?>"><?=$key ?><span></span></li>
                <?php endforeach;?>
            </ul>
            <div class="ls-tit">
                <h2>秒杀活动<b>进行中</b></h2>
                <div><span id="J-endtime" data-time="<?=$purchases['endtime']?>" class="txt-cd">离秒杀结束还有</span><b class="group-day">-</b>天<b class="group-hour">-</b>小时<b class="group-minute">-</b>分<b class="group-second">-</b>秒<span class="fb"><input type="hidden" name="date_format" class="date_format" value="<?= date("Y/m/d H:i:s", time())?>"></span></div>
            </div>
            <div class="ls-con tab-box">
                <?php foreach($purchases as $key => $value):?>
                    <?php if ($key == 'endtime') continue; ?>
                    <div class="ls-con-ul <?= $key=='热门' ? 'ls-con-active' : ''?>">
                        <div class="ls-con-detail">
                            <a href="javascript:;" class="left-go ls-go"></a>
                            <a href="javascript:;" class="right-go ls-go"></a>
                            <div class="ls-detail-show">
                                <ul class="ls-con-list">
                                    <?php if(!empty($value)): $i=0;?>
                                    <?php foreach($value as $con): if(empty($con['product'])) continue;?>
                                        <li class="ls-con-pro">
                                            <a href="<?= $con['product']['link']?>" target="_blank">
                                                <?php if(!empty($con['product']['grp_discount'])):?>
                                                    <div class="tip"><span><?= $con['product']['grp_discount'] . '%'?></span>OFF</div>
                                                <?php endif;?>
                                                <div class="ls-pro-img">
                                                    <img class="<?php if($key == '热门'&& $i < 5): $i++?>lazy<?php else:?>lazy-hide<?php endif;?>" src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/preload_l.gif'?>" data-original="<?= $con['product']['tf_cover'] ?>" width="278" height="184">
                                                    <i></i>
                                                </div>
                                                <div class="ls-pro-de">
                                                    <p class="ls-pro-tit"><?= \yii\helpers\Html::decode($con['product']['tourtitle_cn']) ?></p>
                                                    <div class="ls-pro-action">
                                                        <div class="action-left">
                                                            <span><i><?= Yii::$app->params['curCurrencies']['sign'] ?></i><?=ceil($con['product']['prices']['min'][Yii::$app->params['curCurrency']]*(100-$con['product']['grp_discount'])*0.01)?></span><span class="small"><i><?= Yii::$app->params['curCurrencies']['sign']?></i><?= $con['product']['prices']['min'][Yii::$app->params['curCurrency']]?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endforeach;?>
                                    <?php endif;?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
<?php endif;?>