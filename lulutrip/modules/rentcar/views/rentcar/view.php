<link href="<?= Yii::$app->helper->getFileUrl('/css/rentcar/view.css'); ?>" rel="stylesheet">
<link href="<?= Yii::$app->helper->getFileUrl('/css/rentcar/foundation-datepicker.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="http://www.jq22.com/jquery/font-awesome.4.6.0.css">

<script src="<?= Yii::$app->helper->getFileUrl('/js/rentcar/jquery-slider.js') ;?>"></script>
<script src="<?= Yii::$app->helper->getFileUrl('/js/rentcar/view.js') ;?>"></script>
<script src="<?= Yii::$app->helper->getFileUrl('/js/rentcar/foundation-datepicker.js') ;?>"></script>
<script src="<?= Yii::$app->helper->getFileUrl('/js/rentcar/locales/foundation-datepicker.zh-CN.js') ;?>"></script>
<script type="text/javascript">

</script>
<!-- TODO 租车详情页 html -->
<div class="main">
    <div class="wd1200">
        <div class="view-bread-navs">
            <a href="" target="_blank">首页 </a> >
            <a href="" target="_blank">北美旅游 </a> >
            <a href="" target="_blank">租车  </a> >
            <a href="" target="_blank">旧金山租车全自驾自由行</a>
        </div>
        <?php if(!empty($car)):?>
        <div class="view-pro">
            <div class="view-pro-detail">
                <div class="pro-bgTitle"><?php if($param['days']) echo $param['days'] . '天 - '; ?><?= $car['title']?></div>
                <div class="pro-smTitle"><?= $car['itin_highlights']?></div>
                <div class="pro-tip"></div>
                <div class="pro-money">
                    <span><?= Yii::$app->params['curCurrencies']['sign']?><?= $car['minprice'][Yii::$app->params['curCurrency']]?></span>起/车
                </div>
            </div>
            <div class="view-pro-panel">
                <div class="view-panel-img">
                    <ul class="tag-list">

                        <!--折扣-->
                        <?php $showTag=[6,8,9];  if(isset($car['tags']['discount']) && !empty($car['tags']['discount'])):?>
                            <?php foreach($car['tags']['discount'] as $discount):if(in_array($discount['display'], $showTag)):?>
                                <li class="tag-red">
                                    <?= $discount['name'];?>
                                    <div class="llt-tips">
                                        <p class="inner-content">
                                            <i class="l-arrow"></i> <?= $discount['desc'];?></p>
                                    </div>
                                </li>
                            <?php endif;endforeach;?>
                        <?php endif;?>

                        <!--附加服务-->
                        <?php if(isset($car['tags']['service']) && !empty($car['tags']['service'])):?>
                            <?php foreach($car['tags']['service'] as $service):if(in_array($service['display'], $showTag)):?>
                                <li>
                                    <?= $service['name'];?>
                                    <div class="llt-tips">
                                        <p class="inner-content">
                                            <i class="l-arrow"></i><?= $service['desc'];?></p>
                                    </div>
                                </li>
                            <?php endif;endforeach;?>
                        <?php endif;?>

                        <!--促销标签-->
                        <?php if(isset($car['tags']['promotion']) && !empty($car['tags']['promotion'])):?>
                            <?php foreach($car['tags']['promotion'] as $promotion): ?>
                                <li class="<?php if($promotion['display'] == '红色'){echo 'tag-red';} ?>">
                                    <?= $promotion['content'];?>
                                    <div class="llt-tips">
                                        <p class="inner-content">
                                            <i class="l-arrow"></i><?= $promotion['describe'];?></p>
                                    </div>
                                </li>
                            <?php endforeach;?>
                        <?php endif;?>
                    </ul>
                    <div class="view-panel-actImgs">
                        <ul class="view-panel-tour_images">
                            <li class="tour_image_d active"><a href="">
                                <?php if($car['tag_discount'] > 0):?>
                                    <span>
                                        <b><?= (10-$car['tag_discount'])*10?>%</b>OFF
                                    </span>
                                <?php endif;?>
                                    <img src="<?= Yii::$app->helper->getImgDomain() ?>/<?= $car['rentCarModel']['image']?>">
                                </a></li>
                        </ul>
                        <div class="view-panel-navs-act">
                            <div class="view-panel-navbar">
                                <ul>
                                    <li class="on"><img src="<?= Yii::$app->helper->getImgDomain() ?>/<?= $car['rentCarModel']['image']?>"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="view-panel-order">
                    <form action="http://api.lulu.com/rentcat/price" method="post" id="myform">
                        <div class="pick-up">
                            <div class="pick-up-address-get">
                                <span class="sp-wid">取车地点：</span>
                                <select name="pickUpLoction" required class="pick-up-sel postAjax" id="pickUpLocation">
                                    <option value="0"></option>
                                    <?php foreach($location as $lc):?>
                                    <option value="<?= $lc['id']?>" <?php if($lc['id'] == $param['pLc']):?> selected <?php endif;?>><?= $lc['agency_name']?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="pick-up-address-repay">
                                <span class="sp-wid">还车地点：</span>
                                <select name="returnLocation" required class="pick-up-sel postAjax" id="returnLocation">
                                    <option value="0"></option>
                                    <?php foreach($location as $lc):?>
                                        <option value="<?= $lc['id']?>" <?php if($lc['id'] == $param['rLc']):?> selected <?php endif;?>><?= $lc['agency_name']?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="car-time">
                            <div class="car-time-get">
                                <span class="sp-wid">取车日期：</span>
                                <input name="pickUpDate" type="" value="<?= $param['pDate']?>" id="dpd1" class="btnPo">
                                <select name="pickUpTime" id="pickUpTime" class="postAjax">
                                    <?php for($t=0; $t<48; $t++):?>
                                    <option <?php if($t == $param['pt']):?>selected<?php endif;?> value="<?= $t?>"><?php echo date('H:i', strtotime('00:00')+$t*30*60)?></option>
                                    <?php endfor;?>
                                </select>
                            </div>
                            <div class="car-time-repay">
                                <span class="sp-wid">还车日期：</span>
                                <input type="text" name="returnDate" value="<?= $param['rDate']?>" id="dpd2" class="btnPo">
                                <select name="returnTime" id="returnTime" class="postAjax">
                                    <?php for($t=0; $t<48; $t++):?>
                                        <option <?php if($t == $param['rt']):?>selected<?php endif;?> value="<?= $t?>"><?php echo date('H:i', strtotime('00:00')+$t*30*60)?></option>
                                    <?php endfor;?>
                                </select>
                            </div>

                        </div>
                        <div class="view-insurance">
                            <span class="sp-wid">选择保险：</span>
                            <div class="rad">
                                <input type="radio" name="insurance" value="2" <?php if(Yii::$app->request->get('in') == 2):?>checked="" <?php endif;?> class="postAjax"><span>车损盗抢险 </span>
                            </div>
                            <div class="rad">
                                <input type="radio" name="insurance" value="3" <?php if(Yii::$app->request->get('in') == 3):?>checked="" <?php endif;?> class="postAjax"><span>升级为全险</span>
                                <div class="llt-tips">
                                    <p class="inner-content">
                                        <i class="l-arrow"></i>
                                        <span>车辆碰撞险，车辆在正常租赁驾驶期间由于发生碰撞事故产生的损失将由保险公司负责赔偿。</span>
                                        <span>车辆盗抢险，车辆在正常租赁驾驶期间被盗、被抢，或因被盗抢造成的车辆损坏，将由保险公司负责赔偿。</span>
                                        <span>百万三者险，在使用车辆过程中发生的意外事故，致使第三者遭受人身伤亡或财产直接损毁，保险公司负责赔偿，最高赔付100万美元。</span>
                                   </p>
                                </div>
                            </div>
                        </div>
                        <div class="baggage">
                            <div class="bag-car" style="width: 200px; font-size: 12px;"><b></b><span ><?= $car['rentCarModel']['make']?><?= $car['rentCarModel']['model']?><?= $car['rentCarModel']['year']?></span></div>
                            <div class="bag-seat" style="width: 120px;"><b></b><span>座位数： <?= $car['rentCarModel']['seats']?> </span> </div>
                            <div class="bag-bagg"><b></b><span><?= $car['rentCarModel']['luggage']?></span></div>
                        </div>
                        <div class="pro-cart">
                            <input type="hidden" id="id" value="<?= $car['id']?>" />
                            <input type="hidden" id="currency" value="<?= Yii::$app->params['curCurrency']?>" />
                            <div class="pro-num">
                                <div class="pro-price">
                                    总计 <span class="curreny"><?= Yii::$app->params['curCurrencies']['sign']?></span><span class="lg totalPrice">--</span>
                                </div>
                                <div class="pro-price-warn">(<span style="color: #333333" class="count"></span>，日均<?= Yii::$app->params['curCurrencies']['sign']?><span class="J-perPrice"></span>)</div>
                            </div>
                            <a class="morelink">立即订购</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="main-contant">
            <div class="cont-left">
                <div id="main1">
                    <div class="m-title">
                        <span class="active nav-list" index="0">秒租简介</span><span class="nav-list" index="1">租车流程&服务条款</span><span class="nav-list travel-to" index="2" data-idx="<?php if(empty($car['rentCarItinerary'])):?>false<?php endif;?>">行程推荐</span>
                    </div>
                    <div class="main-list">
                        <div class="m-panel">
                            <div class="zuche"></div>
                        </div>
                        <div class="m-panel">
                            <?php echo htmlspecialchars_decode($car['order_notice']);?>
                        </div>
                        <?php if(!empty($car['rentCarItinerary'])):?>
                            <div class="m-panel">
                                <?php foreach($car['rentCarItinerary'] as $key => $value):?>
                                <div class="m-txt">
                                    <div class="m-stit"><b class="m1-tit-bg-03"></b>行程推荐<?= $key+1?></div>
                                    <div class="m1-panel">
                                        <p>定制师：<?= $value['designer']?></p>
                                        <p>推荐适应人群：<?= $value['suitable_people']?></p>
                                        <p>用户心得：<?= $value['highlights']?></p>
                                    </div>
                                </div>
                                <div class="m-route parent-line">
                                    <?php foreach($car['rentCarItineraryDaily'] as $day):?>
                                        <?php if($value['itinerary_id'] == $day['itinerary_id']):?>
                                        <div class="m-route-h">
                                            <span>Day </span><span class="lg"><?= $day['day']?></span><?= $day['title']?>
                                        </div>
                                        <div class="m-scenic">
                                            前往景点：
                                            <?php if(!empty($day['scenename'])):?>
                                            <?php foreach($day['scenename'] as $num => $name):?>
                                            <span <?php if($num == 0):?>class="sc-icon"<?php endif;?>><?= $name?></span>
                                            <?php endforeach;?>
                                            <?php endif;?>
                                        </div>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                </div>
                                <?php endforeach;?>
                            </div>
                        <?php endif;?>
                    </div>
                    
                </div>
            </div>
            <div class="cont-right">
                <div class="panel-item panel-item-01">
                    <a href="" target="_blank">
                        <img src="<?= Yii::$app->helper->getFileUrl('/images/rentcar/car-rg-img-01.png')?>" alt="">
                    </a>
                </div>
                <div class="panel-item panel-item-02">
                    <a href="<?= Yii::$app->params['service']['www'] . '/private/tour_book/type-tour'?>" target="_blank" class="item-a">个性定制入口</a>
                </div>
                <div class="panel-item panel-item-03">
                    <a href="<?= Yii::$app->params['service']['www'] . '/private/bus'?>" target="_blank" class="item-a">了解包车服务</a>
                </div>
            </div>
        </div>
        <?php else:?>
        产品不存在
        <?php endif;?>
    </div>
</div>
