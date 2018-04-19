<?php
use lulutrip\components\Helper;
use yii\helpers\Html;
$cookies = Yii::$app->request->cookies;
?>
<link href="<?= Yii::$app->helper->getFileUrl('/css/cruise.css')?>" rel="stylesheet">
<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/cruise/selected_berth_grade.js') ;?>"></script>
<div id="main" style="background-color:#eee; width:100%; min-width:1200px;">
    <div id="body_14" style="padding-bottom:40px;">
        <div class="bread_navs"> 
            <a href="http://www.lulutrip.com" class="check_more">首页</a>&gt; 选择出行日期 &gt; 选择客舱类别
        </div>
        <div class="cruise_selected clearfix">
            <div class="text">
                <h2 class="f18"><?php if ($itinerary['Itinerary']['NameCN']) {echo $itinerary['Itinerary']['NameCN'];} else {echo $itinerary['Itinerary']['Name'];}?></h2>
                <div class="mt20">
                    <p><span class="fc66">邮轮公司：</span><?php if ($itinerary['LineNameCN']) {echo $itinerary['LineNameCN'];} else {echo $itinerary['CruiseLineName'];}?></p>
                    <p><span class="fc66">邮轮：</span><?php echo $itinerary['ShipName']; ?><img src="<?= Yii::$app->helper->getFileUrl('/images/cruise/dest_star' . $itinerary['ShipRating'] . '.png')?>"></p>
                </div>
                <?php
                foreach ($itinerary['SailingDates']['Sailing'] as $item) {
                    if ($item['SailingID'] != $param['SailingID']) continue;
                    ?>

                    <div class="mt20">
                        <p><span class="fc66">出发时间：</span><?php echo $item['Departure']?></p>
                        <p><span class="fc66">结束时间：</span><?php echo $item['Arrival'];?></p>
                    </div>
                    <div class="mt20">
                        <p><span class="fc66">出发港口：</span><?php echo $itinerary['DeparturePortName'];?></p>
                        <p><span class="fc66">旅客：</span><?php echo $param['AdultsNum']; ?> 成人，<?php echo $param['ChildNum'];?> 儿童</p>
                    </div>
                    <?php
                    break;
                }?>
            </div>
            <div class="mt40 list">
                <h2 class="f18 mb20">选择舱位等级</h2>
                <div class="list_check_detail">
                    <div class="list_checked clearfix">
                        <div class="wrap clearfix">
                            <div class="list_checked_li clearfix">
                                <ul>
                                    <?php foreach ($NavigationBar as $index => $navList): ?>
                                    <li class="<?php if($index == 0){echo 'on';} ?>">
                                        <span class="name"><?=$navList['cabinCategoryName'] ?></span>
                                        <span class="price"><?= Yii::$app->params['curCurrencies']['sign'] . ceil($navList['minPrice'][Yii::$app->params['curCurrency']] / ($param['AdultsNum'] + $param['ChildNum']))?>起/人</span>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="list_checked_text">
                                <strong>舱位说明:</strong>大多轮船提供以下四种类型的客舱：内舱、海景舱（带舷窗或窗户）、海景阳台舱和套间。 内舱没有窗户，通常最小而且最便宜；然而套间往往设有大型私人阳台，通常最大而且最昂贵。
                            </div>
                        </div>
                    </div>
                    <div class="list_detail">
                        <?php foreach ($cabincat as $key => $catList): ?>
                        <div class="list_detail_li">
                            <h3>
                                <?php
                                    switch ($key){
                                        case '1':
                                            echo '内舱房';
                                            break;
                                        case '2':
                                            echo '海景房';
                                            break;
                                        case '3':
                                            echo '阳台房';
                                            break;
                                        case '4':
                                            echo '豪华套房';
                                            break;
                                }
                                ?>
                            </h3>
                            <?php foreach ($catList as $cat): ?>
                            <div class="list_cont">
                                <div class="list_top clearfix">
                                    <div class="fl img"><img width="260" height="156" src="<?php if (isset($cat['Img'])) {echo $cat['Img'];} else {}?>"></div>
                                    <div class="fr name">
                                        <div class="clearfix">
                                            <div class="fl">
                                                <h2 class="f16"><?= $cat['TypeName']?></h2>
                                                <p class="mt5">甲板：<?= $cat['DeckName']?></p>
                                            </div>
                                            <div class="fr ar">
                                                <p><strong class="f20 fc60"><?= Yii::$app->params['curCurrencies']['sign'] . ceil($cat['Prices']['CabinCategoryPrice'][0]['PricePublish'][Yii::$app->params['curCurrency']] / ($param['AdultsNum'] + $param['ChildNum']))?></strong></p>
                                                <p class="fc88">每位旅客</p>
                                            </div>
                                        </div>
                                        <div class="mt10"><?php if (isset($cat['Description'])) {echo $cat['Description'];}?></div>
                                    </div>
                                </div>
                                <div class="mt20 list_price">
                                    <table width="100%">
                                        <tbody>
                                        <tr>
                                            <th width="580">价格类型</th>
                                            <th width="200">每位旅客</th>
                                            <th width="200">客舱价格</th>
                                            <th></th>
                                        </tr>
                                        <?php foreach ((array)$cat['Prices']['CabinCategoryPrice'] as $price): ?>
                                            <tr>
                                                <td><?= $price['PriceTitle']?><p class="fc88">* 费用包括港口费但不包括税</p></td>
                                                <td><?= Yii::$app->params['curCurrencies']['sign'] . ceil($price['PricePublish'][Yii::$app->params['curCurrency']] / ($param['AdultsNum'] + $param['ChildNum']))?></td>
                                                <td><span class="f20 fb"><?= Yii::$app->params['curCurrencies']['sign'] . $price['PricePublish'][Yii::$app->params['curCurrency']]?></span></td>
                                                <td><a class="btn" onclick="doBerthgrade()" href="<?php if($cat['needToSelectCabin']) {echo '/cruise/select/cabin?' . $price['nextUrl'];} else {echo '/cruise/add_to_cart?' . $price['nextUrl'];}?>">选择</a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="select_Win">
    <div class="select_icon">
        <span class="p00"></span>
        <span class="p01"></span>
        <span class="p02"></span>
    </div>
    <div class="select_text">小路正在帮你查询邮轮客舱号码,请稍后哦</div>
</div>
<div class="bg_layer" id="bg_layer"></div>