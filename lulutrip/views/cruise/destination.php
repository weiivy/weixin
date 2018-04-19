<?php
use lulutrip\components\Helper;
use yii\helpers\Html;
$cookies = Yii::$app->request->cookies;
?>
<link href="<?= Yii::$app->helper->getFileUrl('/css/cruise.css')?>" rel="stylesheet">
<link href="<?= Yii::$app->helper->getFileUrl('/css/jquery.tooltips.css')?>" rel="stylesheet">
<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/cruise/jquery.tooltips.js') ;?>"></script>
<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/cruise/destination.js') ;?>"></script>
<div id="main" style="background-color:#eee; width:100%; min-width:1200px;">
    <div id="body_14" style="padding-bottom:40px;">
        <div class="bread_navs">
            <a href="http://www.lulutrip.com" class="check_more">首页</a> &gt; <a href="/cruise">美加邮轮</a>
        </div>
        <?= \common\widgets\Alert::widget()?>
        <div class="cruise_home clearfix">
            <div class="cruise_left">
                <?= Yii::$app->view->renderFile('@lulutrip/views/cruise/_form.php', ['destination' => $destination, 'dep' => $dep, 'tod' => $tod, 'length' => $length, 'line' => $line, 'port' => $port, 'filter' => $filter, 'selectedFilter' => $selectedFilter, 'newFilter' => $newFilter, 'selected' => $selected, 'param' => $param, 'sort' => $sort, 'num' => $num]);?>
                <div class="mt20 cruise_new">
                    <div class="tit">邮轮攻略</div>
                    <div class="cont">
                        <ul>
                            <li><a target="_blank" href="http://article.lulutrip.com/view/id-10007">史上最详细的全球邮轮签证办理条件在这，世界各国邮轮签证要求一览</a></li>
                            <li><a target="_blank" href="http://article.lulutrip.com/view/id-9617">另类地中海邮轮路线，带你走进静谧的世外桃源之旅</a></li>
                            <li><a target="_blank" href="http://article.lulutrip.com/view/id-9637">最美加勒比海邮轮旅游指南，跟随杰克船长寻找不老之泉水</a></li>
                            <li><a target="_blank" href="http://article.lulutrip.com/view/id-9341">豪华欧洲邮轮旅游路线 一张船票看遍欧洲春色</a></li>
                            <li><a target="_blank" href="http://article.lulutrip.com/view/id-9333">你的征途是星辰大海！意大利邮轮旅游让你吃喝玩乐一键get</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="cruise_right">
                <div class="dest_result clearfix">
                    <div class="fl">
                        <p><span>目的地：</span><?= $selected['dst']?></p>
                        <p><span>出发月份：</span><?= $selected['dep_day']?> - <?= $selected['tod_day']?></p>
                    </div>
                    <div class="fl ml50">
                        <p><span>邮轮旅程时间：</span><?= $selected['len']?></p>
                        <p><span>首选邮轮公司：</span><?= $selected['crl']?></p>
                    </div>
                </div>
                <div class="dest_sorts clearfix">
                    <div class="fl sortsseat" id="Jseat_price_sort">
                        <em>价格</em>
                        <ul class="isOut_d" onmouseover="isOut=false" onmouseout="isOut=true" style="width:120px;">
                            <li><a href="<?= '/cruise/search' . $sort['pa']?>">由低到高排序</a></li>
                            <li><a href="<?= '/cruise/search' . $sort['pd']?>">由高到低排序</a></li>
                        </ul>
                    </div>
                    <!--
                    <div class="fl sortsseat" id="Jseat_liner">
                        <em>邮轮</em>
                        <ul class="isOut_d" onmouseover="isOut=false" onmouseout="isOut=true" style="width:148px;">
                            <li><a>海达路德邮轮</a></li>
                            <li><a>峡湾快艇和邮轮</a></li>
                            <li><a>加勒比海邮轮</a></li>
                            <li><a>比斯坎湾观光邮轮</a></li>
                            <li><a>维京邮轮</a></li>
                            <li><a>诗丽雅邮轮</a></li>
                        </ul>
                    </div>
                    -->
                    <div class="fl text"><span class="fl4">共找到 <span class="f60"><?= $num?></span> 个产品</span>*价格为入住双人房间的单人支付价格及最低可供价格，费用包括港口费但不包括税。</div>
                </div>
                <div class="dest_list">
                    <?php foreach ($cruise as $item) {?>
                        <?php
                        $dateParam = [];
                        if(!empty($param['dep'])) {
                            $dateParam[] = 'dep=' . $param['dep'];
                        }
                        if(!empty($param['tod'])) {
                            $dateParam[] = 'tod=' . $param['tod'];
                        }
                        if(!empty($dateParam)){
                            $item['viewCode'] .= '?' . implode('&', $dateParam);
                        }
                        ?>
                    <div class="dest_list_li">
                        <div class="dest_list_top clearfix">
                            <div class="fl img"><a href="/cruise/view/<?= $item['viewCode']?>" target="_blank"><img width="260" height="156" src="<?= $item['tc_ship_img'];?>"></a></div>
                            <div class="fl text">
                                <a class="name" href="/cruise/view/<?= $item['viewCode']?>" target="_blank"><?php if ($item['touricoCruiseItinerary']['tc_itinerary_namecn']) {echo $item['touricoCruiseItinerary']['tc_itinerary_namecn'];} else {echo $item['touricoCruiseItinerary']['tc_itinerary_name'];}?></a>
                                <div class="star"><span>邮轮：</span><p><?= $item['tc_ship_name'];?><img src="<?= Yii::$app->helper->getFileUrl('/images/cruise/dest_star' . $item['tc_ship_rating'] . '.png')?>"></p></div>
                                <div class="star"><span>出发时间：</span><p><?php foreach ($item['Departure'] as $year => $mons) {echo $year . '年'; foreach ($mons as $mon => $day) {echo $mon . '月' . implode('日, ', $day) . '日 ';}}?></p></div>
                                <div class="more">
                                    <a href="/cruise/view/<?= $item['viewCode']?>#Setout" target="_blank">出发</a><a href="/cruise/view/<?= $item['viewCode']?>#Trip" target="_blank">行程</a><a href="/cruise/view/<?= $item['viewCode']?>#Port" target="_blank">港口</a><a href="/cruise/view/<?= $item['viewCode']?>" target="_blank">图片</a><a href="/cruise/view/<?= $item['viewCode']?>#Facilities" target="_blank">设施</a><a href="/cruise/view/<?= $item['viewCode']?>#Deck" target="_blank">甲板</a>
                                </div>
                            </div>
                            <div class="fr price">
                                <p><?= Yii::$app->params['curCurrencies']['sign']?><b><?= $item['tc_sailing_MIN_Price'][Yii::$app->params['curCurrency']]?></b></p>起
                                <div class="price_icon">
                                    <img src="<?= Yii::$app->helper->getFileUrl('/images/index_14/ico_help_01.gif')?>">
                                    <p class="text">此价格为两人一房情况下每人需支付的邮轮费用，且不含码头费，服务费和税费，最终价格会根据不同出发日期和房型而变化。</p>
                                </div>
                            </div>
                        </div>
                        <div class="dest_list_fot clearfix">
                            <div class="fl room">
                                <dl class="tit">
                                    <dt>&nbsp;</dt>
                                    <dd>内部客舱</dd>
                                    <dd>海景间</dd>
                                    <dd>阳台</dd>
                                    <dd>套间</dd>
                                </dl>
                                <dl>
                                    <dt><div class="text_logo pre"><img src="<?= $item['tc_line_logo'];?>"><div class="text_logo_h"><div class="text_logo_txt"><?= $item['touricoCruiseLine']['tc_line_name_cn'] . '<br>' . html_entity_decode($item['touricoCruiseLine']['tc_line_introduce'])?></div></div></div></dt>
                                    <dd><span><?php if (!isset($item['tc_sailing_IN_PricePublish'])) { echo 'N/A';} else {echo Yii::$app->params['curCurrencies']['sign'] . $item['tc_sailing_IN_PricePublish'][Yii::$app->params['curCurrency']];}?></span><?php if (!isset($item['tc_sailing_IN_PricePublish'])) { echo 'N/A';} else {echo Yii::$app->params['curCurrencies']['sign'] . ceil($item['tc_sailing_IN_PricePublish'][Yii::$app->params['curCurrency']] / $item['tc_itinerary_length']) . '每晚';}?></dd>
                                    <dd><span><?php if (!isset($item['tc_sailing_OV_PricePublish'])) { echo 'N/A';} else {echo Yii::$app->params['curCurrencies']['sign'] . $item['tc_sailing_OV_PricePublish'][Yii::$app->params['curCurrency']];}?></span><?php if (!isset($item['tc_sailing_OV_PricePublish'])) { echo 'N/A';} else {echo Yii::$app->params['curCurrencies']['sign'] . ceil($item['tc_sailing_OV_PricePublish'][Yii::$app->params['curCurrency']] / $item['tc_itinerary_length']) . '每晚';}?></dd>
                                    <dd><span><?php if (!isset($item['tc_sailing_BL_PricePublish'])) { echo 'N/A';} else {echo Yii::$app->params['curCurrencies']['sign'] . $item['tc_sailing_BL_PricePublish'][Yii::$app->params['curCurrency']];}?></span><?php if (!isset($item['tc_sailing_BL_PricePublish'])) { echo 'N/A';} else {echo Yii::$app->params['curCurrencies']['sign'] . ceil($item['tc_sailing_BL_PricePublish'][Yii::$app->params['curCurrency']] / $item['tc_itinerary_length']) . '每晚';}?></dd>
                                    <dd><span><?php if (!isset($item['tc_sailing_ST_PricePublish'])) { echo 'N/A';} else {echo Yii::$app->params['curCurrencies']['sign'] . $item['tc_sailing_ST_PricePublish'][Yii::$app->params['curCurrency']];}?></span><?php if (!isset($item['tc_sailing_ST_PricePublish'])) { echo 'N/A';} else {echo Yii::$app->params['curCurrencies']['sign'] . ceil($item['tc_sailing_ST_PricePublish'][Yii::$app->params['curCurrency']] / $item['tc_itinerary_length']) . '每晚';}?></dd>
                                </dl>
                            </div>
                            <div class="fr btn"><a href="/cruise/view/<?= $item['viewCode']?>" target="_blank">查看详情</a></div>
                        </div>
                        <?php if(!empty($item['tc_sailing_incentive']) && is_array($item['tc_sailing_incentive'])): ?>
                        <div class="dest_list_list clearfix">
                            <div class="list_tit"><img src="<?= Yii::$app->helper->getFileUrl('/images/cruise/icon_cuxiao.png')?>"></div>
                            <ul class="tag-list">
                                <?php foreach ($item['tc_sailing_incentive'] as $incentive): ?>
                                <?php if(!empty($incentive['Title'])): ?>
                                <li class="J-tagtips" data-group="<?php if(!empty($incentive['Description'])){echo $incentive['Description'];} ?>"><?= $incentive['Title']; ?></li>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php }?>

                </div>
                <div class="bottom_pagenum">
                    <div style="margin-left: -241.5px;" class="bg_navs">
                        <?= $naviPage?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>