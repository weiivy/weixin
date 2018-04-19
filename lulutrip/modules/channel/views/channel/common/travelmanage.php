<?php use yii\helpers\Html;?>
<?php if($evaluations): ?>
    <div class="travel-manage">
        <div class="wrap clearfix">
            <h2 class="dest-tit"><span>路路行独家</span>行程管家<span>服务</span></h2>
            <div class="fr">
                <div class="service">
                    <h4>省心服务</h4>
                    <ul>
                        <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-NA?service=572" target="_blank"><i class="icon icon01"></i>72小时免费改退</a></li>
                        <li><a href="<?= Yii::$app->params['service']['www']?>/tour/north_america/region-NA?service=841" target="_blank"><i class="icon icon02"></i>巴士前排专座</a></li>
                        <li><a href="<?= Yii::$app->params['service']['www']?>/page/about_service" target="_blank"><i class="icon icon03"></i>实地中文接机</a></li>
                        <li><a href="<?= Yii::$app->params['service']['www']?>/page/about_service" target="_blank"><i class="icon icon04"></i>5分钟定位导游</a></li>
                        <li><a href="<?= Yii::$app->params['service']['www']?>/page/about_service" target="_blank"><i class="icon icon05"></i>加订酒店免费接送</a></li>
                    </ul>
                    <a href="<?= Yii::$app->params['service']['www']?>/page/about_service" target="_blank" class="look">查看路路行 特色服务</a>
                </div>
                <div class="comment">
                    <h4>用户评价</h4>
                    <div id="J-comment" class="list-container">
                        <ul>
                            <?php foreach($evaluations as $evaluation):?>
                                <li>
                                    <img src="<?php if($evaluation['type'] == 'upload'):?><?= Yii::$app->helper->getImgDomain()?>/<?= $evaluation['avatar']?><?php else:?><?= Yii::$app->helper->getFileUrl($evaluation['avatar'])?><?php endif;?>" onerror="this.src='<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/file_img3.jpg'?>';">
                                    <a href="<?= Yii::$app->params['service']['www']?>/adviser/home/id-<?= $evaluation['saler_id']?>" target="_blank"><span><?= Html::decode($evaluation['content'])?></span></a>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
            <a class="play-button" href="javascript:;"></a>
        </div>
    </div>
<?php endif;?>