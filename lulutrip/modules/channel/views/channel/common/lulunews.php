<?php if(!empty($messages)):?>
<div class="lulunews">
    <div class="wrap clearfix">
        <div class="lulunews-li">
            <div class="tit clearfix">
                <h3>路路资讯</h3>
                <a href="<?= Yii::$app->params['service']['article']?><?php if($messages['articles']['id']): ?>/home/category-<?= $messages['articles']['id'] ?> <?php endif; ?>" target="_blank">查看更多</a>
            </div>
            <ul>
                <?php foreach($messages['articles']['data'] as $key => $article):?>
                <li>
                    <a href="<?= Yii::$app->params['service']['article']?>/view/id-<?= $article['article_id'] ?>" target="_blank"><?= $article['article_title'] ?></a>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="lulunews-li">
            <div class="tit clearfix">
                <h3>路路问答</h3>
                <a href="<?= Yii::$app->params['service']['www']?>/qna/entry<?php if($messages['qnas']['id']): ?>/category-<?= $messages['qnas']['id'] ?><?php endif; ?>" target="_blank">查看更多</a>
            </div>
            <ul>
                <?php foreach($messages['qnas']['data'] as $key => $qna):?>
                <li>
                    <a href="<?= Yii::$app->params['service']['www']?>/qna/view/id-<?= $qna['id'] ?>" target="_blank"><?= $qna['content'] ?></a>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="lulunews-li lulunews-partner">
            <div class="tit clearfix">
                <h3>路路结伴</h3>
                <a href="<?= Yii::$app->params['service']['forum']?>/topic/entry/type-5" target="_blank">查看更多</a>
            </div>
            <ul>
                <?php foreach($messages['topics'] as $key => $topic):?>
                <li>
                    <a href="<?= Yii::$app->params['service']['forum']?>/topic/view/id-<?= $topic['id'] ?>" target="_blank"><?= $topic['subject'] ?></a>
                    <span><?= date('y-m-d', $topic['created_at'] )?></span>
                    <div class="cont"><?= \yii\helpers\Html::decode($topic['content']); ?></div>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>
<?php endif;?>