<div class="filter-opts-ul">
    <?php if($params['region'] == 'NA' && !empty($params['id'])):?>
    <?php elseif(!empty($menus['area']['facetItems'])):?>
    <div class="filter-opts-li">
        <div class="filter-tit"><?php if(in_array($regionRoot, ['NA', 'AU'])):?>游玩区域<?php else:?>游玩国家<?php endif;?></div>
        <div class="filter-list">
            <div class="filter-list-option">
                <?php foreach($menus['area']['facetItems'] as $key => $val):?>
                    <?php if($val['selectable']):?>
                        <a href="<?=$val['url']?>"<?php if(isset($params['regionArr']) && in_array($val['key'], $params['regionArr'])):?> class="on"<?php endif;?> title="<?=$val['displayName']?>"><?=$val['displayName']?></a>
                    <?php else:?>
                        <em><?=$val['displayName']?></em>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
            <div class="filter-list-more">
                <div class="filter-list-section section-1">
                    <?php foreach($menus['area']['facetItems'] as $key => $val):?>
                        <label class="each-1-hot" title="<?=$val['displayName']?>">
                            <?php if($val['selectable']):?>
                                <input type="checkbox" name="section-1" value="<?=$val['key']?>"<?php if(isset($params['regionArr']) && in_array($val['key'], $params['regionArr'])):?> class="section-check" checked<?php endif;?>><span><?=$val['displayName']?></span>
                            <?php else:?>
                                <em><?=$val['displayName']?></em>
                            <?php endif;?>
                        </label>
                    <?php endforeach;?>
                </div>
                <div class="filter-list-btn">
                    <input type="hidden" class="J_sourceUrl" data-key="region" value="<?php $tPrms = $params; $tPrms['region'] = '1'; echo $menus['dealMenusObj']->mergeUrl($tPrms);?>"/>
                    <a class="btn-ok" href="javascript:;">确定</a>
                    <a class="btn-return" href="javascript:;">取消</a>
                </div>
            </div>
        </div>
        <?php if(count($menus['area']['facetItems']) > 6):?>
            <a class="opts-more" href="javascript:;">更多</a>
        <?php endif;?>
    </div>
    <?php endif;?>
    <?php if(!empty($menus['duration']['facetItems'])):?>
    <div class="filter-opts-li">
        <div class="filter-tit">行程天数</div>
        <div class="filter-list">
            <div class="filter-list-option filter-list-day">
                <?php foreach($menus['duration']['facetItems'] as $key => $val):?>
                    <?php if($val['selectable']):?>
                        <a href="<?=$val['url']?>"<?php if(isset($params['daysArr']) && in_array($val['key'], $params['daysArr'])):?> class="on"<?php endif;?>><?=$val['displayName']?></a>
                    <?php else:?>
                        <em><?=$val['displayName']?></em>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    <?php endif;?>
    <?php if(!empty($menus['start_location']['facetItems'])):?>
    <div class="filter-opts-li">
        <div class="filter-tit">从哪出发</div>
        <div class="filter-list">
            <div class="filter-list-option">
                <?php foreach($menus['start_location']['facetItems'] as $key => $val):?>
                    <?php if($val['selectable']):?>
                        <a href="<?=$val['url']?>"<?php if(isset($params['citiesArr']) && in_array($val['key'], $params['citiesArr'])):?> class="on"<?php endif;?> title="<?=$val['displayName']?>"><?=$val['displayName']?></a>
                    <?php else:?>
                        <em><?=$val['displayName']?></em>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
            <div class="filter-list-more">
                <ul class="filter-list-tag">
                    <li data-key="3" data-group="hot" class="on">热门</li>
                    <?php for($i = 65; $i <= 90; $i++):?>
                        <li data-key="3" data-group="<?=chr($i)?>"<?php if(empty($menus['start_location']['capitals'][chr($i)])):?> class="empty"<?php endif;?>><?=chr($i)?></li>
                    <?php endfor;?>
                    <?php if(!empty($menus['start_location']['capitals']['other'])):?>
                        <li data-key="3" data-group="other" class="">其他</li>
                    <?php endif;?>
                </ul>
                <div class="filter-list-section section-3">
                    <?php foreach($menus['start_location']['facetItems'] as $key => $val):?>
                        <label class="each-3-<?=$val['firstLetter']?><?php if($val['hot'] == 1):?> each-3-hot<?php endif;?>" title="<?=$val['displayName']?>">
                            <?php if($val['selectable']):?>
                                <input type="checkbox" name="section-3" value="<?=$val['key']?>"<?php if(isset($params['citiesArr']) && in_array($val['key'], $params['citiesArr'])):?> class="section-check" checked<?php endif;?>><span><?=$val['displayName']?></span>
                            <?php else:?>
                                <em><?=$val['displayName']?></em>
                            <?php endif;?>
                        </label>
                    <?php endforeach;?>
                </div>
                <div class="filter-list-btn">
                    <input type="hidden" class="J_sourceUrl" data-key="c" value="<?php $tPrms = $params; $tPrms['cities'] = '1'; echo $menus['dealMenusObj']->mergeUrl($tPrms);?>"/>
                    <a class="btn-ok" href="javascript:;">确定</a>
                    <a class="btn-return" href="javascript:;">取消</a>
                </div>
            </div>
        </div>
        <?php if(count($menus['start_location']['facetItems']) > 6):?>
            <a class="opts-more" href="javascript:;">更多</a>
        <?php endif;?>
    </div>
    <?php endif;?>

    <?php if((isset($params['keyword']) || in_array($regionRoot, ['AU', 'NA'])) && !empty($menus['middle_location']['facetItems'])):?>
    <div class="filter-opts-li">
        <div class="filter-tit">包含景点</div>
            <div class="filter-list">
                <div class="filter-list-option">
                    <?php foreach($menus['middle_location']['facetItems'] as $key => $val):?>
                        <?php if($val['selectable']):?>
                            <a href="<?=$val['url']?>"<?php if(isset($params['scenesArr']) && in_array($val['key'], $params['scenesArr'])):?> class="on"<?php endif;?> title="<?=$val['displayName']?>"><?=$val['displayName']?></a>
                        <?php else:?>
                            <em><?=$val['displayName']?></em>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
                <div class="filter-list-more">
                    <ul class="filter-list-tag">
                        <li data-key="4" data-group="hot" class="on">热门</li>
                        <?php for($i = 65; $i <= 90; $i++):?>
                            <li data-key="4" data-group="<?=chr($i)?>"<?php if(empty($menus['middle_location']['capitals'][chr($i)])):?> class="empty"<?php endif;?>><?=chr($i)?></li>
                        <?php endfor;?>
                        <?php if(!empty($menus['middle_location']['capitals']['other'])):?>
                            <li data-key="4" data-group="other" class="">其他</li>
                        <?php endif;?>
                    </ul>
                <div class="filter-list-section section-4">
                    <?php foreach($menus['middle_location']['facetItems'] as $key => $val):?>
                        <label class="each-4-<?=$val['firstLetter']?><?php if($val['hot'] == 1):?> each-4-hot<?php endif;?>" title="<?=$val['displayName']?>">
                            <?php if($val['selectable']):?>
                                <input type="checkbox" value="<?=$val['key']?>"<?php if(isset($params['scenesArr']) && in_array($val['key'], $params['scenesArr'])):?> class="section-check" checked<?php endif;?>><span><?=$val['displayName']?></span>
                            <?php else:?>
                                <em><?=$val['displayName']?></em>
                            <?php endif;?>
                        </label>
                    <?php endforeach;?>
                </div>
                <div class="filter-list-btn">
                    <input type="hidden" class="J_sourceUrl"  data-key="s" value="<?php $tPrms = $params; $tPrms['scenes'] = '1'; echo $menus['dealMenusObj']->mergeUrl($tPrms);?>"/>
                    <a class="btn-ok" href="javascript:;">确定</a>
                    <a class="btn-return" href="javascript:;">取消</a>
                </div>
            </div>
        </div>
        <?php if(count($menus['middle_location']['facetItems']) > 6):?>
            <a class="opts-more" href="javascript:;">更多</a>
        <?php endif;?>
    </div>
    <?php endif;?>

    <?php if((isset($params['keyword']) || in_array($regionRoot, ['NA'])) && !empty($menus['exclude_scenic']['facetItems'])):?>
        <div class="filter-opts-li filter-opts-hide <?php if(isset($params['noscenesArr'])):?> opts-show<?php endif;?>">
            <div class="filter-tit">不玩哪些</div>
            <div class="filter-list">
                <div class="filter-list-option">
                    <?php foreach($menus['exclude_scenic']['facetItems'] as $key => $val):?>
                        <?php if($val['selectable']):?>
                            <a href="<?=$val['url']?>"<?php if(isset($params['noscenesArr']) && in_array($val['key'], $params['noscenesArr'])):?> class="on"<?php endif;?> title="<?=$val['displayName']?>"><?=$val['displayName']?></a>
                        <?php else:?>
                            <em><?=$val['displayName']?></em>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
                <div class="filter-list-more">
                    <ul class="filter-list-tag">
                        <li data-key="5" data-group="hot" class="on">热门</li>
                        <?php for($i = 65; $i <= 90; $i++):?>
                            <li data-key="5" data-group="<?=chr($i)?>"<?php if(empty($menus['exclude_scenic']['capitals'][chr($i)])):?> class="empty"<?php endif;?>><?=chr($i)?></li>
                        <?php endfor;?>
                        <?php if(!empty($menus['exclude_scenic']['capitals']['other'])):?>
                            <li data-key="5" data-group="other" class="">其他</li>
                        <?php endif;?>
                    </ul>
                    <div class="filter-list-section section-5">
                        <?php foreach($menus['exclude_scenic']['facetItems'] as $key => $val):?>
                            <label class="each-5-<?=$val['firstLetter']?><?php if($val['hot'] == 1):?> each-5-hot<?php endif;?>" title="<?=$val['displayName']?>">
                                <?php if($val['selectable']):?>
                                    <input type="checkbox" value="<?=$val['key']?>"<?php if(isset($params['noscenesArr']) && in_array($val['key'], $params['noscenesArr'])):?> class="section-check" checked<?php endif;?>><span><?=$val['displayName']?></span>
                                <?php else:?>
                                    <em><?=$val['displayName']?></em>
                                <?php endif;?>
                            </label>
                        <?php endforeach;?>
                    </div>
                    <div class="filter-list-btn">
                        <input type="hidden" class="J_sourceUrl"  data-key="ns" value="<?php $tPrms = $params; $tPrms['noscenes'] = '1'; echo $menus['dealMenusObj']->mergeUrl($tPrms);?>"/>
                        <a class="btn-ok" href="javascript:;">确定</a>
                        <a class="btn-return" href="javascript:;">取消</a>
                    </div>
                </div>
            </div>
            <?php if(count($menus['exclude_scenic']['facetItems']) > 6):?>
                <a class="opts-more" href="javascript:;">更多</a>
            <?php endif;?>
        </div>
    <?php endif;?>

    <?php if(!empty($menus['end_location']['facetItems'])):?>
        <div class="filter-opts-li <?php if($regionRoot != 'EU'): ?>filter-opts-hide<?php endif;?> <?php if(isset($params['endpointArr'])):?> opts-show<?php endif;?>" >
            <div class="filter-tit">结束城市</div>
            <div class="filter-list">
                <div class="filter-list-option">
                    <?php foreach($menus['end_location']['facetItems'] as $key => $val):?>
                        <?php if($val['selectable']):?>
                            <a href="<?=$val['url']?>"<?php if(isset($params['endpointArr']) && in_array($val['key'],$params['endpointArr'])):?> class="on"<?php endif;?> title="<?=$val['displayName']?>"><?=$val['displayName']?></a>
                        <?php else:?>
                            <em><?=$val['displayName']?></em>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
                <div class="filter-list-more">
                    <div class="filter-list-section section-6">
                        <?php foreach($menus['end_location']['facetItems'] as $key => $val):?>
                            <label class="each-6-hot" title="<?=$val['displayName']?>">
                                <?php if($val['selectable']):?>
                                    <input type="checkbox" name="section-1" value="<?=$val['key']?>"<?php if(isset($params['endpointArr']) && in_array($val['key'],$params['endpointArr'])):?> class="section-check" checked<?php endif;?>><span><?=$val['displayName']?></span>
                                <?php else:?>
                                    <em><?=$val['displayName']?></em>
                                <?php endif;?>
                            </label>
                        <?php endforeach;?>
                    </div>
                    <div class="filter-list-btn">
                        <input type="hidden" class="J_sourceUrl" data-key="endpoint" value="<?php $tPrms = $params; $tPrms['endpoint'] = '1'; echo $menus['dealMenusObj']->mergeUrl($tPrms);?>"/>
                        <a class="btn-ok" href="javascript:;">确定</a>
                        <a class="btn-return" href="javascript:;">取消</a>
                    </div>
                </div>
            </div>
            <?php if(count($menus['end_location']['facetItems']) > 6):?>
                <a class="opts-more" href="javascript:;">更多</a>
            <?php endif;?>
        </div>
    <?php endif;?>

    <?php if(!empty($menus['promotion_tag']['facetItems'])):?>
        <div class="filter-opts-li filter-opts-hide <?php if(isset($params['saleactArr'])):?> opts-show<?php endif;?>">
            <div class="filter-tit">优惠促销</div>
            <div class="filter-list">
                <div class="filter-list-option">
                    <?php foreach($menus['promotion_tag']['facetItems'] as $key => $val):?>
                        <?php if($val['selectable']):?>
                            <a href="<?=$val['url']?>"<?php if(isset($params['saleactArr']) && in_array($val['key'], $params['saleactArr'])):?> class="on"<?php endif;?> title="<?php if(!empty($val['title'])) echo $val['title']; else echo $val['displayName']; ?>"><?=$val['displayName']?></a>
                        <?php else:?>
                            <em><?=$val['displayName']?></em>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    <?php endif;?>

    <?php if((isset($params['keyword']) || $regionRoot == 'AU') && !empty($menus['line_tag']['facetItems'])):?>
        <div class="filter-opts-li filter-opts-hide<?php if(isset($params['areaplayArr'])):?> opts-show<?php endif;?>">
            <div class="filter-tit">行程特色</div>
            <div class="filter-list">
                <div class="filter-list-option">
                    <?php foreach($menus['line_tag']['facetItems'] as $key => $val):?>
                        <?php if($val['selectable']):?>
                            <a href="<?=$val['url']?>"<?php if(isset($params['areaplayArr']) && in_array($val['key'], $params['areaplayArr'])):?> class="on"<?php endif;?> title="<?=$val['displayName']?>"><?=$val['displayName']?></a>
                        <?php else:?>
                            <em><?=$val['displayName']?></em>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
                <div class="filter-list-more">
                    <div class="filter-list-section">
                        <?php foreach($menus['line_tag']['facetItems'] as $key => $val):?>
                            <label class="each-1-hot"  title="<?=$val['displayName']?>">
                                <?php if($val['selectable']):?>
                                    <input type="checkbox" value="<?=$val['key']?>"<?php if(isset($params['areaplayArr']) && in_array($val['key'], $params['areaplayArr'])):?> class="section-check" checked<?php endif;?>><span><?=$val['displayName']?></span>
                                <?php else:?>
                                    <em><?=$val['displayName']?></em>
                                <?php endif;?>
                            </label>
                        <?php endforeach;?>
                    </div>
                    <div class="filter-list-btn">
                        <input type="hidden" class="J_sourceUrl" data-key="areaplay" value="<?php $tPrms = $params; $tPrms['areaplay'] = '1'; echo $menus['dealMenusObj']->mergeUrl($tPrms);?>"/>
                        <a class="btn-ok" href="javascript:;">确定</a>
                        <a class="btn-return" href="javascript:;">取消</a>
                    </div>
                </div>
            </div>
            <?php if(count($menus['line_tag']['facetItems']) > 6):?>
                <a class="opts-more" href="javascript:;">更多</a>
            <?php endif;?>
        </div>
    <?php endif;?>

    <?php if(isset($menus['clearAll'])):?>
    <div class="filter-opts-clear">
        <a href="<?=$menus['clearAll']?>">清除选项</a>
    </div>
    <?php endif;?>
</div>
<div class="filter-opts-btn">
    <a href="javascript:;" class="J-optsBtn" data-region="<?=isset($params['keyword']) ? 'keyword': $regionRoot?>"><?php if(!isset($params['keyword'])): if($regionRoot == 'NA'):?>展开（不玩哪些、结束城市、优惠促销）<?php elseif($regionRoot == 'EU'):?>展开（优惠促销）<?php elseif(Yii::$app->controller->regionRoot == 'AU'):?>展开（结束城市、优惠促销、行程特色）<?php endif;?><?php else:?>展开（不玩哪些、结束城市、优惠促销、行程特色）<?php endif;?></a>
</div>