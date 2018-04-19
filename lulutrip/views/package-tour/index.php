<link href="<?= Yii::$app->helper->getFileUrl('/css/index_14.css')?>" rel="stylesheet">
<link href="<?= Yii::$app->helper->getFileUrl('/css/import.css')?>" rel="stylesheet">
<link href="<?= Yii::$app->helper->getFileUrl('/css/channel_common.css')?>" rel="stylesheet">
<link href="<?= Yii::$app->helper->getFileUrl('/css/search.css')?>" rel="stylesheet">
<link href="<?= Yii::$app->helper->getFileUrl('/css/private_tour_new.css')?>" rel="stylesheet">
<script language="javascript" type="text/ecmascript" src="<?= Yii::$app->helper->getFileUrl('/js/jquery.min.js', 1)?>"></script>

<div class="ptIndexpage">
    <!-- 视频弹出框 -->
    <div class="video-Modal" id="videoModal">
      <div class="modal-video">
        <video id="right-modal-video" preload="none" controls width="1110" height="620" video-id="1" name="media">

        </video>
        <a class="close-video-modal">×</a>
      </div>
      <div class="modal-bg"></div>
    </div>
    <div class="ptindex_header">
        <div class="wrap3">
            <a href="<?= Yii::$app->params['service']['www']?>/<?php if($navigationtype == 'EU') { echo 'europe';}elseif($navigationtype == 'AU'){echo 'australia_newzealand';}?>" target="_blank"><img src="<?=Yii::$app->helper->getFileUrl('/images/common/logo_0715.png')?>" width="200" height="59" alt="路路行"></a>
            <div class="ptindex_weixin">
                <span><img src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/ptindex_weixin.jpg')?>">添加微信1对1客服定制</span>
                <div class="weixin_on"><img src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/ptindex_03_weixin.jpg')?>"></div>
            </div>
            <div class="ptindex_nav">
                <ul>
                    <li class="on"><a href="javascript:;">一键包团</a></li>
                    <li><a href="javascript:;">热卖亲友小团</a></li>
                    <li><a href="javascript:;">中文用车</a></li>
                    <li><a href="javascript:;">一对一个性化定制</a></li>
                    <li><a href="javascript:;">定制成果分享</a></li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="banner">
        <div class="banner-wrapper" id="bannerWrapper">
            <ul class="banner-list">
                <li>
                    <a href="javascript:;" target="_blank" data-type="cariphone" class="right-video" style="background: url(<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/bus_ban_1009_01.jpg')?>) no-repeat center 0, url(<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/bus_ban_1009_02.jpg')?>) no-repeat center 150px;"></a>
                </li>
                <li>
                    <a href="javascript:;" target="_blank" data-type="hotel_v2" class="right-video" style="background: url(<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/hotel_video.jpg')?>) center no-repeat"></a>
                </li>
            </ul>
            <div class="ctrl-btn" id="ctrlBtn">
                <span class="on"></span>
                <span></span>
            </div>
        </div>
    </div>
    <div class="bus-banner play-button-01">
        <div class="bus-wd1200">
            <div class="bus-pause"></div>
        </div>
    </div>
    <div class="ptindex_banner">
        <div class="wrap3">
            <div class="text">
                <h1>微定制 ，我先行</h1>
                <p>为亲友定制一次旅行，你的奇思妙想与我们的专业路线规划的融合是一<br>次全新的旅行体验。将由我们为你开启一次微定制的旅程</p>
                <p>或者，我先行，告诉我你的旅行目的地，其余都交给我们<br>定制简单，和爱的人去任何想去的地方</p>
                <a class="more" href="<?= Yii::$app->params['service']['www']?>/private/tour_book/type-tour" target="_blank"><img src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/ptindex_banner_btn.png')?>"></a>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="ptindex_01 ptindex_nav_list">
        <div class="wrap3">
            <div class="tit">
                <h1>亲友小团 一键搞定</h1>
                <p>来一场微定制的私享旅行，“游”我们统统搞定</p>
            </div>
            <div class="cont">
                <ul>
                    <li class="west"><a href="/privatetour/entry/region-USWest" target="_blank"><i></i><span>美西定制路线<em>WEST COAST</em></span></a></li>
                    <li class="east"><a href="/privatetour/entry/region-USEast" target="_blank"><i></i><span>美东定制路线<em>EAST COAST</em></span></a></li>
                    <li class="europe"><a href="/privatetour/entry/region-EU" target="_blank"><i></i><span>欧洲定制路线<em>EUROPE</em></span></a></li>
                    <li class="aust"><a href="/privatetour/entry/region-AU" target="_blank"><i></i><span>澳新定制路线<em>Australia & New Zealand</em></span></a></li>
                    <li class="canada"><a href="/privatetour/entry/region-Canada" target="_blank"><i></i><span>加拿大定制路线<em>CANADA</em></span></a></li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="ptindex_02 ptindex_nav_list">
        <div class="wrap3">
            <div class="tit"><h1>当季热卖</h1></div>
            <div class="cont">
                <ul>
                    <?php foreach($tours as $tour):?>
                        <li>
                            <a href="<?= Yii::$app->params['service']['www'] . '/' . $tour['link']?>" target="_blank">
                                <div class="img"><img width="280" height="346" src="<?= Yii::$app->helper->getImgDomain() . '/' . $tour['tf_cover']?>"></div>
                                <div class="name"><?= $tourNames[$tour['tourcode']]?></div>
                                <div class="price"><span><?= Yii::$app->params['curCurrencies']['sign']?> <b><?= $tour['prices']['min'][Yii::$app->params['curCurrency']]?></b></span> 起/人</div>
                                <div class="btn">我要报价</div>
                            </a>
                        </li>
                    <?php endforeach;?>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
        <div class="more"><a href="<?= Yii::$app->params['service']['www'] . '/promotion/privatetourNA'?>">点击查看全部</a></div>
    </div>
    <div class="ptindex_06 ptindex_nav_list">
        <div class="wrap3">
            <div class="tit">
                <h1>中文用车</h1>
            </div>
            <div class="cont">
                <ul>
                    <li>
                        <a href="<?= Yii::$app->params['service']['www'] . '/private/bus/region-NA'?>" target="_blank">
                            <img src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/privatetour-bug-am.jpg')?>">
                            <h3 class="bug-am"></h3>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Yii::$app->params['service']['www'] . '/private/bus/region-EU'?>" target="_blank">
                            <img src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/privatetour-bug-eu.jpg')?>">
                            <h3 class="bug-eu"></h3>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Yii::$app->params['service']['www'] . '/private/bus/region-AU'?>" target="_blank">
                            <img src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/privatetour-bug-au.jpg')?>">
                            <h3 class="bug-au"></h3>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="ptindex_03 ptindex_nav_list">
        <div class="wrap3">
            <div class="tit">
                <h1>旅行顾问</h1>
                <p>没有合适的路线？一对一个性化定制</p>
            </div>
            <div class="cont">
                <ul>
                    <?php foreach($advister as $value):?>
                        <li>
                            <a href="<?= Yii::$app->params['service']['www']?>/adviser/home/id-<?= $value['id'] ?>" target="_blank">
                                <div class="img">
                                    <span><img src="<?= Yii::$app->helper->getImgDomain() . '/' . $value['avatar_1'] ?>" width="136" height="136" onerror="this.src='//s01.quimg.com/images/client_service_home/user.png';"><img src="<?= Yii::$app->helper->getImgDomain() . '/' . $value['avatar_2'] ?>" width="136" height="136" onerror="this.src='//s01.quimg.com/images/client_service_home/user.png';"></span>
                                </div>
                                <div class="name"><?= $value['name_en']?></div>
                                <div class="info"><?= $value['country']?>当地顾问</div>
                                <div class="btn">看看TA的介绍</div>
                            </a>
                        </li>
                    <?php endforeach;?>

                </ul>
                <div class="clear"></div>
            </div>
            <div class="cust">
                <div class="img"><img src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/ptindex_03_weixin.jpg')?>"></div>
                <div class="text">
                    <span>扫描二维码，添加微信咨询定制信息</span>
                    <p>您也可以直接点击“<a href="<?= Yii::$app->params['service']['www']?>/private/tour_book/type-tour" target="_blank">我要定制</a>”进行定制</p>
                </div>
            </div>
        </div>
    </div>
    <div class="ptindex_04 ptindex_nav_list">
        <div class="wrap3">
            <div class="tit">
                <h1>定制成果分享</h1>
                <p>没有合适的路线？一对一个性化定制</p>
            </div>
            <div class="grop_case">
                <div class="grop_t">
                    <ul>
                        <li id="case_1tit" class="on" index="case1"><a href="javascript:;">用户评论<span></span></a></li>
                        <li id="case_2tit" index="case2"><a href="javascript:;">美东8日游<span></span></a></li>
                        <li id="case_3tit" index="case3"><a href="javascript:;">美西十一日游<span></span></a></li>
                        <li id="case_4tit" index="case4"><a href="javascript:;">美东+美西十八日游<span></span></a></li>
                    </ul>
                </div>
                <div class="grop_list">
                    <div class="grop_li case1" style="display:block;">
                        <ul class="ptivate_mask_list">
                        </ul>
                        <div class="bottom_pagenum">
                            <div style="margin-left: -241.5px;" class="bg_navs">
                                <div class="fl">
                                    <a class="pre_page" href="javascript:;"><b></b></a>
                                </div>
                                <div class="fl numbers">
                                    <a href="javascript:;" class="current">1</a>
                                </div>
                                <div class="fl">
                                    <a href="javascript:;" class="next_page"><b></b></a>
                                </div>
                                <div class="fl skip_page"></div>
                            </div>
                        </div>
                    </div>
                    <div class="grop_li case2" id="case_2con">
                        <p class="f20">美东八日名校游</p>
                        <p class="mt10">家长和孩子参观名校+游览美东纽约、华盛顿、波士顿、尼亚加拉大瀑布。行程灵活调整，司导全程一对一服务包团游。</p>
                        <div class="img">
                            <img src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/ptindex_04_img1_1.jpg')?>">
                            <img src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/ptindex_04_img1_2.jpg')?>">
                            <img src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/ptindex_04_img1_3.jpg')?>">
                        </div>
                    </div>
                    <div class="grop_li case3" id="case_3con">
                        <p class="f20">美西加州三城十一日家庭游</p>
                        <p class="mt10">一家老小一同出游，美西洛杉矶、旧金山、圣地亚哥海滨风光、自然美景、人文风光相结合，体验一号公路。行程灵活调整，司导全程一对一服务包团游。</p>
                        <div class="img">
                            <img src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/ptindex_04_img2_1.jpg')?>">
                            <img src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/ptindex_04_img2_2.jpg')?>">
                            <img src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/ptindex_04_img2_3.jpg')?>">
                        </div>
                    </div>
                    <div class="grop_li case4" id="case_4con">
                        <p class="f20">美东+美西全览十八日退休人士夕阳游</p>
                        <p class="mt10">老友结伴出国游。一次行程美东、美西一网打尽。美东的城市人文风光、美西的海滨城市、自然美景应有尽有。行程灵活调整，司导全程一对一服务包团游。</p>
                        <div class="img">
                            <img src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/ptindex_04_img3_1.jpg')?>">
                            <img src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/ptindex_04_img3_2.jpg')?>">
                            <img src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/ptindex_04_img3_3.jpg')?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ptindex_05">
        <div class="wrap3">
            <ul>
                <li><i class="i_01"></i><span>美国加州旅行资质执照<em>#2090384-40</em></span></li>
                <li><i class="i_02"></i><span>海外华人旅游第一品牌<em>NTA会员 10年服务超过百万华人</em></span></li>
                <li><i class="i_03"></i><span>行业先锋 服务最靠谱<em>0秒确认 24/7北美双语客服</em></span></li>
                <li><i class="i_04"></i><span>低价保障 支付安全<em>当地直采最优价格 SSL国际认证</em></span></li>
                <li><i class="i_05"></i><span>最优质精品行程<em>10,000+当地参团 8,000+当地玩乐</em></span></li>
            </ul>
        </div>
    </div>
    <div class="ptindex_footer">
        <div class="wrap3">
            <div class="foot_top"><span><img src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/ptindex_footer.jpg')?>"></span></div>
            <div class="foot_bt">
                <div class="foot_copy">
                    <p>Copyright © 2007-2017 | 路路行旅游  Lulutrip | All Rights Reserved.</p>
                    <p>路路行(上海)商务咨询有限公司 & 深圳市揽胜天下国际旅行社有限公司 | <a href="http://www.miitbeian.gov.cn" target="_blank" style="color: #222;">粤ICP备13084118号-11</a></p>
                </div>
                <div class="foot_menu">
                    <ul>
                        <li><a href="<?= Yii::$app->params['service']['www']?>" target="_blank">首页</a></li>
                        <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-US" target="_blank">旅行团</a></li>
                        <li><a href="/private/tour_book/type-tour" target="_blank">包团定制</a></li>
                        <li><a href="<?= Yii::$app->params['service']['www']?>/activity/entry/region-US" target="_blank">当地玩乐</a></li>
                        <li class="menu_moble"><a href="javascript:;">手机版</a><span><img src="<?= Yii::$app->helper->getFileUrl('/images/common/app.jpg')?>"></span></li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>  
<div class="case_bac"></div>
    <div class="case_detail_con_01">
        <div class="case_cha"><img src="<?= Yii::$app->helper->getFileUrl('/images/private_tour_new/case_cha.png')?>"/></div>
        <div class="private_mask">
            <img class="private_mask_big_img" src="<?=Yii::$app->helper->getFileUrl('/images/private_tour_new/pri_mask_img01.jpg')?>"/>
        </div>
    </div>
    <div class="case_detail_con" id="case_2">
        <div class="case_title">美东八日游<div class="case_cha"><img src="<?= Yii::$app->helper->getFileUrl('/images/private_tour_new/case_cha.png')?>" alt=""/></div></div>
        <div class="case_inner">
            <div class="case_intro">
                <div class="intro_left">北京私企老总吴先生带太太及15岁上高中的兒子</br>
                    基础行程选择：<i>＃149</i></div>
                <div class="intro_right">总团费：<i>$7547</i></div>
            </div>
            <div class="view_part part_1">
                <div class="person person_1">
                    <div class="per_img per_img_1"><img src="<?= Yii::$app->helper->getFileUrl('/images/private_tour_new/per_1.png')?>" alt=""></div>
                    <span>吴先生</span>
                </div>
                <div class="view_one">
                    <div class="part_con">
                        <b>家人的需求：</b>
                        1. 希望多看几所美国的名校 为孩子上大学做参考<br/>
                        2. 要住好一点、舒适一点 安排国际知名集团酒店<br/>
                        3. 上次来还没去过大瀑布，想抽时间去看看<br/>
                        4. 孩子要参加一个一天的夏令营 家长想有自由活动时间
                    </div>
                </div>
            </div>

            <div class="view_part part_2">
                <div class="person person_2">
                    <div class="per_img"><img src="<?= Yii::$app->helper->getFileUrl('/images/private_tour_new/per_2.png')?>" alt=""></div>
                    <span>行程顾问</span>
                </div>
                <div class="view_two" >
                    <div class="part_con" style="line-height:23px;">
                        <b>建议行程调整方案：</b>
                        1. 波士顿名校聚集，学术氛围好，建议加入一天波士顿行程，由当地学生带领参观哈佛大学、</br>麻省理工学院</br>
                        2. 建议加入费城的行程，参观著名的宾夕法尼亚大学沃顿商学院</br>
                        3. 加入一天大瀑布行程，建议乘坐雾中少女号 近距离接触大瀑布</br>
                        4. 全程安排升级四星酒店，Marriot或同级 推荐入住大瀑布景区四星酒店 去大瀑布更方便</br>
                        5. 建议将送机城市改为纽约，三大机场航班选择比较多，方便灵活安排行程
                    </div>
                </div>
            </div>

            <div class="view_part part_3">
                <div class="person person_3">
                    <div class="per_img"><img src="<?= Yii::$app->helper->getFileUrl('/images/private_tour_new/quotation_2.png')?>" alt=""></div>
                </div>
                <div class="view_three">
                    <div class="part_con" style="line-height:24px;">
                        <b>吴先生点评：</b>
                        我们其实不是第一次来美国玩，之前比较大众的景点基本都玩过了。这次是专门陪孩子来看看这边的</br>
                        学校，想详细的看看学校周围的生活环境。一开始我们只计划要去哥大、普林斯顿、和宾大，对其他</br>
                        学校不太了解。客服Enqi得知我们想要多看几所学校，凭借自己在美国多年生活经验，建议我们增加</br>
                        学校聚集的波士顿行程，参观了哈佛大学、麻省理工还参加了波士顿大学的招生活动。还建议了我们</br>
                        许多学校附近的游览行程，让我们能对学校周围环境有更多的了解，我们和孩子都受益良多。非常感
                        谢Enqi的专业和细致，让我们和孩子都留下了难忘的回忆！
                    </div>
                </div>
            </div>


            <!-- 具体行程 -->
            <div class="travel_details">
                <div class="travel_title">具体行程</div>
                <div class="travel_list">
                    <ul>
                        <li class="first">8天|北京出发</li>
                        <li><i>5/7</i><span>第一天：</span>孩子夏令营结束，接孩子与家长会合，夜游纽约</li>
                        <li><i>5/8</i><span>第二天：</span>孩子参加纽约大学校园活动 父母自由活动 去第五大道Shopping</li>
                        <li><i>5/9</i><span>第三天：</span>参加哥伦比亚大学Open House，由在校学生带领参观普林斯顿大学，与当地学生交流</li>
                        <li><i>5/10</i><span>第四天：</span>前往费城 由宾夕法尼亚大学学生带领参观校园 游览费城独立宫</li>
                        <li><i>5/11</i><span>第五天：</span>前往游览尼亚加拉大瀑布，乘坐雾中少女号游船 住大瀑布景区酒店</li>
                        <li><i>5/12</i><span>第六天：</span>由大瀑布前往波士顿，游览波士顿查尔斯河、波士顿图书馆和自由之路等</li>
                        <li><i>5/13</i><span>第七天：</span>本校学生带领游览哈佛大学、麻省理工学院、参加波士顿大学招生Open House</li>
                        <li style="height:20px;"><i>5/14</i><span>第八天：</span>由波士顿返回纽约 机场送机</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="case_detail_con" id="case_3">
        <div class="case_title">美西十一日游<div class="case_cha"><img src="<?= Yii::$app->helper->getFileUrl('/images/private_tour_new/case_cha.png')?>" alt=""/></div></div>
        <div class="case_inner">
            <div class="case_intro">
                <div class="intro_left" style="margin-top:-15px;">李先生 47岁 上海某外企员工 与家人一行8人（ 李先生夫妇与上高中的女儿，李先生的父母
                    ，李先生的妹妹带上初中的孩子）
                    基础行程选择：<i>＃11</i></div>
                <div class="intro_right">总团费：<i>$16106</i></div>
            </div>
            <div class="view_part part_1">
                <div class="person person_1">
                    <div class="per_img per_img_1"><img src="<?= Yii::$app->helper->getFileUrl('/images/private_tour_new/per_1.png')?>" alt=""></div>
                    <span>李先生</span>
                </div>
                <div class="view_one">
                    <div class="part_con" style="margin-top:-15px;">
                        <b style="margin-bottom:10px;">家人的需求：</b>
                        1. 希望能与父母住一间房，跟老人有个照应，住宿要舒适些<br/>
                        2. 太太和妹妹想去奥特莱斯购物<br/>
                        3. 孩子想去环球影城玩，但是老人家不想去<br/>
                        4. 妹妹的孩子要参加一天的夏令营</br>
                        5. 老人家想游览一些自然景观</br>
                    </div>
                </div>
            </div>

            <div class="view_part part_2">
                <div class="person person_2">
                    <div class="per_img"><img src="<?= Yii::$app->helper->getFileUrl('/images/private_tour_new/per_img_3.png')?>" alt=""></div>
                    <span>行程顾问</span>
                </div>
                <div class="view_two">
                    <div class="part_con" style="line-height:23px;width:500px">
                        <b>建议行程调整方案：</b>
                        1. 建议酒店房间为一间家庭房，一间普通标准房，方便李先生与父母同住</br>
                        2. 建议加入一天奥特莱斯购物行程</br>
                        3. 送妹妹的孩子去参加夏令营之后，建议安排一天家人自由活动</br>
                        4. 安排年轻人去环球影城的同时，李先生同父母可以去洛杉矶市区观光，参观比弗利山庄、
                        星光大道等</br>
                        5. 更改大峡谷行程为一号公路旧金山参观
                    </div>
                </div>
            </div>

            <div class="view_part part_3">
                <div class="person person_3">
                    <div class="per_img"><img src="<?= Yii::$app->helper->getFileUrl('/images/private_tour_new/quotation_2.png')?>" alt=""></div>
                </div>
                <div class="view_three">
                    <div class="part_con" style="line-height:25px;">
                        <b>李先生点评：</b>
                        这是我们全家第一次来美国旅游，因为家人想玩的地方比较多所以决定包团，但是
                        老人和孩子都有非常多要求，给客服打电话的时候我都很头大，但是非常感谢路路行的行程顾问
                        Yawen，人非常耐心和细致，挨个记下我的要求，帮我逐一确认和修改，真的非常负责。还帮我
                        们定家庭房型的酒店，让我们和老人互相有照应。非常感谢Yawen的帮助，让我们全家每个人都
                        玩的非常尽兴！
                    </div>
                </div>
            </div>


            <!-- 具体行程 -->
            <div class="travel_details">
                <div class="travel_title">具体行程</div>
                <div class="travel_list">
                    <ul>
                        <li class="first">11天|上海出发：</li>
                        <li><i>7/16</i><span>第一天：</span>洛杉矶机场接机，洛杉矶市区自由活动</li>
                        <li><i>7/17</i><span>第二天：</span>在洛杉矶市区 游 参观比弗利山庄、星光大道</li>
                        <li><i>7/18</i><span>第三天：</span>李先生的妹妹带两个孩子玩环球影城，李先生夫妇带父母去圣塔莫妮卡海滩 晚上全家一
                            起去葛瑞菲斯天文台</li>
                        <li><i>7/19</i><span>第四天：</span>圣地亚哥观光，游览圣地亚哥海洋世界、圣地亚哥海港</li>
                        <li><i>7/22</i><span>第五天：</span>Desert Hills 奥特莱斯逛街</li>
                        <li><i>7/23</i><span>第六天：</span>洛杉矶 — 旧金山。游览圣塔芭芭拉、丹麦城</li>
                        <li><i>7/24</i><span>第七天：</span>旧金山市区观光。游览渔人码头、金门大桥、九曲花街、罗马艺术宫、双子峰、旧金山
                            市政府大楼、中国城</li>
                        <li><i>7/25</i><span>第八天：</span>游览纳帕酒庄,乘坐热气球</li>
                        <li><i>7/26</i><span>第九天：</span>旧金山出發前往优胜美地遊覽，住优胜美地景区</li>
                        <li><i>7/27</i><span>第十天：</span>优胜美地 — 旧金山</li>
                        <li style="height:20px;"><i>7/28</i><span>第十一天：</span>硅谷参观。游览斯坦福大学、硅谷高科技公司。 接著送往旧金山机场搭机返家</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="case_detail_con" id="case_4">
        <div class="case_title">美东+美西十八日游<div class="case_cha"><img src="<?= Yii::$app->helper->getFileUrl('/images/private_tour_new/case_cha.png')?>" alt=""/></div></div>
        <div class="case_inner">
            <div class="case_intro">
                <div class="intro_left" style="margin-top:-15px;">用户：陈先生夫妇、张先生夫妇、赵先生夫妇、何先生夫妇 ，几个广州退休教授结伴出游</br>
                    基础行程选择：<a href="/privatetour/view-125" target="_blank">＃125</a><a href="/privatetour/view-3" target="_blank">#3</a></i></div>
                <div class="intro_right">总团费：<i>$29399</i></div>
            </div>
            <div class="view_part part_1">
                <div class="person person_1">
                    <div class="per_img per_img_1"><img src="<?= Yii::$app->helper->getFileUrl('/images/private_tour_new/per_1.png')?>" alt=""></div>
                    <span>陈先生及朋友</span>
                </div>
                <div class="view_one">
                    <div class="part_con">
                        <b>陈先生及朋友的需求：</b>
                        1. 我们已经退休了，时间比较多想多玩几天，美东美西都想去<br/>
                        2. 我们都是摄影爱好者，想多看一些自然风光，在黄石公园多呆两天<br/>
                        3. 太太们想要去购物<br/>
                        4. 要住好一点的国际知名集团酒店
                    </div>
                </div>
            </div>

            <div class="view_part part_2">
                <div class="person person_2">
                    <div class="per_img"><img src="<?= Yii::$app->helper->getFileUrl('/images/private_tour_new/per_img_2.png')?>" alt=""></div>
                    <span>行程顾问</span>
                </div>
                <div class="view_two">
                    <div class="part_con" style="line-height:25px;">
                        <b>建议行程调整方案：</b>
                        1. 建议行程时间延长，美西游览之后衔接美东游览</br>
                        2. 建议加入美东最大奥特莱斯纽约Woodbury购物行程</br>
                        3. 安排入住黄石公园小木屋，更深度游览黄石</br>
                        4. 全程酒店升级为四星酒店 入住Marriott或同级
                    </div>
                </div>
            </div>

            <div class="view_part part_3">
                <div class="person person_3">
                    <div class="per_img"><img src="<?= Yii::$app->helper->getFileUrl('/images/private_tour_new/quotation_2.png')?>" alt=""></div>
                </div>
                <div class="view_three">
                    <div class="part_con"  style="line-height:25px;">
                        <b>陈先生点评：</b>
                        以前上班没时间，退休之后我们几个老朋友一直想慢慢把美国玩遍，但是我们都没
                        什么概念，就想去个黄石公园，和自然风光比较漂亮的地方。路路行的客服Ann非常耐心的给我
                        们逐一讲解美国各个景点的地理位置，给我们安排行程。在Ann贴心的建议下我们住在黄石公园
                        小木屋，省了许多时间，拍摄了好多大作，晒到朋友圈收获好多点赞！下次有朋友要来美国还会
                        推荐路路行的，还会推荐Ann的，谢谢！
                    </div>
                </div>
            </div>


            <!-- 具体行程 -->
            <div class="travel_details">
                <div class="travel_title">具体行程</div>
                <div class="travel_list">
                    <ul>
                        <li class="first">17天|广州出发：</li>
                        <li><i>8/7</i><span>第一天：</span>洛杉矶接机 自由活动</li>
                        <li><i>8/8</i><span>第二天：</span>洛杉矶市区观光，参观比弗利山庄、星光大道、圣塔莫妮卡海滩</li>
                        <li><i>8/9</i><span>第三天：</span>圣地亚哥市区观光。游览圣地亚哥海港、巴博亚公园、圣地亚哥老城</li>
                        <li><i>8/10</i><span>第四天：</span>洛杉矶拉斯维加斯 晚上在拉斯维加斯看太阳马戏团秀</li>
                        <li><i>8/11</i><span>第五天：</span>拉斯维加斯圣乔治</li>
                        <li><i>8/12</i><span>第六天：</span>前往世界十大摄影地之一的羚羊彩穴摄影、游览包伟湖、格兰大坝 布莱斯峡谷</li>
                        <li><i>8/13</i><span>第七天：</span>游览杰克逊、大提顿公园、入住西黄石镇</li>
                        <li><i>8/14</i><span>第八天：</span>入园黄石公园：观看老忠实喷泉喷发、黄石峡谷、西拇指湖 入住黄石公园老忠实小木屋</li>
                        <li><i>8/15</i><span>第九天：</span>在黄石湖看日出、游览大棱镜热泉、徒步上间歇泉步道、猛犸温泉看日落</li>
                        <li><i>8/16</i><span>第十天：</span>前往盐湖城 参观大盐湖，摩门圣殿广场、犹他州政府大厦</li>
                        <li><i>8/17</i><span>第十一天：</span>盐湖城飞往纽约 纽约接机 纽约市区自由活动 夜游时代广场</li>
                        <li><i>8/18</i><span>第十二天：</span>纽约城市游览 大都会博物馆、登顶帝国大厦、自由女神环岛游，华尔街铜牛，中国城</li>
                        <li><i>8/19</i><span>第十三天：</span>前往纽约Woodbury奥特莱斯购物</li>
                        <li><i>8/20</i><span>第十四天：</span>游览费城独立宫、华盛顿纪念碑、外观白宫、入国会大厦参观</li>
                        <li><i>8/21</i><span>第十五天：</span>前往尼亚加拉大瀑布 看大瀑布夜景 入住瀑布景区酒店</li>
                        <li><i>8/22</i><span>第十六天：</span>游览尼亚加拉大瀑布 乘坐雾中少女号游船 深入大瀑布 参观完后前往波士顿</li>
                        <li style="height:20px;"><i>8/23</i><span>第十七天：</span>游览波士顿市自由之路、波士顿图书馆、哈佛大学、昆西市场 晚上送机波士顿机场</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(function(){
        $(".grop_t li").hover(function() {
            var index =$(this).attr("index");
            $(this).addClass("on").siblings(".on").removeClass("on");
            $(".grop_list ."+index).show().siblings(".grop_li").hide();
        });

        $("[id*='tit'],[id*='con']").stop(true).on('click', function () {
            var case_id = $(this).attr("id");
            var case_idString = case_id.substr(0, case_id.length - 3);
            var case_idDiv = document.getElementById(case_idString).id;
            $('.case_bac').show();
            $('#'+case_idDiv).show();
        });
        $(".ptivate_mask_list").on("click","li",function(){
            var index =$(this).html();
            $(".case_detail_con_01 .private_mask").html(index);
            $(".case_detail_con_01 .private_mask img").addClass("private_mask_big_img");
            $('.case_bac').show();
            $(".case_detail_con_01").show();
        })
        $('.case_cha').click(function(){
            $('.case_bac').hide();
            $('.case_detail_con').hide();
            $('.case_detail_con_01').hide();
        });
        // 条件模块定位
        $('.ptindex_nav li').click(function() {
            var ind1 = $(this).index();
            $(this).addClass("on").siblings("li").removeClass("on");
            var topva = $(".ptindex_nav_list").eq(ind1).offset().top-80;
            $('body,html').stop().animate({scrollTop:topva}, 800);
        });

//        用户评论模块异步请求数据获取图片和分页数据
        var pageNum = 1;//总页数
        function userReview(pageNo){
            var pageNo = pageNo ? pageNo : 1;//当前请求的页码
            var html01="";//图片内容
            var html02="";//分页内容
            var total=1;
            var list="";
            var pageReg=0;
            $.ajax({
                url: "<?= Yii::$app->params['service']['www'] . '/llt/ajax/get_feedback?page='?>" + pageNo,
                success: function( result ) {
                    result = JSON.parse(result);
                    total=result.data.count;
                    list=result.data.feedback;
                    pageNum= Math.ceil(total/4);
                    pageReg=(total%4);
                    if(total==0){
                        $("#case_1tit").remove();
                        $("#case_2tit").addClass("on");
                        $(".case2").show().siblings(".grop_li").hide();
                    }else{
                        var imgDomain = "<?= Yii::$app->helper->getImgDomain(). '/'?>";
                        for(var i=0;i<list.length;i++){
                            html01+=`<li><img width="538" height="807" src="`+imgDomain+list[i].image+`"></li>`;
                        }
                        for(var j=1;j<=pageNum;j++){
                            html02+=`<a class="${j}">${j}</a>`
                        }
                        $(".ptivate_mask_list").html(html01);
                        $(".bottom_pagenum .numbers").html(html02);
                        $(".bottom_pagenum .skip_page ").html("共有"+pageNum+"页");
                        $(".bottom_pagenum .numbers ."+pageNo).addClass("current");
                    }
                }
            });
        }
        userReview();
        //为每个分页绑定点击事件
        $(".bottom_pagenum .numbers").on("click","a",function( event){
            event.preventDefault();
            var pageNo=parseInt($(this).html());
            userReview(pageNo);
        })
        //上一页和下一页切换
        $(".bottom_pagenum .pre_page").click(function(){
            var pageNo= parseInt($(".bottom_pagenum .numbers .current").html())-1;
            if (pageNo > 0) {
                userReview(pageNo);
            }
        });
        $(".bottom_pagenum .next_page").click(function(){
            var pageNo= parseInt($(".bottom_pagenum .numbers .current").html())+1;
            if (pageNo <= pageNum) {
                userReview(pageNo);
            }
        });

        /**
           * 视频播放事件
           */
          let videomp = document.getElementById("right-modal-video");
          $('.right-video').bind("click",function(){
            let type = $(this).attr('data-type');
            $('#videoModal').show();
            $('#right-modal-video').html('<source src="http://files.cdn.quimg.com/'+type+'.mp4" type="video/mp4">');
            videomp.load();
            videomp.play();
          });
          $('.close-video-modal').bind("click",function(){
            $('#videoModal').hide();
            videomp.pause();
          });
        
        const bannerSlider = new Slider($('#bannerWrapper'), {
        auto: true,
        time: 4000,
        event: 'hover',
        mode: 'slide',
        controller: $('#ctrlBtn'),
        activeControllerCls: 'on'
        });

});
</script>
<script>
    const Slider = function(container, customOptions) {
            if (!container) return;

            var options = customOptions || {},
                currentIndex = 0,
                cls = options.activeControllerCls,
                delay = options.delay,
                isAuto = options.auto,
                controller = options.controller,
                event = options.event,
                interval,
                slidesWrapper = container.children().first(),
                slides = slidesWrapper.children(),
                length = slides.length,
                childWidth = container.width(),
                totalWidth = childWidth * slides.length;

            function init() {
                var controlItem = controller.children();

                mode();

                if (event == 'hover') {
                    controlItem.mouseover(function() {
                        stop();
                        var index = $(this).index();

                        play(index, options.mode);
                    }).mouseout(function() {
                        isAuto && autoPlay();
                    });
                } else {
                    controlItem.click(function() {
                        stop();
                        var index = $(this).index();

                        play(index, options.mode);
                        isAuto && autoPlay();
                    });
                }

                isAuto && autoPlay();
            }

          // animate mode
            function mode() {
                var wrapper = container.children().first();

                if (options.mode == 'slide') {
                    wrapper.width(totalWidth);
                    slides.each(function() {
                        $(this).width(childWidth);
                    });
                } else {
                    wrapper.children().css({
                        'position': 'absolute',
                        'left': 0,
                        'top': 0
                    }).first().siblings().hide();
                }
            }

          // auto play
            function autoPlay() {
                interval = setInterval(function() {
                    triggerPlay(currentIndex);
                }, options.time);
            }

          // trigger play
            function triggerPlay(cIndex) {
                var index;

                (cIndex == length - 1) ? index = 0 : index = cIndex + 1;
                play(index, options.mode);
            }

          // play
            function play(index, mode) {
                slidesWrapper.stop(true, true);
                slides.stop(true, true);

                mode == 'slide' ? (function() {
                    if (index > currentIndex) {
                        slidesWrapper.animate({
                            left: '-=' + Math.abs(index - currentIndex) * childWidth + 'px'
                        }, delay);
                    } else if (index < currentIndex) {
                        slidesWrapper.animate({
                            left: '+=' + Math.abs(index - currentIndex) * childWidth + 'px'
                        }, delay);
                    } else {
                        return;
                    }
                })() : (function() {
                    if (slidesWrapper.children(':visible').index() == index) {
                        return;
                    }
                    slidesWrapper.children().fadeOut(delay).eq(index).fadeIn(delay);
                })();

                try {
                    controller.children('.' + cls).removeClass(cls);
                    controller.children().eq(index).addClass(cls);
                } catch (e) {
              // TODO
                }

                currentIndex = index;

                options.exchangeEnd && typeof options.exchangeEnd == 'function' && options.exchangeEnd.call(this, currentIndex);
            }

          // stop
            function stop() {
                clearInterval(interval);
            }

          // prev frame
            function prev() {
                stop();

                currentIndex == 0 ? triggerPlay(length - 2) : triggerPlay(currentIndex - 2);

                isAuto && autoPlay();
            }

          // next frame
            function next() {
                stop();

                currentIndex == length - 1 ? triggerPlay(-1) : triggerPlay(currentIndex);

                isAuto && autoPlay();
            }

          // init
            init();

          // expose the Slider API
            return {
                prev: function() {
                    prev();
                },
                next: function() {
                    next();
                }
            };
        };
</script>
