<?php
/**
 * @name Pager
 * @author ruansheng
 * @desc PagerLib::getPager(100,10,1)
 */
class Pager {

    public static $data_count_str = '总数据';
    public static $page_count_str = '总页数';
    public static $prev_page_str = '上一页';
    public static $next_page_str = '下一页';

    /**
     * @param $data_count int   总数据
     * @param $row_count  int   每页的数据
     * @param $now_page  int    当前页数
     * @return array|string
     */
    public static function getPager($data_count, $row_count, $now_page = 1) {
        if(empty($data_count) || empty($row_count) || empty($now_page)) { //判断参数合法性
            return [];
        }

        if(!is_numeric($data_count) || !is_numeric($row_count) || !is_numeric($now_page)) {
            return [];
        }

        //计算总页数
        $page_count = ceil($data_count / $row_count);

        if($now_page > $page_count) {  //当前页大于总页数
            return [];
        }

        $pagers = '';
        $pagers .= '<div class="pager-box">';
        $pagers .= '<span class="data-count">' . self::$data_count_str . $data_count . '</span>';
        $pagers .= '<span class="page-count">' . self::$page_count_str . $page_count . '</span>';

        if($now_page == 1) {
            $pagers .= '<a class="prev-pager" href="?p=1">' . self::$prev_page_str . '</a>';
        } else {
            $pagers .= '<a class="prev-pager" href="?p=' . ($now_page-1) . '">' . self::$prev_page_str . '</a>';
        }
        $pagers .= '<span class="ipager">';
        for($i=1; $i <= $page_count; $i++) {
            if($page_count <= 9) {
                if($i == $now_page) {
                    $pagers .= '<a class="now-pager" href="?p=' . $i . '">' . $i . '</a>';
                }else {
                    $pagers .= '<a href="?p=' . $i . '">' . $i . '</a>';
                }
            } else {
                if($now_page <= 8) {
                    if($i <= 8) {
                        if ($i == $now_page) {
                            $pagers .= '<a class="now-pager" href="?p=' . $i . '">' . $i . '</a>';
                        } else {
                            $pagers .= '<a href="?p=' . $i . '">' . $i . '</a>';
                        }
                    } else if($i == 9){
                        $pagers .= '<a href="javascript:void(0);">...</a>';
                    } else if($i == $page_count){
                        $pagers .= '<a href="?p=' . $i . '">' . $i . '</a>';
                    }
                } else {
                    if($i == 1) {
                        $pagers .= '<a href="?p=' . $i . '">' . $i . '</a>';
                    } else if($i == $page_count){
                        $pagers .= '<a href="?p=' . $i . '">' . $i . '</a>';
                    } else if($i >= ($now_page - 3) && $i <= ($now_page + 3)) {
                        if ($i == $now_page) {
                            $pagers .= '<a class="now-pager" href="?p=' . $i . '">' . $i . '</a>';
                        } else {
                            $pagers .= '<a href="?p=' . $i . '">' . $i . '</a>';
                        }
                    } else if($i == ($now_page - 4) || $i == ($now_page + 4)) {
                        $pagers .= '<a href="javascript:void(0);">...</a>';
                    }
                }
            }
        }
        $pagers .= '</span>';
        if($now_page == 1) {
            $pagers .= '<a class="next-pager" href="?p=2">' . self::$next_page_str . '</a>';
        } else {
            $pagers .= '<a class="next-pager" href="?p=' . ($now_page+1) . '">' . self::$next_page_str . '</a>';
        }

        $pagers .= '</div>';

        $pobj = [
            'data_count' => $data_count,
            'row_count' => $row_count,
            'page_count' => $page_count,
            'now_page' => $now_page,
            'pagers' => $pagers
        ];

        return $pobj;
    }

    /**
     * 获取页码导航HTML
     * @param $pageNum   int 当前页码
     * @param $pageSize  int 每页数量
     * @param $rowCount  int 记录总数
     * @param $navUrl    string 链接页面URL
     * @return string
     */
    public function getNavHtml($pageNum, $pageSize, $rowCount, $navUrl) {
        $pageCount = $rowCount/$pageSize;
        if($rowCount % $pageSize >0) {
            $pageCount++;
        }
        if($pageNum>$pageCount){
            $pageNum = 1;
        }
        $firstNav = "首页 ";
        $lastNav = "尾页 ";
        $prevNav="";
        $nextNav="";
        if($pageNum>1){
            $navPageNum = $pageNum-1;
            $prevNav = "上一页 ";
        }
        if($pageNum<$pageCount && $pageCount>1){
            $navPageNum = $pageNum+1;
            $nextNav = "下一页 ";
        }
        $amongNav="";//关键循环
        for($i=1;$i<=5;$i++){
            $navPageNum = $pageNum+ $i-3;
            if($navPageNum>0 && $navPageNum<=$pageCount){
                $navCSS = $navPageNum == $pageNum ? ' class="hover"' : "";
                $amongNav.="{$navPageNum} ";
            }
        }
        return $firstNav.$prevNav.$amongNav.$nextNav.$lastNav." ".$pageNum."/".$pageCount." 共有[".$rowCount."]条数据";
    }

}

/*
.pager-box{text-align:center;margin-top:50px;margin-bottom:50px;}
.pager-box .page-count{margin-left:10px;}
.pager-box .prev-pager{margin-left:10px;}
.pager-box .ipager{margin-left:10px;}
.pager-box .ipager a{margin-left:5px;}
.pager-box .ipager .now-pager{color:red;}
.pager-box .next-pager{margin-left:10px;}
*/
