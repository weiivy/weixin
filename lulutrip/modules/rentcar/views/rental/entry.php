<link href="<?= Yii::$app->helper->getFileUrl('/css/rentcar/entry.css'); ?>" rel="stylesheet">
<link href="<?= Yii::$app->helper->getFileUrl('/css/rentcar/foundation-datepicker.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="http://www.jq22.com/jquery/font-awesome.4.6.0.css">

<script src="<?= Yii::$app->helper->getFileUrl('/js/rentcar/jquery-slider.js') ;?>"></script>
<script src="<?= Yii::$app->helper->getFileUrl('/js/rentcar/entry.js') ;?>"></script>
<script src="<?= Yii::$app->helper->getFileUrl('/js/rentcar/foundation-datepicker.js') ;?>"></script>
<script src="<?= Yii::$app->helper->getFileUrl('/js/rentcar/locales/foundation-datepicker.zh-CN.js') ;?>"></script>

<!-- TODO 租车列表页 html -->
<div class="main">
	<div class="top"></div>
	<div class="ent-contain">
		<!-- 筛选信息 -->
		<div class="ent-fliter">
			<form action="">
				<div class="fliter-section">
					<div class="ent-section">
						取车地点
						<select required class="sel-01" id="pLc">
                            <?php foreach($location as $value):?>
	                        <option value="<?= $value['id']?>" <?php if($value['id'] == $param['pLc']):?> selected <?php endif;?>><?= $value['agency_name']?></option>
                            <?php endforeach;?>
	                    </select>
					</div>
					<div class="ent-section">
						还车地点
						<select required class="sel-01" id="rLc">
                            <?php foreach($location as $value):?>
                                <option value="<?= $value['id']?>" <?php if($value['id'] == $param['rLc']):?> selected <?php endif;?>><?= $value['agency_name']?></option>
                            <?php endforeach;?>
	                    </select>
					</div>
					<div class="ent-section ent-section-02">
						当地取车时间
						<input  value="<?= $param['pDate']?>" id="dpd1" class="btnPo pDate">
                        <select id="pTime" class="sel-02">
                            <?php for($t=0; $t<48; $t++):?>
                                <option <?php if($t == $param['pt']):?>selected<?php endif;?> value="<?= $t?>"><?php echo date('H:i', strtotime('00:00')+$t*30*60)?></option>
                            <?php endfor;?>
                        </select>
					</div>
					<div class="ent-section ent-section-02">
						当地还车时间
						<input  value="<?= $param['rDate']?>" id="dpd2" class="btnPo rDate">
                        <select id="rTime" class="sel-02">
                            <?php for($t=0; $t<48; $t++):?>
                                <option <?php if($t == $param['rt']):?>selected<?php endif;?> value="<?= $t?>"><?php echo date('H:i', strtotime('00:00')+$t*30*60)?></option>
                            <?php endfor;?>
                        </select>
					</div>
					<div class="btn-submit">立即搜索</div>
			    </div>
			    <div class="fliter-chx">
			    	<span class="car-style">车型:</span>
                    <label class="each-3-hot  each-3-hot-01">
                        <input type="checkbox" name="type" class="chk-01"><span class="chk-btn chk-submit <?php if(in_array(0, $param['type'])):?>on<?php endif;?>" type="0">全部</span>
                    </label>
                    <?php foreach ($carModel as $key => $val):?>
			    	<label class="each-3-hot each-3-hot-02">
                       <input type="checkbox" name="type" class="chk-01"><span class="chk-btn <?php if(!in_array($key, $selected['carType'])):?>btn-hide<?php else:?>chk-submit <?php endif;?> <?php if(in_array($key, $param['type'])):?>on<?php endif;?>" type="<?= $key?>"><?= $val?></span>
                    </label>
                    <?php endforeach;?>

			    </div>
                <div class="fliter-chx">
                    <span class="car-style">座位:</span>
                    <label class="each-3-hot each-3-hot-03">
                        <input type="checkbox" name="seat" class="chk-01"><span class="chk-btn chk-submit <?php if(in_array(0, $param['seat'])):?>on<?php endif;?>" seat="0">全部</span>
                    </label>
                    <?php foreach ($carSeat as $key => $val):?>
                        <label class="each-3-hot each-3-hot-04">
                            <input type="checkbox" name="seat" class="chk-01"><span class="chk-btn <?php if(!in_array($key, $selected['seatType'])):?>btn-hide<?php else:?>chk-submit <?php endif;?> <?php if(in_array($key, $param['seat'])):?>on<?php endif;?>" seat="<?= $key?>"><?= $val?></span>
                        </label>
                    <?php endforeach;?>

                </div>
			</form>			
		</div>
		<!-- 产品列表 -->
		<div class="ent-pro">
			<!-- 产品详情 -->
            <?php $showTag = [4,8,9]; if (!empty($list)):?>
                <?php foreach($list as $key => $value):?>
                    <?php if($param['page'] ==1 && $key == 3 && !empty($banners)):?>
                        <div class="product-ad" style="height:90px;">
                            <div class="ad-list" id="productadWrapper">
                                <ul style="width: 2790px; left: 0px;">
                                    <?php foreach($banners as $banner):?>
                                        <li style="width: 930px;"><a href="<?=$banner['link']?>" target="_blank"><img width="930" height="90" src="<?= Yii::$app->helper->getImgDomain()?>/<?=$banner['pic']?>"></a></li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                            <div class="ctrl-btn1" id="ctrlBtn">
                                <?php foreach($banners as $index => $banner):?>
                                    <span <?php if($index == 0):?>class="on"<?php endif;?>></span>
                                <?php endforeach;?>

                            </div>
                        </div>
                    <?php endif;?>

			        <div class="pro-list <?php if($param['page'] == 1  && $key <= 2):?>mask<?php endif;?>">
                        <div class="pt-img">
                            <a href="<?= Yii::$app->params['service']['www'] . $value['link'] . '2'?>" target="_blank">
                                <?php if($value['tag_discount'] > 0):?>
                                    <span>
                                        <b><?= (10-$value['tag_discount'])*10?>%</b>
                                        OFF
                                    </span>
                                <?php elseif($param['page'] == 1  && $key <= 2):?>
                                    <span class="tuijian">推荐产品</span>
                                <?php endif;?>

                                <img src="<?= Yii::$app->helper->getImgDomain() . '/' . $value['rentCarModel']['image']?>" alt="">
                            </a>
                        </div>
                        <div class="pt-price">
                            <a href="<?= Yii::$app->params['service']['www'] . $value['link'] . '2'?>" target="_blank">
                                <div class="pt-tit"><?=$value['title']?></div>
                                <ul class="tag-list">
                                    <!--折扣-->
                                    <?php if(isset($value['tags']['discount']) && !empty($value['tags']['discount'])):?>
                                        <?php foreach($value['tags']['discount'] as $discount):if(in_array($discount['display'], $showTag)):?>
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
                                    <?php if(isset($value['tags']['service']) && !empty($value['tags']['service'])):?>
                                        <?php foreach($value['tags']['service'] as $service):if(in_array($service['display'], $showTag)):?>
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
                                    <?php if(isset($value['tags']['promotion']) && !empty($value['tags']['promotion'])):?>
                                        <?php foreach($value['tags']['promotion'] as $promotion): ?>
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
                                <div class="pt-det">
                                    <p>品牌：<?= $value['rentCarModel']['make']?></p>
                                    <p>车型：<?= $value['rentCarModel']['model']?></p>
                                    <p>座位数： <?= $value['rentCarModel']['seats']?>人</p>
                                    <p>行李数：<?= $value['rentCarModel']['luggage']?></p>
                                </div>
                            </a>
                       </div>
                       <div class="pt-money">
                         <a href="<?= Yii::$app->params['service']['www'] . $value['link'] . '2'?>" class="pt-link">查看详情</a>
                         <div class="pt-price-parent">
                             <p class="pt-sign"><span><?= Yii::$app->params['curCurrencies']['sign']?> </span><span class="lg"> <?= $value['price']['2']['minprice'][Yii::$app->params['curCurrency']]?></span>起 / 天</p>
                             <?php if($param['pLc'] != $param['rLc']):?>
                                <div class="pt-price-warn">含异地还车费</div>
                             <?php endif;?>
                         </div>
                       </div>
                </div>
                <?php endforeach;?>
            <?php endif;?>
            <!-- 分页 -->
            <div class="bottom_pagenum">
                <div style="margin-left: -241.5px;" class="bg_navs">
                    <?= $pageData?>
                </div>
            </div>
		</div>
		<!-- 右侧广告栏 -->
		<div class="ent-adv">
			<div>
				<img src="<?= Yii::$app->helper->getFileUrl('/images/rentcar/ent-img-02.jpg')?>" alt="">
			</div>
            <a href="<?= Yii::$app->params['service']['www'] . '/tickets/entry/region-US_cat-tag1703'?>" target="_blank">
                <img src="<?= Yii::$app->helper->getFileUrl('/images/rentcar/theme_tickets.jpg')?>" alt="">
            </a>
            <a href="<?= Yii::$app->params['service']['www'] . '/tickets/entry/region-US_cat-tag1701'?>" target="_blank">
                <img src="<?= Yii::$app->helper->getFileUrl('/images/rentcar/traffic_tickets.jpg')?>" alt="">
            </a>
            <a href="<?= Yii::$app->params['service']['www'] . '/tickets/entry_cat-tag1709'?>" target="_blank">
                <img src="<?= Yii::$app->helper->getFileUrl('/images/rentcar/show_tickets.jpg')?>" alt="">
            </a>
			<a href="<?= Yii::$app->params['service']['www'] . '/private/tour_book/type-tour'?>" target="_blank">
				<img src="<?= Yii::$app->helper->getFileUrl('/images/rentcar/ent-img-03.jpg')?>" alt="">
			</a>
			<a href="<?= Yii::$app->params['service']['www'] . '/private/bus/region-NA'?>" target="_blank">
				<img src="<?= Yii::$app->helper->getFileUrl('/images/rentcar/ent-img-04.jpg')?>" alt="">
			</a>
            <?php if(Yii::$app->ip->getLocation(Yii::$app->ip->realIP())['country_en'] == 'CN') {
                $url = 'http://video.cdn.lulutrip.com/ippvideo/kxzc_480p.mp4';
            }else {
                $url = 'https://www.youtube.com/watch?v=QAUr8_BmSWw';
            }?>
            <a href="<?= $url?>" target="_blank">
                <img src="<?= Yii::$app->helper->getFileUrl('/images/rentcar/ent-img-01.jpg')?>" alt="">
            </a>
		</div>
	</div>
</div>