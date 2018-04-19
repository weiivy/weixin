<?php
/**
 * 分页
 * @author Justin Jia<justin.jia@ipptravel.com>
 * @copyright 2017-08-01
 */

namespace lulutrip\modules\tour\library\lists;

class GetPage
{

    var $pageLink = "page={{page}}";
    var $page = null;
    var $totalPages = null;

    function __construct($page, $limit, $total, $pageLink = "page={{page}}")
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
     * 旅行团列表页 底部分页 < 123...789 >
     * @author Serena Liu<serena.liu@ipptravel.com>
     * @copyright 2017-07-29
     * @return string
     */
    function getPageDots()
    {
        if($this->totalPages == 0)
            return;

        $str       = "";

        $first = '<div id="listPagination" class="pagination llt-theme simple-pagination"><ul>';
        $first .= '<li><a href="' . $this->preLink . '" class="pageLink prev"></a></li>';
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
                        $str_tmp .= '<li class="active"><span class="current">' . $i . '</span></li>';
                    else
                        $str_tmp .= '<li><a href="' . $bookLink . '" class="page-link">' . $i . '</a></li>';
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
                            $str_tmp .= '<li class="active"><span class="current">' . $i . '</span></li>';
                        else
                            $str_tmp .= '<li><a href="' . $bookLink . '" class="page-link">' . $i . '</a></li>';
                    }
                    $bookLink = str_replace("{{page}}", $iend, $this->pageLink);
                    $str_tmp .= '<li class="disabled"><span class="ellipse">...</span></li><li><a href="' . $bookLink . '" class="page-link">' . $iend . '</a></li>';
                }
                //两个省略号的情况
                elseif($istart >= 7 && $istart <= $iend - 4)
                {
                    $str_tmp = "";
                    for($i = 1; $i <= 3; $i ++)
                    {
                        $bookLink = str_replace("{{page}}", $i, $this->pageLink);
                        $str_tmp .= '<li><a href="' . $bookLink . '">' . $i . '</a></li>';
                    }
                    $str_tmp .= '<li class="disabled"><span class="ellipse">...</span></li>';
                    for($i = $istart - 2; $i <= $istart + 2; $i ++)
                    {
                        $bookLink = str_replace("{{page}}", $i, $this->pageLink);
                        if($i == $istart)
                            $str_tmp .= '<li class="active"><span class="current">' . $i . '</span></li>';
                        else
                            $str_tmp .= '<li><a href="' . $bookLink . '">' . $i . '</a></li>';
                    }
                    $bookLink = str_replace("{{page}}", $iend, $this->pageLink);
                    $str_tmp .= '<li class="disabled"><span class="ellipse">...</span></li><li><a href="' . $bookLink . '"  class="page-link">' . $iend . '</a></li>';

                }
                elseif($istart > $iend - 4)
                {//一个省略号的情况
                    $str_tmp = "";
                    for($i = 1; $i <= 3; $i ++)
                    {
                        $bookLink = str_replace("{{page}}", $i, $this->pageLink);
                        $str_tmp .= '<li><a href="' . $bookLink . '">' . $i . '</a></li>';
                    }
                    $str_tmp .= '<li class="disabled"><span class="ellipse">...</span></li>';
                    for($i = $iend - 5; $i <= $iend; $i ++)
                    {
                        $bookLink = str_replace("{{page}}", $i, $this->pageLink);
                        if($i == $istart)
                            $str_tmp .= '<li class="active"><span class="current">' . $i . '</span></li>';
                        else
                            $str_tmp .= '<li><a href="' . $bookLink . '">' . $i . '</a></li>';
                    }
                }
            }
            $str .= $str_tmp;
        }
        else
            $str .= "";
        $str = $first . $str . '<li><a href="' . $this->nextLink . '" class="pageLink next"></a></li></ul>';
        $str .= "</div>";
        $str .= '<div class="page-search"><label>到 <input type="text" id="listPaginationInput" data-url="' . $this->pageLink . '" data-num="' . $this->totalPages . '"> 页</label><button id="listPaginationBtn">确认</button></div>';

        return $str;
    }
}