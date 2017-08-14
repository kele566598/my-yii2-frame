<?php
use \app\common\services\UrlService;

// 最多显示页面数 ,取奇数，偶数有bug
$maxPageCount = 9;

// 循环输出li
function for_pages($start, $end, $current, $url,$search){
    for ($i=$start; $i<=$end; $i++){
        if($i == $current) {
            echo '<li class="paginate_button active"><a href="'.UrlService::buildNullUrl().'">'.$i.'</a></li>';
        } else {
            $target_url = UrlService::buildAdminUrl($url,array_merge(['p'=> $i],$search));
            echo '<li class="paginate_button "><a href="'.$target_url.'">'.$i.'</a></li>';
        }
    }
}

// 输出省略号
function apostrophe(){
    echo '<li class="paginate_button previous disabled"><a href="'. UrlService::buildNullUrl().'">......</a></li>';
}
?>
<div class="row">
    <div class="col-lg-12">
        <span class="pagination_count" style="line-height: 40px;">共<?=$pages['total_count'];?>条记录 | 每页<?=$pages['page_size'];?>条</span>
        <ul class="pagination pagination-sm pull-right" style="margin: 0 0 ;">



            <?php if($pages['p'] == 1 ): // 判断首页禁止 or 正常?>
                <li class="paginate_button previous disabled"><a href="<?= UrlService::buildNullUrl();?>">首页</a></li>
            <?php else:?>
                <li class="paginate_button previous"><a href="<?= UrlService::buildAdminUrl($url,array_merge(['p'=> 1],$search));?>">首页</a></li>
            <?php endif; ?>





<?php
$lhalf = floor($maxPageCount/2);  // 9/2 = 4
$rhalf = ceil($maxPageCount/2);   // 9/2 = 5


if( $pages['total_page'] <=$maxPageCount ) {
    for_pages(1,$pages['total_page'],$pages['p'], $url,$search);
} else {
    if( $pages['p'] < $rhalf ){ //显示1-$maxPageCount页，右侧加省略号
        for_pages(1,$maxPageCount,$pages['p'], $url,$search);
        apostrophe();
    } else if($pages['p'] > $pages['total_page']-$rhalf ){// 显示倒数9页
        apostrophe();
        for_pages($pages['total_page']-$maxPageCount+1,$pages['total_page'],$pages['p'], $url,$search);
    } else {  // 显示当前页的前4后4，左右加省略号
        apostrophe();
        for_pages($pages['p']-$lhalf,$pages['p']-1,$pages['p'], $url,$search);

        for_pages($pages['p'],$pages['p'],$pages['p'], $url,$search);

        for_pages($pages['p']+1,$pages['p']+$lhalf,$pages['p'], $url,$search);
        apostrophe();
    }
}

/*  如果超过9页，若当前页 <5 显示1-9  若 当前页 >=5 && <=max-5 显示前4 后4
if( $pages['total_page'] <=9 ) {
    for_pages(1,$pages['total_page'],$pages['p'], $url);
} else {
    if( $pages['p'] < 5 ){ //显示1-9页，右侧加省略号
        for_pages(1,9,$pages['p'], $url);
        apostrophe();
    } else if($pages['p'] > $pages['total_page']-5 ){// 显示倒数9页
        apostrophe();
        for_pages($pages['total_page']-8,$pages['total_page'],$pages['p'], $url);
    } else {  // 显示当前页的前4后4，左右加省略号
        apostrophe();
        for_pages($pages['p']-4,$pages['p']-1,$pages['p'], $url);

        for_pages($pages['p'],$pages['p'],$pages['p'], $url);

        for_pages($pages['p']+1,$pages['p']+4,$pages['p'], $url);
        apostrophe();
    }
}*/
?>


            <?php if($pages['p'] == $pages['total_page'] ):  // 判断尾页禁止 or 正常?>
                <li class="paginate_button previous disabled"><a href="<?= UrlService::buildNullUrl();?>">尾页</a></li>
            <?php else:?>
                <li class="paginate_button previous"><a href="<?= UrlService::buildAdminUrl($url,array_merge(['p'=> $pages['total_page']],$search));?>">尾页</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>

