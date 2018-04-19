<!-- 水晶球 -->
<div id="sidebar" class="sidebar"></div><!-- 页脚 -->
<footer class="footer" id="footer">
    <div class="foot-banner">
        <div class="foot-banner-wrap">
            <img src="http://llt.quimg.com/llt-static/images/common/foot-banner-logo.png">
            <div class="box_bg"></div>
            <div class="box">
                <img class="img" src="http://llt.quimg.com/llt-static/images/common/foot-banner-logoh.png">
            </div>
        </div>
    </div>
    <div class="foot-service">
        <div class="wrap">
            <ul class="clearfix">
                <li><i class="icon-se icon-server1"></i><span><b>美国加州旅行资质执照</b>#2090384-40</span></li>
                <li><i class="icon-se icon-server2"></i><span><b>海外华人旅游第一品牌</b>NTA会员 10年服务超过百万华人</span></li>
                <li><i class="icon-se icon-server3"></i><span><b>行业先锋 服务最靠谱</b>0秒确认 24/7北美双语客服</span></li>
                <li><i class="icon-se icon-server4"></i><span><b>低价保障 打折不提价</b><a href="http://www.lulutrip.com/themes/promotion_traveltips" target="_blank">当地直采最优价格 SSL国际认证</a></span></li>
                <li><i class="icon-se icon-server5"></i><span><b>最优质精品行程</b>10,000+当地参团 8,000+当地玩乐</span></li>
            </ul>
        </div>
    </div>
    <div class="foot-lines">
        <div class="wrap">
            <div class="foot-top">
                <div class="clearfix">
                    <div class="foot-top-video">
                        <div class="tit">媒体报道</div>
                        <div class="cont"><a href="javascript:;" class="play-button"></a></div>
                    </div>
                    <div class="foot-top-news">
                        <a target="_blank" rel="nofollow" href="http://www.traveldaily.cn/article/112750">
                            我趣旅行、路路行合并成立我行集团，获2500万美元B+轮融资<br>
                            <span>环球旅讯——2017年3月21日</span>
                        </a>
                        <a target="_blank" rel="nofollow" href="http://article.lulutrip.com/view/id-9519">
                            路路行与我趣强强联姻，携手打造全球华人最智能在线旅游平台<br>
                            <span>欧洲时报 —— 2017年3月24日</span>
                        </a>
                        <a target="_blank" rel="nofollow" href="http://travel.sohu.com/20160822/n465382583.shtml?qq-pf-to=pcqq.c2c">
                            路路行推出非洲特色旅游系列产品，为游客开拓旅游新天地 <br>
                            <span>搜狐旅游 —— 2016年08月22日</span>
                        </a>
                    </div>
                    <?php if(!empty($adviserSaler)):?>
                        <div class="foot-top-sale">
                            <div class="tit">全球7x24 当地行程顾问团队</div>
                            <div class="cont clearfix">
                                <?php foreach($adviserSaler as $value): ?>
                                    <a rel="nofollow" target="_blank" href="<?= Yii::$app->params['service']['www']?>/adviser/home/id-<?= $value['id'] ?>">
                                        <span class="img">
                                          <em>
                                              <img class="on" src="<?= Yii::$app->helper->getImgDomain() . '/' . $value['avatar_1'] ?>" width="71" height="71">
                                              <img class="off" src="<?= Yii::$app->helper->getImgDomain() . '/' . $value['avatar_2'] ?>" width="71" height="71">
                                          </em>
                                        </span>
                                        <span class="name"><?= $value['name_en']?></span>
                                        <span class="info"><?= $value['country']?>当地顾问</span>
                                    </a>
                                <?php endforeach;?>
                            </div>
                        </div>
                    <?php endif;?>
                </div>

                <div class="foot-partner">
                    <div class="tit">合作伙伴</div>
                    <div class="cont clearfix">
                        <i class="icon-a icon-part1"></i>
                        <i class="icon-a icon-part2"></i>
                        <i class="icon-a icon-part3"></i>
                        <i class="icon-a icon-part4"></i>
                        <i class="icon-a icon-part5"></i>
                        <i class="icon-a icon-part6"></i>
                        <i class="icon-a icon-part7"></i>
                        <i class="icon-a icon-part8"></i>
                        <i class="icon-a icon-part9"></i>
                        <i class="icon-a icon-part10"></i>
                        <i class="icon-a icon-part11"></i>
                        <i class="icon-a icon-part12"></i>
                        <i class="icon-a icon-part13"></i>
                        <i class="icon-a icon-part14"></i>
                        <i class="icon-a icon-part15"></i>
                        <i class="icon-a icon-part16"></i>
                        <i class="icon-a icon-part17"></i>
                        <i class="icon-a icon-part18"></i>
                    </div>
                    <div class="text clearfix">
                        <a href="http://www.lulutrip.com/" target="_blank">美国华人旅行社</a>
                        <a href="http://www.globerouter.com" target="_blank">globerouter</a>
                        <a href="http://www.springtour.com" target="_blank">春秋旅游网</a>
                        <a href="http://www.huizuche.com" target="_blank">国际租车</a>
                        <a href="http://www.tianxun.com" target="_blank">天巡廉价航空</a>
                        <a href="http://g.58.com/j-glnewyork/" target="_blank">58同城纽约站</a>
                    </div>
                </div>
            </div>
            <div class="foot-midd clearfix">
                <div class="foot-midd-li">
                    <a rel="nofollow" target="_blank" href="http://www.lulutrip.com/page/about" class="tile">关于我们</a>
                    <a rel="nofollow" target="_blank" href="http://www.lulutrip.com/page/team">专业团队</a>
                    <a rel="nofollow" target="_blank" href="http://www.lulutrip.com/page/collaboration">商务合作</a>
                    <a rel="nofollow" target="_blank" href="http://www.lulutrip.com/page/jobs">加入我们</a>
                    <a rel="nofollow" target="_blank" href="http://www.lulutrip.com/page/contact">联系我们</a>
                </div>
                <div class="foot-midd-li">
                    <a target="_blank" href="http://www.lulutrip.com/qna/entry" class="tile">帮助中心</a>
                    <a target="_blank" href="http://www.lulutrip.com/qna/entry/category-15">订购问题</a>
                    <a target="_blank" href="http://www.lulutrip.com/qna/entry/category-16">付款问题</a>
                    <a target="_blank" href="http://www.lulutrip.com/qna/entry/category-9">行程问题</a>
                    <a target="_blank" href="http://www.lulutrip.com/qna/entry/category-40">签证问题</a>
                </div>
                <div class="foot-midd-li">
                    <a rel="nofollow" target="_blank" href="http://www.lulutrip.com/page/terms_and_conditions" class="tile"> 服务条款</a>
                    <a rel="nofollow" target="_blank" href="http://www.lulutrip.com/page/term_of_use">更改取消</a>
                    <a rel="nofollow" target="_blank" href="http://www.lulutrip.com/page/lowprice_guarantee">低价保证</a>
                    <a rel="nofollow" target="_blank" href="http://www.lulutrip.com/page/member_level_index">会员制度</a>
                    <a rel="nofollow" target="_blank" href="http://article.lulutrip.com/view/id-199">积分制度</a>
                </div>
                <div class="foot-midd-li">
                    <a href="javascript:;" class="tile special">发现</a>
                    <a target="_blank" href="http://article.lulutrip.com/">文章中心</a>
                    <a target="_blank" href="http://www.lulutrip.com/page/sitemap">网站地图</a>
                    <a target="_blank" href="http://www.lulutrip.com/special/activity_index">活动专区</a>
                    <a target="_blank" href="http://bbs.lulutrip.com/topic/entry/type-5">结伴专区</a>
                </div>
                <div class="foot-midd-li">
                    <a href="javascript:;" class="tile special">省心小工具</a>
                    <a target="_blank" href="http://www.lulutrip.com/tool/visa">签证信模板</a>
                    <a target="_blank" href="http://www.lulutrip.com/scene">景点导航</a>
                </div>
                <div class="foot-midd-li foot-midd-tel">
                    <div class="tit">全球 7x24小时客服电话</div>
                    <ul class="clearfix">
                        <?php foreach($tel as $key => $item):?>
                            <?php if ($key < 10):?>
                            <li><?= $item['areaname']?><br><?= $item['phone']?></li>
                            <?php endif;?>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
            <div class="foot-copy clearfix">
                <div class="foot-copy-l">
                    <i class="icon-foot icon-foot1"></i>
                    <i class="icon-foot icon-foot2"></i>
                    <i class="icon-foot icon-foot3"></i>
                </div>
                <div class="foot-copy-m"> Copyright © 2007-2017 | 路路行旅游 Lulutrip | All Rights Reserved.<br />
                    路路行(上海)商务咨询有限公司 & 深圳市揽胜天下国际旅行社有限公司 | <a href="http://www.miitbeian.gov.cn" target="_blank" style="color: #999;">粤ICP备13084118号-11</a></div>
                <div class="foot-copy-r">
                    <div class="copy-wx"><a class="f-social icon-weixin" href="javascript:;"></a><div class="copy-wx-code"></div></div>
                    <a class="f-social icon-weibo" href="http://weibo.com/lulutrip" target="_blank"></a>
                    <a class="f-social icon-wei-f" href="https://www.facebook.com/lulu.trip/timeline/" target="_blank"></a>
                    <input type="hidden" id="sidebar-cart-num" value="<?= $cartNum?>">
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="reveal-modal">
        <div class="media">
            <input type="hidden" class="IPArea" value="China">
            <video id="play_media" preload="none" controls video-id="1" name="media">
                <source src="http://video.cdn.lulutrip.com/lltvideo/llt_9years_animation_720p.mp4" type="video/mp4">
            </video>
        </div>
        <a class="playPause"><img src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/play.png'?>"></a>
        <a class="close-reveal-modal">&#215;</a>
    </div>
    <div class="reveal-modal-bg"></div>

</footer>
<?php if(Yii::$app->controller->id == 'channel' || Yii::$app->controller->id == 'tour-list'):?>
<?= Yii::$app->view->renderFile('@lulutrip/modules/channel/views/widgets/footer/banner.php');?>
<?php endif;?>
