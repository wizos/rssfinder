<?php
# 【贴吧】
// 覆盖：https://tieba.baidu.com/f?kw=adsense&fr=ala0&tpl=5
// 覆盖：https://tieba.baidu.com/adsense
// 不包含：https://tieba.baidu.com/p/5827697590
function exe($url){
    if( preg_match("/tieba\.baidu\.com\/(f\?kw=|[^(p\/)])(.+?)(&|\?|\/|$)/s", $url, $temp) ){
	    $feeds[] = array('title' => "普通帖", 'link' => "https://rsshub.app/tieba/forum/".$temp[2]);
		$feeds[] = array('title' => "精品帖", 'link' => "https://rsshub.app/tieba/forum/good/".$temp[2]);
		return $feeds;
    }
    
    if( preg_match("/tieba\.baidu\.com\/p\/(\d+)/s", $url, $temp) ){
	    $feeds[] = array('title' => "帖子动态", 'link' => "https://rsshub.app/tieba/post/".$temp[1]);
		$feeds[] = array('title' => "楼主动态", 'link' => "https://rsshub.app/tieba/post/".$temp[1]."?see_lz=0");
		return $feeds;
    }

}