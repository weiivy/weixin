<?php
use yii\helpers\Html;
    $links = [
        [
            'label' => '包团定制',
            'url' => ['privatetour/home'],
            'template' => "<li class='fl'>{link} ></li>",
            'class' => 'check_more'
        ],
        [
            'label' => '一键包团列表',
            'url' => ['privatetour/entry'],
            'class' => 'check_more'
        ],
       Html::decode($packagetour['packmaintitle_cn'])];
   if(!empty($tourCode)){
       $temp[] = [
           'label' => '返回旅行团',
           'url' => Yii::$app->params['service']['www'] . "/tour/view/tourcode-" . $packagetour['tourcode'],
           'template' => "<li class='fr'>{link}</li>",
           'class' => 'check_more'
       ];
       $links = array_merge($links, $temp);
   }
?>
<link href="<?= Yii::$app->helper->getFileUrl('/css/private_tour_2016.css'); ?>" rel="stylesheet">
<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/privatetour.js') ;?>"></script>

<div class="ptview_body">
<?= \yii\widgets\Breadcrumbs::widget([
    'itemTemplate' => "<li  class='fl'>{link} ></li>", // template for all links
    'activeItemTemplate' => "<li class=\" fl active\">{link}</li>",
    'homeLink' => [
        'label' => '首页',
        'url' => Yii::$app->params['service']['www'],
        'template' => "<li  class='fl'>{link} ></li>",
        'class' => 'check_more'
    ],
    'links' => $links, 'options' => ['class' => 'bread_navs']  ]) ?>
<div id="p_days" style="display: none" rel="<?=Yii::$app->params['curCurrencies']['sign']?>"><?= $packagetour['p_days']?></div>
<div id="base_price" style="display: none"></div>
<div class="ptview_block">
    <div class="ptview_title">
        <div class="c_title"><?= Html::decode($packagetour['packmaintitle_cn'])?></div>
        <div class="c_types">
            <span>独立成团√</span>
            <span>随时出发√</span>
            <span>行程灵活√</span>
            <span>立即报价√</span>
            <span>直接订购√</span>
        </div>
        <span class="tag-span tag_blue ptview_theme"><?=$themesData[$packagetour['pack_theme']] ?></span>
        <?php if(!empty($packagetour['tags']['all'])):?>
            <div class="tags">
                <?php foreach($packagetour['tags']['all'] as $value):?>
                    <span class="J_tag_span tag-span llt-hovertips <?php if($value['tag_type'] == 'SALE') {echo 'tag_red';}else{echo 'tag_blue';}?>">
                      <?php if(!empty($value['tag_icon']) && $value['tag_filter_type'] != 'F_SERVICE'){?><img src="/<?= $value['tag_icon']?>" alt="<?= $value['tag_name_cn']?>"/>  <?php }else{?><?= $value['tag_name_cn']?><?php }?>
                        <div class="llt-tips ort-center">
                          <p class="inner-content">
                              <i class="l-arrow"></i>
                              <?= Html::decode($value['tag_descr_cn'])?>
                          </p>
                      </div>
                  </span>
                <?php endforeach;?>
            </div>
        <?php endif;?>
        <!--标签输出 end-->
        <div class="clear"></div>

        <!--标签输出 start-->

    </div>
    <div class="ptview_options">
        <div class="c_tips">
            <div id="tip_bustype"><?= $packagetour['bus'][0]['note']?></div>
        </div>
        <div class="c_tips">
            <div id="tip_hoteltype">请注意：每房最多住<?php if($packagetour['regionCode'] == "AU"){echo 3;}else{echo 4;}?>人</div>
        </div>
        <form id="packagetour" action="" method="post">
            <div class="c_options">
                <div class="c_option">
                    <div class="fl sel_d">
                        <span class="fl">出发日期</span>
                        <div class="fl moni_selPt sel_text1" id="sel_d1">
                            <input style="color: #999" name="departdate" value="<?= $packagetour['FirstDay']?>" placeholder="<?= $packagetour['FirstDay']?>}"  class="fs1 Jdepartdate" autocomplete="off" onClick="WdatePicker({onpicked:function(dp){$(this).css('color','#000');},skin:'travel',doubleCalendar:true,readOnly:true,minDate:'<?= $packagetour["FirstDay"]?>'});" />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="fl sel_d">
                        <span class="fl">车辆</span>
                        <div class="fl moni_selPt" id="sel_d4" onClick="showPtList(4)">
                            <div class="fl sel_text4 sel_text" id="pt_bustype"><?= $packagetour['bus'][0]['title']?></div>
                            <div class="fl moni_btn"><b></b></div>
                            <div class="clear"></div>
                            <div class="sel_listPt" id="sel_list4" onMouseOut="isOut=true" onMouseOver="isOut=false" style="width:123px; display:none;">
                                <?php if(!empty($packagetour['bus'])): foreach($packagetour['bus'] as $key => $item):?>
                                <a href="javascript:selectPtFilters('bustype','<?= $item["title"]?>','<?= $key ?>','请注意：<?= $item['note']?>')"><?= Html::decode($item['title'])?></a>
                                <?php endforeach; endif;?>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="fl sel_d">
                        <span class="fl">参团人数</span>
                        <div class="fl moni_selPt" id="sel_d2" onClick="showPtList(2)">
                            <div class="fl sel_text2 sel_text" id="pt_peoplenums">4</div>
                            <div class="fl moni_btn"><b></b></div>
                            <div class="clear"></div>
                            <div class="sel_listPt" id="sel_list2" onMouseOut="isOut=true" onMouseOver="isOut=false" style="width:73px; height: 200px; overflow: scroll; overflow-x:hidden; display:none;">
                                <?php for($peopleamount = 1; $peopleamount <= 50; $peopleamount++):?>
                                <a href="javascript:selectPtFilters('peoplenums','<?= $peopleamount?>')"><?= $peopleamount?></a>
                                <?php endfor;?>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="fl sel_d">
                        <span class="fl">酒店</span>
                        <div class="fl moni_selPt" id="sel_d3" onClick="showPtList(3)">
                            <div class="fl sel_text4 sel_text" id="pt_hoteltype"><?= $packagetour['hotel'][0]['title']?></div>
                            <div class="fl moni_btn"><b></b></div>
                            <div class="clear"></div>
                            <div class="sel_listPt" id="sel_list3" onMouseOut="isOut=true" onMouseOver="isOut=false" style="display:none;">
                                <?php if(!empty($packagetour['hotel'])): foreach($packagetour['hotel'] as $key => $item):?>
                                <a href="javascript:selectPtFilters('hoteltype','<?= $item["title"]?>','<?= $key ?>','请注意：每房最多住4人')"><?= $item['title']?></a>
                                <?php endforeach; endif;?>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="fl sel_d sel_d-last">
                        <span class="fl">房间</span>
                        <div class="fl moni_selPt" id="sel_d5" onClick="showPtList(5)">
                            <div class="fl sel_text2 sel_text" id="pt_roomnums">1</div>
                            <div class="fl moni_btn"><b></b></div>
                            <div class="clear"></div>
                            <div class="sel_listPt" id="sel_list5" onMouseOut="isOut=true" onMouseOver="isOut=false" style="width:73px; height: 200px; overflow: scroll; overflow-x:hidden; display:none;">
                                <?php for($roomamount = 1; $roomamount <= 20; $roomamount++):?>
                                <a href="javascript:selectPtFilters('roomnums','<?= $roomamount?>')"><?= $roomamount?></a>
                                <?php endfor;?>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <input type="hidden" class="Jpackid" name="packid" value="<?= $packagetour['packid']?>"/>
                <input type="hidden" class="JDays" name="days" value="<?= $packagetour['p_days']?>" />
                <input type="hidden" class="Jbustypeid" name="busid" value="0"/>
                <input type="hidden" class="Jhoteltypeid" name="hotelid" value="0"/>
                <input type="hidden" class="Jpeoplenums" name="personnum" value="4"/>
                <input type="hidden" class="Jroomnums" name="roomnum" value="1"/>
                <input type="hidden" class="Jincreasedays" name="increasedays" value="0"/>
                <input type="hidden" class="Jnotes" name="notes" value="" />
                <div class="c_option_button"><a href="javascript:void(0);" onclick="orderPrivateTour()" class="c_btns c_btn0">一键报价</a></div>
                <div class="fr pr10 merging">
                    <div id="J_tips_merge" class="tips-merge">
                        <a href="javascript:;">我知道了</a>
                    </div>
                </div>
            </div>
        </form>
        <div id="c_order_details" class="dn">
            <div class="c_line"></div>
            <div class="c_infos">
                <div class="c_help">如需咨询，请立即拨打客服热线：<?= Yii::$app->params['service']['frtel_us']?>&nbsp;&nbsp;<?php if(Yii::$app->params['IPArea'] == 'China'):?>中国<?= Yii::$app->params['service']['tel_sh']?><?php else: ?>美国<?= Yii::$app->params['service']['tel_us']?><?php endif;?></div>
                <div class="c_prices">包团总价格：<span class="c_price">$8000</span><span class="c_shopping">
                        <a href="javascript:void(0);" onclick="doAddToCart('<?= $packagetour['packid']?>')" class="c_btns c_btn1">加入购物车</a>
                        <a href="javascript:void(0);" style="display:none;" onclick="doAddToCart('<?= $packagetour['packid']?>')" class="c_btns c_btn2">加入购物车</a></span></div>
                <div class="clear"></div>
            </div>
            <div class="c_moreinfos JSmoreinfos">
                <div class="c_help">你一定有自己的小想法，不怕，尽量写，路路行专业当地行程顾问为你安排！</div>
                <span class="fl">行程调整：</span>
                <div class="fl">
                    <label for="updateDest"><input type="radio" name="changetravel" id="updateDest" />天数不变或者多个目的地<br></label>
                    <textarea style="display: none" class="txetarea1 JStext" rows="3" cols="20" name="content1" placeholder="如果您行程天数不变，有任何需求可填写进来，路路行专业行程顾问为您策划安排。如果您有多个目的地旅行计划，请填写进来。订购后路路行专业行程顾问为您策划安排，24小时内主动联系您！如需咨询，请拨打：<?=Yii::$app->params['service']['frtel_us']?>，<?php if(Yii::$app->params['IPArea'] == 'China'){echo '中国' . Yii::$app->params['service']['tel_sh'];}else{echo '美国' . Yii::$app->params['service']['tel_us'];}?>" ></textarea><br>
                    <label for="increasedays"><input type="radio" name="changetravel" id="increasedays" />增加天数 （每天 <span id="addPerPrice"></span>)<br></label>
                    <div class="JStext" style="display: none">
                        <div class="sel_d">
                            <span class="fl">请选择增加的天数：</span>
                            <div class="fl moni_selPt" id="sel_d6" onMouseOut="isOut=true" onMouseOver="isOut=false" onClick="showPtList(6)">
                                <div class="fl sel_text2 sel_text" id="pt_increasedays"></div>
                                <div class="fl moni_btn"><b></b></div>
                                <div class="clear"></div>
                                <div class="sel_listPt" id="sel_list6" style="width:73px; height: 200px; overflow: scroll; overflow-x:hidden; display:none;">
                                    <?php for($dayamount = 1; $dayamount <= 10; $dayamount++):?>
                                    <a href="javascript:selectPtFilters('increasedays','<?= $dayamount?>')"><?= $dayamount?></a>
                                    <?php endfor;?>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <span class="fl special">特别说明：</span>
                        <textarea class="txetarea2 fl" rows="3" cols="20" name="content2" placeholder="有任何需求可填写进来，订购后路路行专业行程顾问为您策划安排。24小时内主动联系您！如需咨询，请拨打：<?=Yii::$app->params['service']['frtel_us']?>，<?php if(Yii::$app->params['IPArea'] == 'China'){echo '中国' . Yii::$app->params['service']['tel_sh'];}else{echo '美国' . Yii::$app->params['service']['tel_us'];}?>" ></textarea>
                        <div id="travel_cost"></div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<div class="ptview_block" id="ptview_fixed">
    <div class="navi_title">
        <ul>
            <li class="current"><a id="trip" href="javascript:;">参考行程</a></li>
            <li><a id="price" href="javascript:;">费用明细</a></li>
            <li><a id="note" href="javascript:;">订购须知</a></li>
            <?php if($commsNum):?><li><a id="user_evaluation" href="javascript:;">用户评价(<span><?= $commsNum?></span>)</a></li><?php endif;?>
        </ul>
        <div class="bookentry">
            <span>有没有合适的路线？请点击</span><a href="<?= Yii::$app->params['service']['www']?>/private/tour_book/type-tour" target="_blank" class="comm-btn2 comm-btn-lg comm-btn-special">个性定制入口</a>
        </div>
    </div>
    <div class="ptview_intro">
        <a name="trip"></a>
        <?php if(!empty($itineraries)):?>
        <div class="c_trips">
            <?php foreach($itineraries as $key => $value):?>
            <div class="c_trip_sub">
                <div class="c_day"><span>Day</span> <b><?= $key?></b></div>
                <div class="c_trip">
                    <div class="c_triptitle"><?= $value['ittitle']?></div>
                    <div class="c_tripinfo">
                        <div>
                            <div class="c_scenes">
                                <?php if(!empty($value['Scenes'])): foreach($value['Scenes'] as $sceneKey => $scene):?>
                                <div class="c_scene">
                                    <div class="c_scene_img"><a href="<?= Yii::$app->params['service']['www']?>/scene/view/id-<?= $scene['id']?>" target="_blank"><img src="<?= Yii::$app->helper->getImgDomain()?>/<?= $scene['thumb']?>" alt="<?= $scene['scenename_cn']?>" title="<?= $scene['scenename_cn']?>" onerror="this.src='<?= Yii::$app->helper->getFileUrl('/images/scene_no_thumb.gif')?>'" /></a></div>
                                    <div class="c_scene_name"><a href="<?= Yii::$app->params['service']['www']?>/scene/view/id-<?= $scene['id']?>" target="_blank"><?= $scene['scenename_cn']?></a></div>
                                </div><!-- 循环区域 -->
                                <?php endforeach; endif;?>
                                <div class="clear"></div>
                            </div>
                        </div><!-- 描述景点 -->
                        <!-- 图片域名替换 -->
                        <?php
                            $value['itintro'] = preg_replace('/\/\/(www|admin).lulutrip.com\/upload\//', '//img1.quimg.com/upload/', $value['itintro']);
                        ?>
                        <div><?= Html::decode($value['itintro'])?></div><!-- 描述文字 -->
                        <?php if(!empty($value['Hotels'])):?>
                            <div> <strong>住宿安排</strong>
                                <?php foreach($value['Hotels'] as $k => $v):?>
                                    <a class="check_more4" href="javascript:showMoreIframe('hotelDetail', <?= $v['hotelcode']?>);"><?= $v['hfullname_en']?></a> <?php if($k != (count($value['Hotels']) -1)):?>或<?php endif;?>
                                <?php endforeach;?></div>
                        <?php endif;?>
                    </div>
                </div>
                <div class="clear"></div>
            </div><!-- 循环区域 -->
            <?php endforeach;?>
        </div>
        <?php endif;?>
    </div>
</div>
<div class="ptview_block">
    <a name="price"></a>
    <div class="ptview_notes">
        <!-- 图片域名替换 -->
        <?php
        $packagetour['operatornotes_cn'] = preg_replace('/\/\/(www|admin).lulutrip.com\/upload\//', '//img1.quimg.com/upload/', $packagetour['operatornotes_cn']);
        $packagetour['changenote'] = preg_replace('/\/\/(www|admin).lulutrip.com\/upload\//', '//img1.quimg.com/upload/', $packagetour['changenote']);
        ?>
        <?=Html::decode($packagetour['operatornotes_cn'])?>
        <?=Html::decode($packagetour['changenote'])?>
        <div class="clear"></div>
    </div>
</div>
<div class="ptview_block">
    <a name="user_evaluation"></a>
    <div id="package_comment">
        <!--评价-->
    </div>
</div>

<?php if(!empty($tourCode) || !empty($recProducts)): ?>
<div class="ptview_block">
    <div class="ptview_more">
        <div class="more_title">超出预算怎么办？还可以选择当地参团游
            <?php if(!empty($tourCode)): ?>
            <a href="<?= Yii::$app->params['service']['www'];?>/tour/view/tourcode-<?= $packagetour['tourcode'];?>" target="_blank" class="c_label c_label-danger">返回旅行团</a>
            <?php endif; ?>
        </div>
        <div class="more_tours">
            <?php if(sizeof($recProducts) > 0 ):?>
            <?php foreach ($recProducts as $key => $value):?>
            <div class="c_tours <?php if($key == 4):?>c_tours-last<?php endif;?>">
                <div class="c_tour_img"><a href="<?= Yii::$app->params['service']['www'] . '/' . $value['link'];?>" target="_blank"><img src="<?= $value['tf_cover'];?>" onerror="this.src='<?= Yii::$app->helper->getFileUrl('/images/scene_no_thumb.gif');?>" /></a></div>
                <div class="c_tour_info">
                    <div class="c_tour_title"><a href="<?= Yii::$app->params['service']['www'] . '/'.$value['link'];?>" target="_blank"><?= $value['tourtitle_cn'];?></a></div>
                    <div class="c_tour_price">
                        <?php if($value['gbflag'] == 1):?>
                        <del><?= Yii::$app->params['curCurrencies']['sign'];?><?= $value['prices']['min'][Yii::$app->params['curCurrency']];?></del><br />
                        <span class="c_current_price"><?= Yii::$app->params['curCurrencies']['sign'];?><?= ceil($value['prices']['min'][Yii::$app->params['curCurrency']]*(100-$value['discount'])*0.01);?></span>
                        <?php elseif(isset($value['prices']['max']) && $value['prices']['max'][Yii::$app->params['curCurrency']] && $value['prices']['max'][Yii::$app->params['curCurrency']] > $value['prices']['min'][Yii::$app->params['curCurrency']] ):?>
                        <del><?= $value['prices']['max'][Yii::$app->params['curCurrency']];?></del><br />
                        <span class="c_current_price"><?= Yii::$app->params['curCurrencies']['sign'];?><?= $value['prices']['min'][Yii::$app->params['curCurrency']];?></span>
                        <?php else:?>
                        <del></del><br />
                        <span class="c_current_price"><?= Yii::$app->params['curCurrencies']['sign'];?><?= $value['prices']['min'][Yii::$app->params['curCurrency']];?></span>
                        <?php endif;?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div><!-- 循环区域 -->
            <?php endforeach;?>
            <?php endif;?>
            <div class="clear"></div>
        </div>
    </div>
</div>
</div>
<?php endif; ?>
<div class="bg_layer" id="J_bg_layer"></div>
    <script language="javascript">
        <?php $this->beginBlock('js_view') ?>

        function get_packagecomment_nofocus(page) {
            var packId = <?= $packagetour['packid']?>;
            var page = page;

            $.ajax({
                url: newDomain + '/ajax/ajax_comments',
                data: { page:page, packId: packId, type: 'package'},
                type: 'post',
                dataType: 'json',
                success: function(data){
                    $("#package_comment").html(data.content);
                },
                error: function(){
                    alert("网络出错，请稍后刷新尝试");
                }
            });
        }
        function get_packagecomment(page) {
             if(page == -1) {
                page = $("#package_view_packagecomment_pageto").val();
             }
             if (page <= 0) return;
             get_packagecomment_nofocus(page);
             window.location = "#user_evaluation";
        }
        $(function(){
            get_packagecomment_nofocus(1);
        });
        <?php $this->endBlock(); ?>
    </script>
<?php $this->registerJs($this->blocks['js_view'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>