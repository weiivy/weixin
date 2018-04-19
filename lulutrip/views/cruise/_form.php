<div class="cruise_form">
    <div class="tit">实时邮轮查询</div>
    <div class="mt10 showseat" id="Jseat_ctiy">
        <input type="text" placeholder="任何目的地" readonly="" value="<?php if(isset($selected) && $selected['dst']) {echo $selected['dst'];}?>">
        <ul class="isOut_d" id="cruise_ul_dst" onmouseover="isOut=false" onmouseout="isOut=true">
            <li><a onclick="_record('dst', 0)">任何目的地</a></li>
            <?php foreach ($newFilter['dst'] as $key => $value) : ?>
                <?php if(isset($value['isGrey']) && $value['isGrey'] == 1):?>
                    <li><span class="disable"><?=$value['name']; ?></span></li>
                <?php else:?>
                    <li><a onclick="_record('dst','<?= $key?>')"><?=$value['name']; ?></a></li>
                <?php endif;?>
                <?php if (@$value['subs']) : ?>
                    <?php foreach ($value['subs'] as $id => $item) : ?>
                        <?php if(isset($item['isGrey']) && $item['isGrey'] == 1):?>
                            <li><span class="disable">- <?=$item['name'];?></span></li>
                        <?php  else :?>
                            <li><a onclick="_record('dst','<?= $id?>')">- <?=$item['name'];?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="mt10 clearfix">
        <div class="fl d120">
            <div class="showseat input_date" id="Jseat_start_date">
                <input type="text" placeholder="任何时间" id="dep_date_v" readonly="" value="<?php if(isset($selected) && $selected['dep']) {echo $selected['dep'];}?>">
                <ul class="isOut_d" id="cruise_ul_dep" onmouseover="isOut=false" onmouseout="isOut=true">
                    <?php foreach ($newFilter['dep'] as $key => $value) :?>
                    <li data-time="<?= $key ?>" class="dep_mon<?= substr($key, 0, 7)?>">
                    <?php if (isset($value['isGrey']) && $value['isGrey'] == 1) :?>
                    <span class="disable"><?= $value['name']?></span>
                    <?php  else :?>
                    <a onclick="_record('dep','<?= $key?>','<?= $value['name']?>')"><?= $value['name']?></a>
                    <?php endif;?>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <div class="fl txt">到</div>
        <div class="fr d120">
            <div class="showseat input_date" id="Jseat_to_date">
                <input type="text" placeholder="任何时间" id="tod_date_v" readonly="" value="<?php if(isset($selected) && $selected['tod']) {echo $selected['tod'];}?>">
                <ul class="isOut_d" id="cruise_ul_tod" onmouseover="isOut=false" onmouseout="isOut=true">
                    <?php foreach ($newFilter['tod'] as $key => $value) :?>
                        <li data-time="<?= $key ?>" class="tod_mon<?= substr($key, 0, 7)?>">
                        <?php if (isset($value['isGrey']) && $value['isGrey'] == 1) :?>
                        <span class="disable"><?= $value['name']?></span>
                        <?php  else :?>
                        <a onclick="_record('tod','<?= $key?>','<?= $value['name']?>')"><?= $value['name']?></a>
                        <?php endif;?>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>
    <div class="mt10 showseat" id="Jseat_day">
        <input type="text" placeholder="任何航行时长" readonly="" value="<?php if(isset($selected) && $selected['len']) {echo $selected['len'];}?>">
        <ul class="isOut_d" id="cruise_ul_len" onmouseover="isOut=false" onmouseout="isOut=true">
            <li><a onclick="_record('len', '')">任何航行时长</a></li>
            <?php foreach ($newFilter['len'] as $key => $value) :?>
                <li>
                <?php if (isset($value['isGrey']) && $value['isGrey'] == 1) :?>
                <span class="disable"><?= $value['name']?></span>
                <?php  else :?>
                <a onclick="_record('len','<?= $key?>')"><?= $value['name']?></a>
                <?php endif;?>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
    <div class="mt10 showseat" id="Jseat_company">
        <input type="text" placeholder="任何邮轮公司" readonly="" value="<?php if(isset($selected) && $selected['crl']) {echo $selected['crl'];}?>">
        <ul class="isOut_d" id="cruise_ul_crl" onmouseover="isOut=false" onmouseout="isOut=true">
            <li><a onclick="_record('crl', 0)">任何邮轮公司</a></li>
            <!-- 将邮轮公司不可选选项置后 -->
            <?php $disablePrt = ''; ?>
            <?php foreach ($newFilter['crl'] as $key => $value) : ?>
                <?php if(isset($value['isGrey']) && $value['isGrey'] == 1):?>
                    <?php $disablePrt .= '<li><span class="disable">' . $value['name'] . '</span></li>'; ?>
                <?php else:?>
                    <li><a onclick="_record('crl','<?=$value['tc_line_id']?>')"><?php echo $value['name']; ?>--<?php echo $value['name_en']; ?></a></li>
                <?php endif;?>
            <?php endforeach; ?>
            <?=$disablePrt?>
        </ul>
    </div>
    <div class="mt10 showseat" id="Jseat_port">
        <input type="text" placeholder="从任何港口出发" readonly="" value="<?php if(isset($selected) && $selected['prt']) {echo $selected['prt'];}?>">
        <ul class="isOut_d" id="cruise_ul_prt" onmouseover="isOut=false" onmouseout="isOut=true">
            <li><a onclick="_record('prt', 0)">从任何港口出发</a></li>
            <!-- 将港口不可选选项置后 -->
            <?php $disablePrt = ''; ?>
            <?php foreach ($newFilter['prt'] as $key => $value) : ?>
                <?php if(isset($value['isGrey']) && $value['isGrey'] == 1):?>
                    <?php $disablePrt .= '<li><span class="disable">' . $value['name'] . '</span></li>'; ?>
                <?php else: ?>
                    <li><a onclick="_record('prt','<?=$value['tc_port_id']?>')"><?php echo $value['name']; ?></a></li>
                <?php endif;?>
            <?php endforeach; ?>
            <?=$disablePrt?>
        </ul>
    </div>
    <div class="mt10">
        <p class="form_msg">约有<span id="num_msg"><?=$num ?></span>个结果</p>
    </div>
    <div class="mt20 form_btn">
        <a href="javascript:;" onclick="_subSearch()">立即搜索</a>
    </div>
    <div class="form_tel">全球7X24小时客服电话  <?= \Yii::$app->helper->getCustomerServicePhone(); ?></div>
</div>
<form action="/cruise/search" method="get" name="search">
    <input type="hidden" name="dst" value="<?php if (isset($param['dst'])) {echo $param['dst'];} ?>" />
    <input type="hidden" name="dep" id="dep_date" value="<?php if (isset($param['dep'])) {echo $param['dep'];} ?>" />
    <input type="hidden" name="tod" id="tod_date" value="<?php if (isset($param['tod'])) {echo $param['tod'];} ?>" />
    <input type="hidden" name="len" value="<?php if (isset($param['len'])) {echo $param['len'];} ?>" />
    <input type="hidden" name="crl" value="<?php if (isset($param['crl'])) {echo $param['crl'];} ?>" />
    <input type="hidden" name="prt" value="<?php if (isset($param['prt'])) {echo $param['prt'];} ?>" />
</form>
<script language="JavaScript">
    function _record(name, val, txt) {
        var dep = document.forms.search.dep,
            tod = document.forms.search.tod;
        if (name == 'dep') {
            if (val > tod.value) {
                $("#tod_date_v").val(txt);
                    $("#tod_date").val($(".tod_mon"+val.substr(0,7)).data("time"));
            }
        }
        if (name == 'tod') {
            if (val < dep.value) {
                $("#dep_date_v").val(txt);
                $("#dep_date").val($(".dep_mon"+val.substr(0,7)).data("time"));
            }
        }
        document.forms.search[name].value = val;
        ajaxserch();
    }
    function ajaxserch() {
        var obj = document.forms.search;
        var dst = obj.dst.value ? obj.dst.value : 0,
            crl = obj.crl.value ? obj.crl.value : 0,
            prt = obj.prt.value ? obj.prt.value : 0,
            dep = obj.dep.value ? obj.dep.value : '',
            tod = obj.tod.value ? obj.tod.value : '',
            len = obj.len.value ? obj.len.value : '';
        var query = '';
        if (dep) {
            query += '&dep=' + dep;
        }
        if (tod) {
            query += '&tod=' + tod;
        }

        if (len) {
            query += '&len=' + len;
        }
        if (query) {
            query = '?' + query.substr(1);
        }
        $.ajax({
            url: '<?=Yii::$app->config->www?>/cruise/get_search_total?dst='+dst+'&crl='+crl+'&prt='+prt+'&len='+len+'&dep='+dep+'&tod='+tod,
            type: 'get',
            dataType: 'json',
            success: function(data) {
                var obj = eval(data.data.newFilter);
                var htl_dst = "";
                var htl_crl = "";
                var htl_crl_dis = "";
                var htl_prt = "";
                var htl_prt_dis = "";
                var htl_dep = "";
                var htl_tod = "";
                var htl_len = "";
                var htl_len_end = "";
                $.each(obj,function(name,list){
                    $.each(list,function(i,cont){
                        var htl_dst_sub = "";
                        if (name == 'dst') {
                            if (cont.subs && cont.subs !='') {
                                $.each(cont.subs,function(j,sub){
                                    htl_dst_sub +='<li><a onclick="_record(\''+name+'\',\''+j+'\')">- '+sub.name+'</a></li>';
                                });
                            }
                            htl_dst +='<li><a onclick="_record(\''+name+'\',\''+i+'\')">'+cont.name+'</a></li>'+htl_dst_sub;
                        }
                        if (name == 'crl') {
                            if (!cont.isGrey) {
                                htl_crl += '<li><a onclick="_record(\'' + name + '\',\'' + cont.tc_line_id + '\')">' + cont.name + '--' + cont.name_en + '</a></li>';
                            } else {
                                htl_crl_dis += '<li><span class="disable">' + cont.name + '--' + cont.name_en + '</span></li>';
                            }
                        }
                        if (name == 'prt') {
                            if (!cont.isGrey) {
                                htl_prt += '<li><a onclick="_record(\'' + name + '\',\'' + cont.tc_port_id + '\')">' + cont.name + '</a></li>';
                            } else {
                                htl_prt_dis += '<li><span class="disable">' + cont.name + '</span></li>';
                            }
                        }
                        if (name == 'dep') {
                            if (!cont.isGrey) {
                                htl_dep += '<li data-time="' + i + '" class="dep_mon' + i.substr(0, 7) + '"><a onclick="_record(\'' + name + '\',\'' + i + '\',\'' + cont.name + '\')">' + cont.name + '</a></li>';
                            } else {
                                htl_dep += '<li><span class="disable">' + cont.name + '</span></li>';
                            }
                        }
                        if (name == 'tod') {
                            if (!cont.isGrey) {
                                htl_tod += '<li data-time="' + i + '" class="tod_mon' + i.substr(0, 7) + '"><a onclick="_record(\'' + name + '\',\'' + i + '\',\'' + cont.name + '\')">' + cont.name + '</a></li>';
                            } else {
                                htl_tod += '<li><span class="disable">' + cont.name + '</span></li>';
                            }
                        }
                        if (name == 'len') {
                            if (!cont.isGrey) {
                                if ( i !=15){
                                    htl_len += '<li><a onclick="_record(\'' + name + '\',\'' + i + '\')">' + cont.name + '</a></li>';
                                } else {
                                    htl_len_end += '<li><a onclick="_record(\'' + name + '\',\'' + i + '\')">' + cont.name + '</a></li>';
                                }
                            } else {
                                if ( i !=15) {
                                    htl_len += '<li><span class="disable">' + cont.name + '</span></li>';
                                } else {
                                    htl_len_end += '<li><span class="disable">' + cont.name + '</span></li>';
                                }
                            }
                        }
                    });
                });
                $('#cruise_ul_dst').html('<li><a onclick="_record(\'dst\', 0)">任何目的地</a></li>'+htl_dst);
                $('#cruise_ul_crl').html('<li><a onclick="_record(\'crl\', 0)">任何邮轮公司</a></li>'+htl_crl+htl_crl_dis);
                $('#cruise_ul_prt').html('<li><a onclick="_record(\'prt\', 0)">从任何港口出发</a></li>'+htl_prt+htl_prt_dis);
                $('#cruise_ul_dep').html(htl_dep);
                $('#cruise_ul_tod').html(htl_tod);
                $('#cruise_ul_len').html('<li><a onclick="_record(\'len\', \'\')">任何航行时长</a></li>'+htl_len+htl_len_end);
                $('.form_msg').show();
                $('#num_msg').text(data.data.num);
            },
        });
    }
    function _subSearch() {
        var obj = document.forms.search;
        var dst = obj.dst.value ? obj.dst.value : 0,
            crl = obj.crl.value ? obj.crl.value : 0,
            prt = obj.prt.value ? obj.prt.value : 0,
            dep = obj.dep.value ? obj.dep.value : '',
            tod = obj.tod.value ? obj.tod.value : '',
            len = obj.len.value ? obj.len.value : '';
        var query = '';
        if (dep) {
            query += '&dep=' + dep;
        }
        if (tod) {
            query += '&tod=' + tod;
        }

        if (len) {
            query += '&len=' + len;
        }
        if (query) {
            query = '?' + query.substr(1);
        }
        location.href = '/cruise/search/'+dst+'/'+crl+'/'+prt+query;
    }
</script>



