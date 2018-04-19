<?php if(!empty($recPlayLists)):?>
    <div class="right-raiders">
        <div class="tit"><h2>旅游攻略 • <?= \yii\helpers\Html::decode($recPlayLists['name'])?></h2></div>
        <div class="list">
            <ul>
                <?php foreach($recPlayLists['content'] as $content):?>
                    <li><a href="<?=$content['url']?>" target="_blank"><?=\yii\helpers\Html::decode($content['name'])?></a></li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
<?php endif;?>
