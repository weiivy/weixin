<?php
use lulutrip\components\Helper;
use yii\helpers\Html;
$cookies = Yii::$app->request->cookies;
?>
<link href="<?= Yii::$app->helper->getFileUrl('/css/cruise.css')?>" rel="stylesheet">
<link href="<?= Yii::$app->helper->getFileUrl('/css/jquery.tooltips.css')?>" rel="stylesheet">
<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/cruise/jquery.tooltips.js') ;?>"></script>
<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/cruise/view.js') ;?>"></script>
<div id="main" style="background-color:#eee; width:100%; min-width:1200px;">
    <div id="body_14" style="padding-bottom:40px;">
        <div class="bread_navs">
            <a href="http://www.lulutrip.com" class="check_more">首页</a> &gt; 邮轮详情页
        </div>
        <?= \common\widgets\Alert::widget()?>
        <div class="cruise_view">
            <div class="view_top">
                <div class="tit clearfix">
                    <h1 class="fl"><?php if ($itinerary['Itinerary']['NameCN']) {echo $itinerary['Itinerary']['NameCN'];} else {echo $itinerary['Itinerary']['Name'];}?></h1>
                    <div class="fr price">
                        <p><?= Yii::$app->params['curCurrencies']['sign']?><b><?= $itinerary['MinPrice'][Yii::$app->params['curCurrency']]?></b></p>起/人
                        <div class="dinb view_help"><i>?</i><div class="text">产品价格会根据您选的产品类型、件数及其他附加服务的不同而有所变动</div></div>
                    </div>
                </div>
                <div class="mt25 detail clearfix">
                    <div class="fl tour_image">
                        <?php if (isset($ship['shipGallery'])) {?>
                        <?php foreach ($ship['shipGallery'] as $key => $gallery) {?>
                        <div class="tour_image_d" id="tour_image_d_<?= $key + 1?>"><img width="590" height="400" src="<?= $gallery['big']?>"></div>
                        <?php }?>
                        <?php } else {?>
                        <div class="tour_image_d" id="tour_image_d_1"><img width="590" height="400" src="<?= $ship['shipImg']?>"></div>
                        <?php }?>
                        <div class="scene_img_navs" style="display: none;">
                            <div class="fl ml5">
                                <a href="javascript:;" id="ico_preimg" class="ico_sceneimg"><img src="<?= Yii::$app->helper->getFileUrl('/images/cruise/bg_pre_ico.png')?>"></a>
                            </div>
                            <div class="fr mr5">
                                <a id="ico_nextimg" class="ico_sceneimg" href="javascript:;"><img src="<?= Yii::$app->helper->getFileUrl('/images/cruise/bg_next_ico.png')?>"></a>
                            </div>
                            <div class="navsbar">
                                <ul>
                                    <?php if (isset($ship['shipGallery'])) {?>
                                    <?php foreach ($ship['shipGallery'] as $key => $gallery) {?>
                                    <li><a href="javascript:changeTourImages(<?= $key + 1?>);" class="<?php if($key == 0) {echo 'cru_img';}?>"><img width="89" height="59" src="<?= $gallery['small']?>"></a></li>
                                    <?php }?>
                                    <?php } else {?>
                                        <li><a href="javascript:changeTourImages(1);" class="cru_img"><img width="89" height="59" src="<?= $ship['shipImg']?>"></a></li>
                                    <?php }?>
                                </ul>
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                         </div>
                    </div>
                    <div class="fr feat">
                        <div class="text">
                            <?php if ($itinerary['Itinerary']['Feature']) {echo $itinerary['Itinerary']['Feature'];} else {echo '<div class="text_logo pre"><img src="' . $itinerary['CruiseLineLogo'] . '" /><div class="text_logo_h"><div class="text_logo_txt">' . $itinerary['line']['tc_line_name_cn'] . '<br>' . html_entity_decode($itinerary['line']['tc_line_introduce']) . '</div></div></div><div class="text_desc">' . $ship['tc_ship_desc'] . '</div>';}?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="view_foot mt20">
                <div class="cruise_nav">
                    <div class="navs_c">
                        <div class="wrap clearfix">
                            <ul class="fl">
                                <li class="on">出发</li>
                                <li>行程</li>
                                <li>港口</li>
                                <li>设施</li>
                                <li>甲板</li>
                                <li>预订须知</li>
                            </ul>
                            <span class="fr service">路路行7X24小时<a href="<?= Yii::$app->params['service']['www']?>/adviser/home/id-35" target="_blank">专属顾问服务</a></span>
                        </div>
                    </div>
                </div>
                <div class="cruise_cont">
                    <div class="cruise_cont_li clearfix" id="Setout">
                        <div class="cont_icon">
                            <i class="icon_01"></i>
                            <span>出发</span>
                        </div>
                        <div class="cont_right">
                            <div class="d275 clearfix">
                                <div class="fl d120">
                                    <div class="showseat input_date" id="Jseat_start_view">
                                        <input type="text" placeholder="任何时间" id="dep_date_view" readonly="" value="<?php if(isset($get['dep']) && $get['dep']) {echo $get['dep'];}?>">
                                        <ul class="isOut_d" onmouseover="isOut=false" onmouseout="isOut=true">
                                            <?php foreach ($newFilter['dep'] as $key => $value) :?>
                                            <li data-time="<?= $key ?>" class="dep_mon<?= substr($key, 0, 7)?>">
                                                <?php if (isset($value['isGrey']) && $value['isGrey'] == 1) :?>
<!--                                                <span class="disable">--><?//= $value['name']?><!--</span>-->
                                                <?php else:?>
                                                <a onclick="_viewrecord('dep','<?= $key?>','<?= $value['name']?>')"><?= $value['name']?></a>
                                                <?php endif;?>
                                            </li>
                                            <?php endforeach;?>

                                        </ul>
                                    </div>
                                </div>
                                <div class="fl txt">到</div>
                                <div class="fr d120">
                                    <div class="showseat input_date" id="Jseat_to_view">
                                        <input type="text" placeholder="任何时间" id="tod_date_view" readonly="" value="<?php if(isset($get['tod']) && $get['tod']) {echo $get['tod'];}?>">
                                        <ul class="isOut_d" onmouseover="isOut=false" onmouseout="isOut=true">
                                            <?php foreach ($newFilter['tod'] as $key => $value) :?>
                                            <li data-time="<?= $key ?>" class="tod_mon<?= substr($key, 0, 7)?>">
                                                <?php if (isset($value['isGrey']) && $value['isGrey'] == 1) :?>
<!--                                                <span class="disable">--><?//= $value['name']?><!--</span>-->
                                                <?php else:?>
                                                <a onclick="_viewrecord('tod','<?= $key?>','<?= $value['name']?>')"><?= $value['name']?></a>
                                                <?php endif;?>
                                            </li>
                                            <?php endforeach;?>
                                        </ul>
                                    </div>
                                </div>
                                <form action="/cruise/search" method="get" name="search">
                                    <input type="hidden" name="dep" id="dep_date_ipt" value="<?php if(isset($get['dep']) && $get['dep']) {echo $get['dep'];}?>" />
                                    <input type="hidden" name="tod" id="tod_date_ipt" value="<?php if(isset($get['tod']) && $get['tod']) {echo $get['tod'];}?>" />
                                </form>
                            </div>
                            <p class="mt15"><span style="color:#848484;">* 以下显示价格为两人一房每人需支付的最低邮轮价格，且不含码头费、税费和服务费</span></p>
                            <dl>
                                <dt>
                                    <span class="d135">出发日期</span>
                                    <span class="d125">结束日期</span>
                                    <span class="d130">内舱房</span>
                                    <span class="d130">海景房</span>
                                    <span class="d130">阳台房</span>
                                    <span class="d130">豪华套房</span>
                                    <span class="d170">&nbsp;</span>
                                </dt>
                                <?php foreach ($itinerary['SailingDates']['Sailing'] as $item) {?>
                                <dd class="mt10">
                                    <span class="d135"><?= $item['Departure']?><?php if(isset($item['IN_PricePublish']) && $item['IN_PricePublish'][Yii::$app->params['curCurrency']] == $itinerary['SailingDates']['minPrice'][Yii::$app->params['curCurrency']]){ echo '<i class="icon">最低</i>';} //todo ?></span>
                                    <span class="d125"><?= $item['Arrival']?></span>
                                    <span class="d130"><b class="fc60"><?php if (!isset($item['IN_PricePublish'])) { echo 'N/A';} else {echo Yii::$app->params['curCurrencies']['sign'] . $item['IN_PricePublish'][Yii::$app->params['curCurrency']];}?></b><?php if (!isset($item['IN_PricePublish'])) { echo 'N/A';} else {echo Yii::$app->params['curCurrencies']['sign'] . ceil($item['IN_PricePublish'][Yii::$app->params['curCurrency']] / $itinerary['CruiseLength']) . '每晚';}?></span>
                                    <span class="d130"><b class="fc60"><?php if (!isset($item['OV_PricePublish'])) { echo 'N/A';} else {echo Yii::$app->params['curCurrencies']['sign'] . $item['OV_PricePublish'][Yii::$app->params['curCurrency']];}?></b><?php if (!isset($item['OV_PricePublish'])) { echo 'N/A';} else {echo Yii::$app->params['curCurrencies']['sign'] . ceil($item['OV_PricePublish'][Yii::$app->params['curCurrency']] / $itinerary['CruiseLength']) . '每晚';}?></span>
                                    <span class="d130"><b class="fc60"><?php if (!isset($item['BL_PricePublish'])) { echo 'N/A';} else {echo Yii::$app->params['curCurrencies']['sign'] . $item['BL_PricePublish'][Yii::$app->params['curCurrency']];}?></b><?php if (!isset($item['BL_PricePublish'])) { echo 'N/A';} else {echo Yii::$app->params['curCurrencies']['sign'] . ceil($item['BL_PricePublish'][Yii::$app->params['curCurrency']] / $itinerary['CruiseLength']) . '每晚';}?></span>
                                    <span class="d130"><b class="fc60"><?php if (!isset($item['ST_PricePublish'])) { echo 'N/A';} else {echo Yii::$app->params['curCurrencies']['sign'] . $item['ST_PricePublish'][Yii::$app->params['curCurrency']];}?></b><?php if (!isset($item['ST_PricePublish'])) { echo 'N/A';} else {echo Yii::$app->params['curCurrencies']['sign'] . ceil($item['ST_PricePublish'][Yii::$app->params['curCurrency']] / $itinerary['CruiseLength']) . '每晚';}?></span>
                                    <span class="d170"><a href="<?= $item['nextUrl']?>" class="btn" target="_blank">选择</a></span>
                                </dd>
                                <?php if(!empty($item['tc_sailing_incentive']) && is_array($item['tc_sailing_incentive'])): ?>
                                    <dd>
                                        <div class="dest_dd_view clearfix">
                                            <div class="list_tit"><img src="<?= Yii::$app->helper->getFileUrl('/images/cruise/icon_cuxiao.png')?>"><em class="ml5">促销活动</em></div>
                                            <ul class="tag-list">
                                                <?php foreach($item['tc_sailing_incentive'] as $incentive): ?>
                                                    <?php if(!empty($incentive['Title'])): ?>
                                                        <li class="J-tagtips" data-group="<?php if(!empty($incentive['Description'])){echo $incentive['Description'];} ?>"><?= $incentive['Title']; ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </dd>
                                <?php endif; ?>
                                <?php }?>
                            </dl>
                        </div>
                    </div>
                    <div class="cruise_cont_li clearfix" id="Trip">
                        <div class="cont_icon">
                            <i class="icon_03"></i>
                            <span>行程</span>
                        </div>
                        <div class="cont_right">
                            <table class="tab_map" border="0">
                                <tbody>
                                    <tr>
                                        <th>天数</th>
                                        <th>停靠港口</th>
                                        <th>到达时间</th>
                                        <th>离开时间</th>
                                    </tr>
                                    <?php foreach ($itinerary['Itinerary']['SegmentsList']['Segment'] as $seg) {?>
                                    <tr>
                                        <td><?= $seg['Order']?></td>
                                        <td><?php if ($seg['Port']['tc_port_name']) {echo $seg['Port']['tc_port_name'];} else {echo $seg['PortName'];}?></td>
                                        <td><?= $seg['Arrival']?></td>
                                        <td><?= $seg['Departure']?></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                            <div id="map_canvas" style="width:963px;height:375px;"></div>
                        </div>
                    </div>
                    <div class="cruise_cont_li clearfix" id="Port">
                        <div class="cont_icon">
                            <i class="icon_04"></i>
                            <span>港口</span>
                        </div>
                        <div class="cont_right">
                            <p class="f16"><strong>停靠港口</strong></p>
                            <div class="port">
                                <?php foreach ($itinerary['EmPorts'] as $emPort) {?>
                                <div class="port_li">
                                    <div class="fl img"><img src="<?= $emPort['t_image_img']?>"></div>
                                    <h2 class="f16"><?= $emPort['tcPort']['tc_port_name']?></h2>
                                    <p><?= $emPort['tcPort']['tc_port_desc']?></p>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <div class="cruise_cont_li clearfix" id="Facilities">
                        <div class="cont_icon">
                            <i class="icon_05"></i>
                            <span>设施</span>
                        </div>
                        <div class="cont_right">
                            <div>
                                <p class="f16"><strong>客舱设施:</strong></p>
                                <div class="faces">
                                    <?php foreach ($ship['touricoCruiseShipAmenities'] as $item) {
                                        if ($item['tc_amenity_type'] != 1) {continue;}
                                        ?>
                                    <span><?= $item['tc_amenity_name']?></span>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="mt30">
                                <p class="f16"><strong>邮轮设施:</strong></p>
                                <div class="faces">
                                    <?php foreach ($ship['touricoCruiseShipAmenities'] as $item) {
                                        if ($item['tc_amenity_type'] != 5) {continue;}
                                        ?>
                                        <span><?= $item['tc_amenity_name']?></span>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="mt30">
                                <p class="f16"><strong>课程与服务:</strong></p>
                                <div class="faces">
                                    <?php foreach ($ship['touricoCruiseShipAmenities'] as $item) {
                                        if ($item['tc_amenity_type'] == 5 || $item['tc_amenity_type'] == 1) {continue;}
                                        ?>
                                        <span><?= $item['tc_amenity_name']?></span>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cruise_cont_li clearfix" id="Deck">
                        <div class="cont_icon">
                            <i class="icon_06"></i>
                            <span>甲板</span>
                        </div>
                        <div class="cont_right">
                            <div class="deck_a">
                                <ul>
                                    <?php $i =0; foreach($ship['deck'] as $deckNum => $item) {?>
                                    <li <?php if($i == 0):?>class="on"<?php endif;?>><?= $item['deck'][0]['tc_deck_name']?></li>
                                    <?php $i++;} ?>
                                </ul>
                            </div>
                            <div class="deck_de">
                                <?php $i =0; foreach($ship['deck'] as $deckNum => $item) {?>
                                <div class="deck_li clearfix" <?php if($i == 0):?>style="display: block;"<?php endif;?>>
                                    <div class="fl text d630">
                                        <?php foreach($item['deck'] as $deck) {?>
                                        <p><?php echo $deck['tc_cabincategory_code'] . $deck['tc_cabincategory_name'];?></p>
                                        <p><?php echo $deck['tc_cabincategory_desc'];?></p>
                                        <?php }?>
                                        <?php if(isset($item['publicareas'])) {?>
                                        <br>
                                        <p>PUBLICAREA</p>
                                        <?php foreach($item['publicareas'] as $area) {?>
                                        <p><?php echo $area['tc_publicareas_name'];?></p>
                                        <p><?php echo $area['tc_publicareas_desc'];?></p>
                                        <?php }?>
                                        <?php }?>
                                    </div>
                                    <div class="fl img"><img src="<?= $item['deckImg']?>"></div>
                                </div>
                                <?php $i++; }?>
                            </div>
                        </div>
                    </div>
                    <div class="cruise_cont_li clearfix" id="Reservation">
                        <div class="cont_icon">
                            <i class="icon_02"></i>
                            <span>预订须知</span>
                        </div>
                        <div class="cont_right">
                            <p><strong>签证：</strong></p>
                            <p><span style="color:#ff6600;">特别提醒：请确认所有出行人都有有效签证。</span>签证信息可参考<a href="http://article.lulutrip.com/view/id-10007" target="_blank">邮轮攻略</a></p>
                            <p>如有疑问，请打北美客服电话：<?= $phones['USA']['number']?></p>
                            <p>&nbsp;</p>
                            <p><strong>带小孩出行：</strong></p>
                            <p>家长 / 法定监护人关于未成年人监护权暂转同意书   可参考未成年授权书</p>
                            <p>&nbsp;</p>
                            <p><strong>取消／更改条例：</strong></p>
                            <?php echo html_entity_decode($itinerary['Policies']);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (Yii::$app->params['IPArea'] =="China") {?>
<script src="http://maps.google.cn/maps/api/js?sensor=false"></script>
<?php } else {?>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAaFg6ayTT7mvZJ3ryU852SB3TX_nzA7PM&sensor=false"></script>
<?php }?>
<style>
    .cruise_cont_li .cont_right span.d135 i{
        display: inline-block;
        padding: 0 10px;
        border-radius: 3px;
        background: #ff6600;
        color: #fff;
        font-size: 12px;
    }
    .cruise_cont_li .cont_right .showseat li a{
        color: #333;
        text-decoration: none;
    }
</style>
<script type="text/javascript" language="javascript">
    <?php $this->beginBlock('js_view') ?>

    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['js_view'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>