<?php
use lulutrip\components\Helper;
use yii\helpers\Html;
$cookies = Yii::$app->request->cookies;
$get = Yii::$app->request->get();

//产品品级
$tourGrades = [
    0 => '未标记',
    1 => '短途周边',
    2 => '豪华',
    3 => '一地深度',
    4 => '小众',
    5 => '多地全览',
    6 => '定制',
    7 => '经济包团',
    8 => '豪华包团',
    9 => '独家路线包团',
];
?>
<div id="main" style="background-color:#f1f5fe; width:100%; min-width:1200px;">
    <div id="body_14">
        <div class="pt_bread_navs">
            <?= \yii\widgets\Breadcrumbs::widget([
                'itemTemplate' => "<li  class='fl'>{link} ></li>", // template for all links
                'activeItemTemplate' => "<li class=\" fl active\">{link}</li>",
                'homeLink' => [
                    'label' => '首页',
                    'url' => Yii::$app->params['service']['www'],
                    'template' => "<li  class='fl'>{link} ></li>",
                    'class' => 'check_more'
                ],
                'links' => [
                    [
                        'label' => '包团定制',
                        'url' => Yii::$app->params['service']['www'] . '/privatetour/home',
                        'template' => "<li class='fl'>{link} ></li>",
                        'class' => 'check_more'
                    ],
                    '个性化定制产品列表',
                ], 'options' => ['class' => 'bread_navs']  ]) ?>
        </div>
        <!---------------- filter ---------------->
        <div class="mt20" id="ptFilters">
            <div class="ptFilters">
                <?php foreach($filters as $key => $filter):?>
                    <?php $filterAlias = array('region' => '游玩区域', 'days' => '行程天数', 'startcity' => '出发城市')?>
                    <div class="option_d">
                        <span class="fl"><?= $filterAlias[$key]?>：</span>
                        <div class="detail_op fl">
                            <?php foreach($filter as $k => $value):?>
                                <?php if($k == 'all'){?>
                                    <a href="<?= $value['url']?>" <?php if(empty($get[$key])):?>class="op_cur"<?php endif;?>><?= $value['name']?></a>
                                <?php }else{?>
                                    <a href="<?= $value['url']?>" <?php  if(!empty($get[$key]) && $get[$key] == $k):?>class="op_cur <?= $get[$key]?>"<?php endif;?>><?= $value['name']?></a>
                                <?php }?>
                            <?php endforeach;?>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>

        <!-------------- 产品列表 -------------->
        <?php if(!empty($products)):?>
            <div class="private_entry_left">
                <div class="ptHome_trips">
                    <?php foreach($products as $pctour) {?>
                        <div class="ptHome_t_d">
                            <div class="fl" style="position:relative;">
                                <a href="<?= $pctour['link']?>" target="_blank"><img src="<?= Yii::$app->helper->getImgDomain() ?>/<?= $pctour['image']?>" onerror="this.src='<?php echo Yii::$app->request->getHostInfo(); ?>/images/no_pic.jpg';" class="lazy" style="width:300px; height:200px;" /></a>
                            </div>
                            <div class="fl ptHome_t_d_r" style="width:400px; height: 150px; border-right: 1px solid #eee; padding-right:10px;">
                                <div>
                                    <div class="fl cn_tit"><a href="<?= $pctour['link']?>" target="_blank"><?= Html::decode($pctour['title'])?></a></div>
                                    <div class="clear"></div>
                                </div>
                                <!---- 产品品级 ---->
                                <?php if(!empty($pctour['tourgrade'])):?>
                                <div class="mt10">
                                    <span class="tag-span tag_blue ptview_theme"><?= $tourGrades[$pctour['tourgrade']] ?></span>
                                </div>
                                <?php endif;?>
                                <!---- 产品特色 ---->
                                <div class="ptHome_brief"><?= $pctour['summary']?></div>
                            </div>
                            <div class="fl" style="width:226px; padding-top:40px;">
                                <div class="mt20">

                                    <div class="ptHome_price"><span class="sign"><?= Yii::$app->params['curCurrencies']['sign']?></span> <span class="num"><?= $pctour['price'][Yii::$app->params['curCurrency']]?></span><span style="color:#333;vertical-align:middle;margin-left:10px;">起/人</span></div>
                                    <div style="width:79px; margin:15px auto;"><a href="<?= $pctour['link']?>" target="_blank" class="comm-btn1">我要定制</a> </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>

                    <?php } ?>
                </div>
                <div class="bottom_pagenum">
                    <div style="margin-left: -241.5px;" class="bg_navs">
                        <?= $pageData?>
                    </div>
                </div>
            </div>
        <?php else:  ?>
            <div class="private_entry_left">
                <div class="product_wrapper">
                    <div class="product_list_wrapper">
                        <div class="no_result mt20">
                            <div class="f22">很抱歉！<span>没有找到相关产品 !</span> 请修改筛选条件。</div>
                            <div class="mt25"><a href="<?= Yii::$app->params['service']['www']?>" class="button_back">返回首页</a></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;?>
        <div class="private_entry_right">
            <div class="sales">
                <p class="sales-p2">全球7x4小时客服电话 </p>
                <p class="sales-p3"><?= Yii::$app->helper->getCustomerServicePhone();?></p>
                <p class="two-code">
                    <img src="<?= Yii::$app->helper->getFileUrl('/images/pour/code.png')?>" alt="">
                </p>
                <p class="sales-p4">扫描二维码，添加微信咨询定制信息</p>
            </div>
            <div class="ll_server">
                <a href="/privatetour/home" target="_blank" class="comm-btn2 comm-btn-lg">
                    点击了解详情
                </a>
            </div>
            <div class="entry">
                <p>没有合适的行程<br>需要设计师定制？</p>
                <a href="<?= Yii::$app->params['service']['www']?>/private/tour_book/type-tour" target="_blank" class="comm-btn2 comm-btn-lg comm-btn-special">个性定制入口</a>
            </div>
            <div class="bus">
                <p>语言无障碍  司机听我走<br>包车服务  也许更适合你！</p>
                <a href="<?= Yii::$app->params['service']['www']?>/private/bus" target="_blank" class="comm-btn2 comm-btn-lg comm-btn-special">了解包车服务</a>
            </div>

        </div>
        <div class="clear"></div>
        <div class="h40"></div>
    </div>
    <style>
        .sales {
            border: 1px solid #cfd9da;
            border-top-color: transparent;
            width: 220px;
            text-align: center;
            padding: 40px 0;
            margin-bottom: 10px;
            background: #fff;
        }
    </style>
    <script type="text/javascript" language="javascript">
        <?php $this->beginBlock('js_view') ?>
        $(function() {
            $("img.lazy").lazyload({effect:'fadeIn'});

            /*判断字数*/
            $(".ptHome_t_d_r .en_tit").each(function() {
                var maxTextnum=60;
                if($(this).text().length>maxTextnum){
                    $(this).text($(this).text().substring(0,maxTextnum));
                    $(this).html($(this).text()+' ...');
                }
            });
            $(".ptHome_brief").each(function() {
                var maxTextnum=70;
                if($(this).text().length>maxTextnum){
                    $(this).text($(this).text().substring(0,maxTextnum));
                    $(this).html($(this).text()+' ...');
                }
            });

        });
        <?php $this->endBlock(); ?>
    </script>
    <?php $this->registerJs($this->blocks['js_view'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>
</div>