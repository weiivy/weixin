<div class="filter-sort-top">
  <ul class="filter-sort-ul">
    <li <?php if(!isset($params['orderby'])):?>class="on"<?php endif;?>><a href="<?php if(isset($menus['defaultSortUrl'])):?><?= $menus['defaultSortUrl']?><?php endif;?>">热门</a></li>
    <li <?php if(isset($params['orderby']) && $params['orderby'] == 'satisfaction'):?>class="on"<?php endif;?>><a href="<?php if(isset($menus['orderUrl'])):?><?= $menus['orderUrl']?>orderby=satisfaction&order=desc"<?php endif;?>>满意度</a></li>
    <li <?php if(isset($params['orderby']) && $params['orderby'] == 'price'):?>class="<?php if($params['order'] == 'asc'):?>sort-decline<?php else:?>on<?php endif?>"<?php endif;?>>
      <a href="javascript:;">价格</a>
      <div class="hover">
        <a href="<?php if(isset($menus['orderUrl'])):?><?= $menus['orderUrl']?>orderby=price&order=asc"<?php endif;?>>由低到高排序</a>
        <a href="<?php if(isset($menus['orderUrl'])):?><?= $menus['orderUrl']?>orderby=price&order=desc"<?php endif;?>>由高到低排序</a>
      </div>
    </li>
  </ul>
  <div class="filter-sort-calendar">
      <input id="startDateInput" data-min-date="today" class="calendar-input" name="start_from" value="<?=$params['start_from']?>" placeholder="最早出发日" type="text" style=" border: 1px solid #d7d7d7;"/>
      <span>~</span>
      <input id="endDateInput" data-min-date="today" class="calendar-input" name="start_to" value="<?=$params['start_to']?>" placeholder="最晚出发日" type="text" style=" border: 1px solid #d7d7d7;"/>
      <div class="filter-sort-btn">
          <a class="ok" id="J-filter-data-send" href="javascript:;" data-origin="<?php $tPrms = $params; echo $menus['dealMenusObj']->mergeUrl($tPrms);?>">确定</a>
          <a class="off" href="<?php $tPrms = $params;if(isset($params['start_from'])){unset($params['start_from']);} if(isset($params['start_to'])){unset($params['start_to']);} echo $menus['dealMenusObj']->mergeUrl($tPrms);?>">取消</a>
      </div>
  </div>
</div>
<?php if(!empty($menus['added_service']['facetItems'])):?>
<div class="filter-sort-bottom">
    <?php foreach($menus['added_service']['facetItems'] as $key => $val):?>
        <a href="<?=$val['url']?>" class="sort-a<?php if(isset($params['serviceArr']) && in_array($val['key'], $params['serviceArr'])):?> on<?php endif;?>"><?=$val['displayName']?></a>
    <?php endforeach;?>
</div>
<?php endif;?>