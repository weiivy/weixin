<?php $subTypeArr = array(0 => (empty($tabId) ? '' : $tabId).'全部', 1 => '跟团+自助游', 2 => '跟团游'); ?>
<div class="list-filter-nav">
    <div class="filter-ul">
        <ul>
            <?php foreach($menus['sub_type']['facetItems'] as $key => $val):?>
                <li<?php if((isset($params['subType']) && $val['key'] == $params['subType']) || ((!isset($params['subType']) && $key == 0))):?> class="current"<?php endif;?>><a href="<?=$val['url']?>"><?= $subTypeArr[$val['displayName']]?> (<?=$val['count']?>)</a></li>
            <?php endforeach;?>
        </ul>
    </div>
    <?php if(isset($menus['others'])):?>
    <div class="filter-a" style="position: relative;">
        <?php foreach($menus['others'] as $other):?>
             <a href="<?=$other['url']?>" target="_blank"><?=$other['name']?></a>
        <?php endforeach;?>
        <?php if($params['region'] == 'USWest' || in_array('USWest', $params['regionArr'])): ?>
        <img src="<?= Yii::$app->params['staticDomain'].'/llt-static/images/common/hot.gif'?>" style="position: absolute; left: 146px; top: -10px;" />
        <?php endif; ?>
    </div>
    <?php endif;?>
</div>
