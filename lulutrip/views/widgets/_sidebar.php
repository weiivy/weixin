<div class="lui-lbar-outer" id="J_LUIlulubar">
<!-- lulu bar -->
<div class="lui-lbar-bars-expand" id="J_LUIluluexpand">
    <!-- pannel -->
    <div class="lui-lbar-plugins">
        <!-- 预留位置 -->
    </div>
    <!-- tab -->
    <div class="lui-lbar-tabs toggle-bar"><!-- toggle-bar隐藏菜单 -->
        <!-- tabs 上半段-->
        <div class="lui-lbar-tabs-t">
            <!-- 广告位 -->
            <!-- <div class="ad-tag">
                {if $minAdsRight.pic neq NULL}
                <a href="{$minAdsRight.link}" target="_blank"> <img src="{getImgDomain()}/{$minAdsRight.pic}" width=35 height=180 /></a>
                <div class="ad-expand">
                    {if $maxAdsRight.pic neq NULL}
                    <a href="{$maxAdsRight.link}" target="_blank"> <img src="{getImgDomain()}/{$maxAdsRight.pic}" width=300 height=180 /></a>
                    {/if}
                </div>
                {/if}
            </div> -->
            <!-- 指纹 placeholder -->
            <!-- 购物车 -->
            <div class=" lui-lbar-cart">
                <a href="<?=\Yii::$app->params['service']['ssl']?>/cart/view">
                    <span id="cart_num_web" class="cart-num"><?=Yii::$app->params['cartNum']?></span>
                    <i class="icon-barcart"></i>
                    <span class="word">购物车</span>
                </a>
            </div>
            <div class="lui-lbar-mainbar">
                <div class="lui-lbar-lawf icon-main_bar">
                    <div class="lui-lbar-statue">
                        <img src="<?=Yii::$app->helper->getFileUrl('/images/channel_index/def_state.gif')?>" width=34 height=34 alt="" />
                        <img src="<?=Yii::$app->helper->getFileUrl('/images/channel_index/notify_state.gif')?>" class="hide" width=34 height=34 alt="" />
                    </div>
                    <div class="lui-lbar-expansion hide">
                        <div class="icon-expansion"></div>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="lui-lbar-main">
                <!-- 对比 -->
                <div class="lui-lbar-item lui-lbar-contrast" id="compare_num_web">
                    <a href="javascript:;" onclick="showCompare15();$('.compare_list').slideToggle('fast');">
                        <i class="icon-style icon-bar_contrast"></i>
                        <span class="word-contrast">对比</span>
                    </a>
                    <span class="lui-lbar-item-tips">产品对比</span>
                    <div class="compare_list" style="display:none;" onmouseover="isOut2=false" onmouseout="isOut2=true">
                        <span id="currencies" style="display: none;"><?=json_encode(\Yii::$app->params['currencies'])?></span>
                        <div class="con">
                            <ul>
                                <!--<script language="javascript" type="text/ecmascript">showCompare15();</script>-->
                            </ul>
                            <!--add_number外框状态class 默认:an_off focus:an_cur 错误：an_error-->
                            <!--input状态class 默认：无 focus:focus 错误：error-->
                            <div class="add_number an_off">
                                <span><input type="text" style="font-size: 12px;" rel="search" value="请输入产品编号" id="search5" onkeypress="EnterPress(event,5)" onkeydown="EnterPress()" autocomplete="off" /></span>
                                <a href="javascript:addCompareLi();"></a>
                            </div>
                            <div class="button">
                                <a href="<?=\Yii::$app->params['service']['ssl']?>/tour/compare" class="fl start" target="_blank">开始对比</a>
                                <a href="javascript:clearCompareLi();" class="fr">清空</a>
                            </div>
                        </div>
                    </div><!--end compare_list-->
                </div>
                <!-- 电话 -->
                <div class="lui-lbar-item lui-lbar-tel">
                    <a href="javascript:;">
                        <i class="icon-style icon-bar_tel"></i>
                        <span class="word-qq">电话</span>
                    </a>
                    <div class="lui-lbar-item-tips tel-list">
                        <h2 class="rhr t-bt">全球 7x24小时客服电话</h2>
                        <?php if (!empty($serviceTel)):?>
                        <?php $area = array('NA', 'CN', 'EU', 'AU');?>
                        <?php foreach ($area as $item):?>
                        <div class="rhr">
                            <?php foreach ($serviceTel as $tel):?>
                                <?php if ($tel['code'] == $item):?>
                                <p class="tel-row">
                                    <span class="t-a"><?= $tel['areaname']?>: </span>
                                    <span class="t-n"><?= $tel['phone']?></span>
                                </p>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>
                        <?php endforeach;?>
                        <?php endif;?>
                    </div>
                </div>
                <!-- QQ客服 -->
                <div class="lui-lbar-item lui-lbar-qq" >
                    <a href="javascript:;" id="onlineKefu" target="_blank">
                        <i class="icon-style icon-bar_qq"></i>
                        <span class="word-qq">客服</span>
                    </a>
                </div>
                <!-- 微信客服 -->
                <div class="lui-lbar-item lui-lbar-wechat">
                    <a href="javascript:;">
                        <i class="icon-style icon-bar_wechat"></i>
                        <span class="word-wechat">微信</span>
                    </a>
                    <div class="weixin_list" id="frn_l_3">
                        <div class="m10">
                            <div class="ac"><img <?php if(!empty($QRCode)):?>style="width:82px;"<?php endif;?> src="<?php if(!empty($QRCode)){?><?= $QRCode?><?php }else{?><?=Yii::$app->helper->getFileUrl('/images/index_14/weixin_2d_fwh2.jpg')?><?php }?>" /></div>
                            <div class="ac"><img src="<?=Yii::$app->helper->getFileUrl('/images/index_14/weixin_2d_0107.jpg')?>" /></div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <!-- 反馈 -->
                <div class="lui-lbar-item lui-lbar-feedback">
                    <a href="javascript:showTabD(4);" onMouseOver="isOut=false" onMouseOut="isOut=true">
                        <i class="icon-bar_feedback"></i>
                        <span class="word-feedback">反馈</span>
                    </a>
                    <span class="lui-lbar-item-tips">意见反馈</span>
                </div>
            </div>
        </div>
        <!-- tabs 下半段 -->
        <div class="lui-lbar-tabs-b">
            <div class="lui-lbar-item lui-lbar-gotop">
                <a href="javascript:;">
                    <i class="icon-style icon-bar_gotop"></i>
                </a>
                <span class="lui-lbar-item-tips">返回顶部</span>
            </div>
            <div class="lui-lbar-item lui-lbar-close">
                <a href="javascript:;">
                    <i class="icon-style icon-bar_close"></i>
                </a>
                <span class="lui-lbar-item-tips">收起/隐藏</span>
            </div>
        </div>
    </div>
</div>
<!-- lulu bar -->
<!-- lulu panel -->
<div class="lui-lpanel-panel" id="J_LUIlulupanel">
    <div class="lui-lpanel-overflow">
        <div class="lui-lpanel-tabs">
            <ul class="llt-tab">
                <li class="active" data-name="history">浏览记录</li>
                <li data-name="recommend">深度推荐</li>
                <li data-name="theme_recommend">主题推荐</li>
            </ul>
        </div>
        <div class="lui-lpanel-lists llt-tab_content">
            <!-- 历史纪录面板 -->
            <div id="J_history_panel" class="lui-lpanel-lc" style="">
                <div class="lui-lpanel-lists-wrap">
                    <div class="lui-lpanel-items"></div>
                    <div class="lui-lpannel-nodata">暂无数据</div>
                </div>
                <div class="lui-lpanel-opts">
                    <div class="lui-lpanel-ow">
                        <a href="javascript:void(0);" class="lui-lpanel-showmore">
                            <span>显示更多</span>
                            <span></span>
                        </a>
                        <a href="javascript:void(0);" class="lui-lpanel-clearall">清空</a>
                    </div>
                    <div class="lui-lpannel-loading">
                        <i class="icon-bar_loading a-load-rotate"></i>
                    </div>
                </div>
            </div>
            <!-- 历史纪录面板 -->
            <!-- 深度推荐面板 -->
            <div id="J_recommend_panel" class="lui-lpanel-lc recommend-panel" style="display: none;">
                <div class="lui-lpanel-lists-wrap">
                    <div class="lui-lpanel-items">
                        <div class="lui-group-items" id="J_dayup">
                            <h2 class="group-title">多玩一天，更多精彩<a href="javascript:;" onclick="upsaleCompare('J_dayup');" class="tocompare">比一比</a></h2>
                            <div class="group-items-warp">
                                <div class="lui-lpannel-nodata">暂无数据</div>
                            </div>
                        </div>
                        <div class="lui-group-items" id="J_gradcup">
                            <h2 class="group-title">相同的线路，更升级的体验<a href="javascript:;" onclick="upsaleCompare('J_gradcup')" class="tocompare">比一比</a></h2>
                            <div class="group-items-warp">
                                <div class="lui-lpannel-nodata">暂无数据</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 深度推荐面板 -->
            <!-- 主题推荐面板 -->
            <div id="J_theme_recommend_panel" class="lui-lpanel-lc theme-recommend-panel">
                <div class="lui-lpanel-lists-wrap">
                    <div class="lui-lpanel-items" id="J_theme_recommend">
                        <div class="group-items-warp">
                            <div class="lui-lpannel-nodata">暂无数据</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 主题推荐面板 -->
        </div>
    </div>
    <div class="lui-lpanel-pickup icon-main_bar">
        <i class="icon-pickup"></i>
    </div>
</div>
<!-- lulu panel -->
<!-- 判断当前是什么页面 & 团号-->
<input type="hidden" id="what_page" value="" /> <!--频道页和旅行团详情页需要-->
<input type="hidden" id="tour_num" value="" /> <!--旅行团详情页需要-->
<input type="hidden" id="page_value" value="" /> <!--旅行团列表页，详情页需要-->
<input type="hidden" id="ref_url" value="" /> <!--旅行团列表页-->
<!-- 判断当前是什么页面 & 团号-->
<div class="mulit-tips-warp dtu" id="J_mulit-tips-warp">
</div>
</div>
<!--<div class="bg_layer" id="bg_layer" style="display:none;"></div>-->
<div class="feedback" id="sn_sel4" style="display:none;" onmouseover="isOut=false" onmouseout="isOut=true">
    <div class="m20">
        <div class="f16">意见反馈</div>
        <div class="mt20">
            <ul>
                <li><a href="javascript:showFeedback(1)" id="icon_feedback1" class="icon_feedback current">订购问题</a></li>
                <li><a href="javascript:showFeedback(2)" id="icon_feedback2" class="icon_feedback off">页面出错</a></li>
                <li><a href="javascript:showFeedback(3)" id="icon_feedback3" class="icon_feedback off">意见建议</a></li>
                <li><a href="javascript:showFeedback(4)" id="icon_feedback4" class="icon_feedback off">其他</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="mt10">
            <textarea style="color:#999;" id="feedback_content" onfocus="if(this.value=='请尽可能详细的描述您遇到的问题，我们会认真处理您提交的反馈，请留下您的联系方式，以便我们能更好的解决您的困惑。'){this.value=''}" onblur="if(this.value==''){this.value='请尽可能详细的描述您遇到的问题，我们会认真处理您提交的反馈，请留下您的联系方式，以便我们能更好的解决您的困惑。'}" autocomplete="off">请尽可能详细的描述您遇到的问题，我们会认真处理您提交的反馈，请留下您的联系方式，以便我们能更好的解决您的困惑。</textarea>
        </div>
        <div class="mt10">
            <div class="fl"><input type="text" style="color:#999;" value="先生/女士" id="feedback_name" onfocus="if(this.value=='先生/女士'){this.value=''}" onblur="if(this.value==''){this.value='先生/女士'}" autocomplete="off" /><input type="hidden" id="feedback_type" value="1" /></div>
            <div class="fl ml10"><input type="text" style="color:#999;" value="联系方式(QQ/手机/邮箱)" id="feedback_contact" onfocus="if(this.value=='联系方式(QQ/手机/邮箱)'){this.value=''}" onblur="if(this.value==''){this.value='联系方式(QQ/手机/邮箱)'}" autocomplete="off" /><input type="hidden" id="feedback_type" value="1" /></div>

            <div class="clear"></div>
        </div>
        <div class="mt20">
            <div class="fl">
                <input id="button_feedback" type="button" onClick="sendFeedBack();" value="提交反馈" />
            </div>
            <!--提交成功后-->
            <div class="f1 n_fc06 f14" style="margin:5px 0 0 10px;" id="feedback_success"></div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="close_icon">
        <a href="javascript:hideTabD(4);"></a>
    </div>
</div>