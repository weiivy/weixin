<?php
use yii\helpers\Html;
?>
<link href="<?= Yii::$app->helper->getFileUrl('/css/ptour/ptour.css'); ?>" rel="stylesheet">
<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/ptour/ptour.js') ;?>"></script>
<div class="main">
    <div class="main1">
        <div class="w1200">
            <div class="info">
                <h2><?= Html::decode($product['tourmaintitle_cn'])?></h2>
                 <p><span class="code">产品编号： ptourcode-<?= $product['ptourcode']?></span><span>出发城市：<?= implode('、', $product['tourstartcity'])?></span><span>结束城市：<?= implode('、', $product['tourendpoint'])?></span></p>
            </div>
            <div class="money">
                <p><span class="lg"><?= Yii::$app->params['curCurrencies']['sign']?> <?= $product['averageprices'][Yii::$app->params['curCurrency']]?></span>/人起</p>
                <?php if(!empty($product['toursubtitle_cn'])):?>
                    <div class="dask">
                        <span class="open">起价说明</span>
                        <div class="pop-up">
                            <?= Html::decode($product['toursubtitle_cn'])?>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
    <div class="main2">
        <div class="w1200">
            <div class="m2-lf">
              <div class="big-slider-sm">
                  <div class="bgImg">
                      <ul class="big-img-sm">
                          <?php foreach($product['photos'] as $num => $photo):?>
                              <li <?php if($num == 0):?>class="current"<?php endif;?>>
                                  <img src="<?= Yii::$app->helper->getImgDomain() . "/" . $photo['image']?>" alt="">
                                  <p><?= $photo['caption_cn']?></p>
                              </li>
                          <?php endforeach;?>
                      </ul>
                  </div>
                  <div class="sm-img">
                      <ul class="list-sm">
                          <?php foreach($product['photos'] as $num => $photo):?>
                            <li index="<?= $num+1 ?>" <?php if($num == 0):?>class="on"<?php endif;?>><img src="<?= Yii::$app->helper->getImgDomain() . "/" . $photo['thumb']?>" alt=""></li>
                          <?php endforeach;?>
                      </ul>
                      <?php if(count($product['photos']) > 5):?>
                          <span class="arr arr-left"></span>
                          <span class="arr arr-right"></span>
                      <?php endif;?>
                  </div>
              </div>
            </div>
            <div class="m2-rg">
                <div class="txt"><?= Html::decode($product['tourmainsummary_cn'])?></div>
                <div class="feature">
                    <div class="title">产品特色</div>
                    <div class="panel">
                        <ul class="contant">
                           <?= Html::decode($product['toursubsummary_cn'])?>
                        </ul>
                    </div>
                    <div class="btn">
                        <span class="btn-top"></span>
                        <span class="btn-down"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main3">
        <div class="w1200 clearF">
            <div class="m3-lf">
                <div class="m3-nav">
                    <ul class="jusitfy ula">
                        <li class="" id="m1"><b></b>行程详情</li>
                        <li class="" id="m2"><b></b>费用包含/不包含</li>
                        <li class="" id="m3"><b></b>预订须知</li>
                    </ul>
                </div>
                <div class="m3-container">
                    <div class="m1">
                        <div class="c-title">
                            <h3>行程详情</h3>
                            <p class="c-hide">行程展开</p>
                        </div>

                        <?php foreach($itis as $dayNo => $iti):?>
                            <div class="day" id="main<?= $dayNo?>">
                                <div class="D-title">
                                    <p class="tag">Day <span><?= $dayNo?></span></p>
                                    <p class="pro-tit"><?= Html::decode($iti['title_cn'])?></p>
                                </div>
                                <div class="D-panel">
                                    <?php if(isset($iti['scenes'])):?>
                                         <div class="D-slider">
                                            <ul class="D-list">
                                                <?php foreach($iti['scenes'] as $scene):?>
                                                    <li>
                                                        <img src="<?= Yii::$app->helper->getImgDomain() . '/'.$scene['thumb'] ?>" alt="">
                                                        <p><?= $scene['scenename_cn']?>(<?= $scene['scenename_en']?>)</p>
                                                    </li>
                                                <?php endforeach;?>
                                            </ul>
                                            <?php if(count($iti['scenes']) > 3):?>
                                                <span class="D-go D-goLf"></span>
                                                <span class="D-go D-goRg"></span>
                                            <?php endif;?>
                                        </div>
                                    <?php endif;?>
                                     <div class="D-txt">
                                         <?php if(!empty($iti['scenes'])): $scenes = array_column($iti['scenes'], 'scenename_cn')?>
                                             <p class="D-P1">前往景点：<?php foreach($scenes as $key => $scene):?><span><?= $scene?> <?php if(($key+1) < count($scenes)):?><b></b><?php endif;?></span><?php endforeach;?></p>
                                         <?php endif;?>
                                         <?php if(!empty($iti['hotels'])):?> <p>酒店住宿： <?= $iti['hotels']?> </p><?php endif;?>
                                         <?php if(!empty($iti['cars'])):?><p>车型： <?= $iti['cars']?> </p><?php endif;?>
                                         <div class="D-feat">
                                             <p>行程简介： </p>
                                             <div> <?= Html::decode($iti['itdesc_cn'])?></div>
                                         </div>
                                     </div>
                                </div>
                            </div>
                        <?php endforeach;?>


                    </div>
                    <div class="m2">
                        <div class="c-title">
                            <h3>费用说明</h3>
                        </div>
                        <div class="c-det">
                            <?= Html::decode($product['tourpriceterms_cn'])?>
                        </div>
                    </div>
                    <div class="m3">
                        <div class="c-title">
                            <h3>注意事项</h3>
                        </div>
                        <div class="c-det">
                            <?= Html::decode($product['tournotes_cn'])?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m3-rg">
                <div class="r-title">
                    <p class="r-p"><span>人均</span><span class="money"><?= Yii::$app->params['curCurrencies']['sign']?> <?= $product['averageprices'][Yii::$app->params['curCurrency']]?></span></p>
                </div>
                <div class="m3-r-panel">
                    <p class="panel-p2">全球7x4小时客服电话 </p>
                    <p class="panel-p3"><?= \Yii::$app->helper->getCustomerServicePhone(); ?></p>
                    <p class="two-code">
                        <img src="<?= Yii::$app->helper->getFileUrl('/images/pour/code.png')?>" alt="">
                    </p>
                    <p class="panel-p4">扫描二维码，添加微信咨询定制信息</p>
                    <p class="panel-p1"><a href="<?= Yii::$app->params['service']['www'] ?>/private/tour_book/ptourcode-<?= $product['ptourcode'] ?>" target="_blank">马上订购</a></p>
                </div>
            </div>
        </div>
    </div>
    <div id="side-bar" class="side-bar" style="display: none;">
        <div class="sidebar-nav">
            <?php foreach($itis as $dayNo => $value):?>
            <a href="javascript:;" id="main<?= $dayNo?>Btna" class="side_btn">
                <b></b>
                <s></s>
                第<?= $dayNo?>天
            </a>
            <?php endforeach;?>
        </div>
    </div>
</div>