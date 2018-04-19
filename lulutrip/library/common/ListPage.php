<?php
/**
 * 分页类
 * @copyright (c) 2017, lulutrip.com
 * @author  Ivy Zhang<ivyzhang@lulutrip.com>
 */
namespace lulutrip\library\common;

use yii\base\Component;

class ListPage
{
    public $pageLink = "{{link}}_{{page}}.html";
    public $page = null;
    public $totalPages = null;

    /**
     * 构造函数
     * @author Ivy Zhang<ivyzhang@lulutrip.com>
     * @copyright 2017-02-10
     * @param $page
     * @param $limit
     * @param $total
     * @param string $pageLink
     */
    public function __construct($page, $limit, $total, $pageLink = "{{link}}_{{page}}.html")
    {
        $this->totalPages = 0;
        if($total>0)
        {
            $this->totalPages = intval(ceil($total/$limit));
        }
        if(!empty($pageLink))
        {
            $this->pageLink = $pageLink;
        }
        $this->page = min($this->totalPages, $page);
        $this->totalRecords = $total;
        $prep = max(1,($this->page-1));
        $nextp = min($this->totalPages,($this->page+1));
        $this->firstLink =  str_replace("{{page}}","1",$this->pageLink);
        $this->lastLink = str_replace("{{page}}",$this->totalPages,$this->pageLink);
        $this->preLink = str_replace("{{page}}",$prep,$this->pageLink);
        $this->nextLink = str_replace("{{page}}",$nextp,$this->pageLink);
    }

    /**
     * @param string $href_class
     * @param int $showC
     * @param $type
     * @return string
     */
    public function getPage($href_class = 'hover', $showC = 10,$type)
    {
        if($this->totalPages==0)return;
        $prep = max(1,($this->page-1));
        $nextp = min($this->totalPages,($this->page+1));
        $str ="";
        if($this->page>1)
        {
            if($type == 'tour')
            {
                $str .="<a target='_self' class='pre_page' href='javascript:;' onClick='get_tourQna($prep);'><b></b></a>";
            }
            elseif($type == 'act')
            {
                $str .="<a target='_self' class='pre_page' href='javascript:;' onClick='get_actQna($prep);'><b></b></a>";
            }
            elseif($type == 'packagecomm')
            {
                $str .="<a target='_self' class='pre_page' href='javascript:;' onClick='get_packagecomment($prep);'><b></b></a>";
            }
            elseif($type == 'tourcomm')
            {
                $str .="<a target='_self' class='pre_page' href='javascript:;' onClick='get_tourcomment($prep);'><b></b></a>";
            }
            elseif($type == 'buscomm')
            {
                $str .="<a target='_self' class='pre_page' href='javascript:;' onClick='get_buscomment($prep);'><b></b></a>";
            }

        }
        if($this->totalPages>1)
        {
            $n=$this->totalPages;
            $istart = $this->page-3;
            $istart = max($istart,1);
            $iend = $istart+$showC;
            $iend = min($iend,$n);
            if(($iend-$istart)<$showC)
            {
                $istart = $iend-$showC;
                $istart = max($istart,1);
            }
            for ($i=$istart;$i<=$iend ;$i++ )
            {
                $a = "href='javascript:;' onClick='get_tourQna($i);'";
                if($type == 'tour')
                {
                    $a = "href='javascript:;' onClick='get_tourQna($i);'";
                }
                elseif($type == 'act')
                {
                    $a = "href='javascript:;' onClick='get_actQna($i);'";
                }
                elseif($type == 'packagecomm')
                {
                    $a = "href='javascript:;' onClick='get_packagecomment($i);'";
                }
                elseif($type == 'tourcomm')
                {
                    $a = "href='javascript:;' onClick='get_tourcomment($i);'";
                }
                elseif($type == 'buscomm')
                {
                    $a = "href='javascript:;' onClick='get_buscomment($i);'";
                }
                if($i==$this->page)
                {
                    $a .= "class='".$href_class." pre_page fl'";
                }else{
                    $a .= "class='pre_page fl'";
                }
                $str .="<a $a target='_self'>".$i."</a>";
            }
        }
        else
            $str .="";
        if($this->page<$this->totalPages)
        {
            if($type == 'tour')
            {
                $str .="<a target='_self' class='next_page' href='javascript:;' onClick='get_tourQna($nextp);'><b></b></a>";
            }
            elseif($type == 'act')
            {
                $str .="<a target='_self' class='next_page' href='javascript:;' onClick='get_actQna($nextp);'><b></b></a>";
            }
            elseif($type == 'packagecomm')
            {
                $str .="<a target='_self' class='next_page' href='javascript:;' onClick='get_packagecomment($nextp);'><b></b></a>";
            }
            elseif($type == 'tourcomm')
            {
                $str .="<a target='_self' class='next_page' href='javascript:;' onClick='get_tourcomment($nextp);'><b></b></a>";
            }
            elseif($type == 'buscomm')
            {
                $str .="<a target='_self' class='next_page' href='javascript:;' onClick='get_buscomment($nextp);'><b></b></a>";
            }
        }
        $str .="";
        return $str;
    }

    /**
     * 问答分页
     * @param string $href_class
     * @param int $showC
     * @return string
     */
    public function getPageQna($href_class = 'hover', $showC = 10)
    {
        if($this->totalPages==0)return;
        $prep = max(1,($this->page-1));
        $nextp = min($this->totalPages,($this->page+1));
        $first_page = 1;
        $last_page = $this->totalPages;
        $firstLink = $this->getUrl($first_page);
        $preLink = $this->getUrl($prep);
        $nextLink = $this->getUrl($nextp);
        $lastLink = $this->getUrl($last_page);
        $str ="";
//        if($this->page>1)
//        {
        $str .= "<a target='_self' class='first' href='$firstLink' rel='nofollow'>&lt;&lt;</a>";
        $str .= "<a target='_self' class='prev' href='$preLink' rel='nofollow'>&lt;</a>";

//        }
        if($this->totalPages>1)
        {
            $n=$this->totalPages;
            $istart = $this->page-3;
            $istart = max($istart,1);
            $iend = $istart+$showC;
            $iend = min($iend,$n);
            if(($iend-$istart)<$showC)
            {
                $istart = $iend-$showC;
                $istart = max($istart,1);
            }
            for ($i=$istart;$i<=$iend ;$i++ )
            {
                $bookLink = $this->getUrl($i);
                //$bookLink = str_replace("{{page}}",$i,$this->pageLink);
                $a = "href='$bookLink'";
                if($i==$this->page)
                {
                    $a = "href='javascript:;' class='".$href_class."'";
                }
                $str .="<a $a target='_self'>".$i."</a>";
            }
        }
        else
            $str .="";
//        if($this->page<$this->totalPages)
//        {
        $str .="<a target='_self' class='next ' href='$nextLink' rel='nofollow'>&gt;</a>";
        $str .= "<a target='_self' class='last' href='$lastLink' rel='nofollow'>&gt;&gt;</a>";
//        }
        $str .="";
        return $str;
    }

    /**
     * admin分页
     * @param $url
     * @return string
     */
    public function getAdminPage($url)
    {
        if($this->totalPages==0)return;
        $prep = max(1,($this->page-1));
        $nextp = min($this->totalPages,($this->page+1));
        /*$url="/".$_REQUEST['url'];
        $url = preg_replace(array('/\/page-.*&?/i', '/\/+$/'), '', $url);
        $this->pageLink =str_replace("{{link}}_",$url."/page-",$this->pageLink);
        $this->pageLink =str_replace(".html","",$this->pageLink);*/
        $this->pageLink = $_GET;
        unset($this->pageLink['c'], $this->pageLink['m'], $this->pageLink['url'], $this->pageLink['page']);
        $this->pageLink = $url.'?'.http_build_query($this->pageLink);
        $this->pageLink .= '&page={{page}}';
        $firstLink =  str_replace("{{page}}","1",$this->pageLink);
        $lastLink = str_replace("{{page}}",$this->totalPages,$this->pageLink);
        $preLink = str_replace("{{page}}",$prep,$this->pageLink);
        $nextLink = str_replace("{{page}}",$nextp,$this->pageLink);
        $str ="";
        //第一页
        if($this->totalPages > 1)
        {
            $str .= "<a target='_self' class='NavLink' href='$firstLink'>&lt;&lt;</a>";
        }
        //上一页
        if($this->page>1)
        {
            $str .= "<a target='_self' class='NavLink' href='$preLink'>&lt;</a>";
        }
        if($this->totalPages>1)
        {
            $n=$this->totalPages;
            $istart = $this->page-3;
            $istart = max($istart,1);
            $iend = $istart+10;
            $iend = min($iend,$n);
            if(($iend-$istart)<10)
            {
                $istart = $iend-10;
                $istart = max($istart,1);
            }
            for ($i=$istart;$i<=$iend ;$i++ )
            {
                $bookLink = str_replace("{{page}}",$i,$this->pageLink);
                $a = "href='$bookLink'";
                if($i==$this->page)
                {
                    $a = "href='#' class='NaviCurrent'";
                }
                $str .="<a $a target='_self'>".$i."</a>";
            }
        }
        else
            $str .="";
        //下一页
        if($this->page<$this->totalPages)
        {
            $str .="<a target='_self' class='NavLink' href='$nextLink'>&gt;</a>";
        }
        //最后一页
        if($this->totalPages > 1)
        {
            $str .= "<a target='_self' class='NavLink' href='$lastLink'>&gt;&gt;</a>";
        }
        $str .="";
        return $str;
    }

    /**
     * 获取url地址
     * @param $page
     * @return mixed|string
     */
    public function getUrl($page) {
        //var_dump($_SERVER);die;
        $url = "http://" . $_SERVER['SERVER_NAME'] . (($_SERVER['SERVER_PORT'] == 80) ? "" : ":" . $_SERVER['SERVER_PORT']) . $_SERVER['REQUEST_URI'];
        $url = preg_replace("/\?page=.*&?/i", "", $url);
        $url = preg_replace("/&page=.*&?/i", "", $url);
        $url = (preg_match("/\?/", $url)) ? $url . "&page=" . $page : $url . "?page=" . $page;
        return $url;
    }

    /**
     * 获取分页
     * @param string $href_class
     * @return string
     */
    public function getPage_two($href_class = 'hover')
    {
        if($this->totalPages==0)return;
        $prep = max(1,($this->page-1));
        $nextp = min($this->totalPages,($this->page+1));
        $firstLink =  str_replace("{{page}}","1",$this->pageLink);
        $lastLink = str_replace("{{page}}",$this->totalPages,$this->pageLink);
        $preLink = str_replace("{{page}}",$prep,$this->pageLink);
        $nextLink = str_replace("{{page}}",$nextp,$this->pageLink);

        $str ="";
        if($this->page>1)
        {
            $str .="<a target='_self' class='prev ' href='$preLink' rel='nofollow'>上一页</a>";
        }
        if($this->totalPages>1)
        {
            $istart = max(1, $this->page);
            $iend = $this->totalPages;
            //没有省略号的情况
            if($iend <= 9){
                $str_tmp = "";
                for ($i = 1; $i <= $iend; $i++ )
                {
                    $bookLink = str_replace("{{page}}",$i,$this->pageLink);
                    $a = "href='$bookLink'";
                    if($i==$this->page)
                    {
                        $a = "href='###' class='".$href_class."'";
                    }
                    $str_tmp .="<a $a target='_self' rel='nofollow'>".$i."</a>";
                }
            }
            //有省略号的情况
            else{
                //一个省略号的情况
                if($istart < 7){
                    $str_tmp = "";
                    for($i = 1; $i < $iend; $i++){
                        if($i > 8){break; }
                        $bookLink = str_replace("{{page}}",$i,$this->pageLink);
                        $a = "href='$bookLink'";
                        if($i == $istart){
                            $a = "href='###' class='".$href_class."'";
                        }
                        $str_tmp .="<a $a target='_self' rel='nofollow'>".$i."</a>";
                    }
                    $bookLink = str_replace("{{page}}",$iend,$this->pageLink);
                    $a = "href='$bookLink'";
                    $str_tmp .="<span>...</span><a $a target='_self'rel='nofollow'>".$iend."</a>";
                }
                //两个省略号的情况
                elseif($istart >=7 && $istart <= $iend - 4){
                    $str_tmp = "";
                    for($i = 1; $i <= 3; $i++){
                        $bookLink = str_replace("{{page}}",$i,$this->pageLink);
                        $a = "href='$bookLink'";
                        $str_tmp .="<a $a target='_self' rel='nofollow'>".$i."</a>";
                    }
                    $str_tmp .= "<span>...</span>";
                    for($i = $istart-2; $i <= $istart+2; $i++){
                        $bookLink = str_replace("{{page}}",$i,$this->pageLink);
                        $a = "href='$bookLink'";
                        if($i == $istart){
                            $a = "href='###' class='".$href_class."'";
                        }
                        $str_tmp .="<a $a target='_self' rel='nofollow'>".$i."</a>";
                    }
                    $bookLink = str_replace("{{page}}",$iend,$this->pageLink);
                    $a = "href='$bookLink'";
                    $str_tmp .="<span>...</span><a $a target='_self' rel='nofollow'>".$iend."</a>";
                }
                //一个省略号的情况
                elseif($istart > $iend - 4){
                    $str_tmp = "";
                    for($i = 1; $i <= 3; $i++){
                        $bookLink = str_replace("{{page}}",$i,$this->pageLink);
                        $a = "href='$bookLink'";
                        $str_tmp .="<a $a target='_self'rel='nofollow'>".$i."</a>";
                    }
                    $str_tmp .= "<span>...</span>";
                    for($i = $iend - 5; $i <= $iend; $i++){
                        $bookLink = str_replace("{{page}}",$i,$this->pageLink);
                        $a = "href='$bookLink'";
                        if($i == $istart){
                            $a = "href='###' class='".$href_class."'";
                        }
                        $str_tmp .="<a $a target='_self'rel='nofollow'>".$i."</a>";
                    }
                }
            }

            $str .= $str_tmp;
        }
        else
            $str .="";

        if($this->page<$this->totalPages)
        {
            $str .="<a target='_self' class='next ' href='$nextLink' rel='nofollow'>下一页</a>";
        }
        $str .="";
        return $str;
    }

    /**
     * 列表页分页
     * @return string
     */
    public function getPageList()
    {
        if($this->totalPages==0)return;
        if($this->totalPages > 1){
            $str = "<select name='p' id='p' onchange='gotoPage();'>";
            for($i = 1; $i <= ($this->totalPages); $i++){
                $selected = $i==$this->page ? "selected='selected'" : "";
                $str .="<option value='".$i."' $selected >".$i."</option>";
            }
            $str .= "</select>";
            $str .= '&nbsp;&nbsp;<input type="text" id="goP" name="goP" value="" style="width:20px;" />
					<input type="button" id="subP" name="subP" value="GO" onclick="goPage();" />';
            return $str;
        }
    }

    /**
     * 分页字符串
     * @return string
     */
    public function getPageStr(){
        if($this->totalPages==0)return;
        $prep = max(1,($this->page-1));
        $nextp = min($this->totalPages,($this->page+1));
        $firstLink =  str_replace("{{page}}","1",$this->pageLink);
        $lastLink = str_replace("{{page}}",$this->totalPages,$this->pageLink);
        $preLink = str_replace("{{page}}",$prep,$this->pageLink);
        $nextLink = str_replace("{{page}}",$nextp,$this->pageLink);
        if($this->page -1 < 1 ){
            $str = '<a href="javascript:void(0)" class="pre pre_none" rel="nofollow"></a>';
        }else{
            $str = '<a href="'.$preLink.'" class="pre" rel="nofollow"></a>	';
        }

        $str .= "<span><em>".$this->page."</em>/".$this->totalPages."</span> ";

        if($this->page +1 > $this->totalPages ){
            $str .= '<a href="javascript:void(0)" class="next next_none" rel="nofollow">下一页</a>';
        }else{
            $str .= '<a href="'.$nextLink.'" class="next" rel="nofollow">下一页</a>	';
        }
        return $str;

    }

    /**
     * 旅行团列表页 简单分页方式 上一页 1/20 下一页
     * @author Serena Liu<serena@lulutrip.com>
     * @copyright 2017-02-10
     *
     * @return string 返回数据
     */
    public  function getPageLeftRight()
    {
        if($this->totalPages == 0)
            return;
        $str = '';
        if($this->page > 1)
        {
            $str .= '<a class="pre" href="' . $this->preLink . '" style="cursor:pointer">上一页</a>';
        }
        $str .= '<span class="ml10">' . $this->page . '/' . $this->totalPages . '</span>';
        if($this->page < $this->totalPages)
        {
            $str .= '<a class="next" href="' . $this->nextLink . '">下一页</a>';
        }

        return $str;
    }

    /**
     *旅行团列表页 简单分页方式 上一页 1/20 下一页
     * @author Serena Liu<serena@lulutrip.com>
     * @copyright 2017-02-10
     *
     * @return array 返回数据
     */
    public function getPageLeftRightNew()
    {
        if($this->totalPages == 0)
            return;
        $str = '';
        if($this->page > 1)
        {
            $str .= '<a href="' . $this->preLink . '"><i class="arrow-left"></i></a>';
        }else{
            $str .= '<em><i class="arrow-left"></i></em>';
        }
        $str .= '<span>' . $this->page . '/' . $this->totalPages . '</span>';
        if($this->page < $this->totalPages)
        {
            $str .= '<a href="' . $this->nextLink . '"><i class="arrow-right"></i></a>';
        }else{
            $str .= '<em><i class="arrow-right"></i></em>';
        }

        return $str;
    }

    /**
     *旅行团列表页 底部分页 < 123...789 >
     * @author Serena Liu<serena@lulutrip.com>
     * @copyright 2017-02-10
     *
     * @return array 返回数据
     */
    public function getPageDots()
    {
        if($this->totalPages == 0)
            return;

        $str       = "";

        $first = '<div class="fl"><a class="pre_page" href="' . $this->preLink . '"><b></b></a></div>';
        $first .= '<div class="fl numbers">';
        if($this->totalPages >= 1)
        {
            $istart = max(1, $this->page);
            $iend   = $this->totalPages;
            //没有省略号的情况
            if($iend <= 9)
            {
                $str_tmp = "";
                for($i = 1; $i <= $iend; $i ++)
                {
                    $bookLink = str_replace("{{page}}", $i, $this->pageLink);
                    if($i == $this->page)
                        $str_tmp .= '<a href="javascript:;" class="current">' . $i . '</a>';
                    else
                        $str_tmp .= '<a href="' . $bookLink . '">' . $i . '</a>';
                }
            }
            else
            {
                //有省略号的情况
                //一个省略号的情况
                if($istart < 7)
                {
                    $str_tmp = "";
                    for($i = 1; $i < $iend; $i ++)
                    {
                        if($i > 8)
                        {
                            break;
                        }
                        $bookLink = str_replace("{{page}}", $i, $this->pageLink);
                        if($i == $istart)
                            $str_tmp .= '<a href="javascript:;" class="current">' . $i . '</a>';
                        else
                            $str_tmp .= '<a href="' . $bookLink . '">' . $i . '</a>';
                    }
                    $bookLink = str_replace("{{page}}", $iend, $this->pageLink);
                    $str_tmp .= '<a>...</a><a href="' . $bookLink . '"  target="_self"><i>' . $iend . '</i></a>';
                }
                //两个省略号的情况
                elseif($istart >= 7 && $istart <= $iend - 4)
                {
                    $str_tmp = "";
                    for($i = 1; $i <= 3; $i ++)
                    {
                        $bookLink = str_replace("{{page}}", $i, $this->pageLink);
                        $str_tmp .= '<a href="' . $bookLink . '">' . $i . '</a>';
                    }
                    $str_tmp .= "<a>...</a>";
                    for($i = $istart - 2; $i <= $istart + 2; $i ++)
                    {
                        $bookLink = str_replace("{{page}}", $i, $this->pageLink);
                        if($i == $istart)
                            $str_tmp .= '<a href="javascript:;" class="current">' . $i . '</a>';
                        else
                            $str_tmp .= '<a href="' . $bookLink . '">' . $i . '</a>';
                    }
                    $bookLink = str_replace("{{page}}", $iend, $this->pageLink);
                    $str_tmp .= '<a>...</a><a href="' . $bookLink . '"  target="_self"><i>' . $iend . '</i></a>';

                }
                elseif($istart > $iend - 4)
                {//一个省略号的情况
                    $str_tmp = "";
                    for($i = 1; $i <= 3; $i ++)
                    {
                        $bookLink = str_replace("{{page}}", $i, $this->pageLink);
                        $str_tmp .= '<a href="' . $bookLink . '">' . $i . '</a>';
                    }
                    $str_tmp .= "<a>...</a>";
                    for($i = $iend - 5; $i <= $iend; $i ++)
                    {
                        $bookLink = str_replace("{{page}}", $i, $this->pageLink);
                        if($i == $istart)
                            $str_tmp .= '<a href="javascript:;" class="current">' . $i . '</a>';
                        else
                            $str_tmp .= '<a href="' . $bookLink . '">' . $i . '</a>';
                    }
                }
            }
            $str .= $str_tmp;
        }
        else
            $str .= "";
        $str = $first . $str;
        $str .= "</div>";
        $str .= '<div class="fl"><a href="' . $this->nextLink . '" class="next_page"><b></b></a></div>';
        $str .= '<div class="fl skip_page"><label>到 <input type="text" id="pagenavi_input" style="width:40px;" onkeydown="if(event.keyCode==13){gotoPage(\'' . $this->pageLink . '\', \'' . $this->totalPages . '\')}"/> 页</label><input type="button" onclick="gotoPage(\'' . $this->pageLink . '\', \'' . $this->totalPages . '\')" class="ml10" value="确认"></div>';

        return $str;
    }

}