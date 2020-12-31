<?php
function exe($url){
	$feeds[] = array('title' => "热门", 'link' => "https://rsshub.app/jianshu/trending/weekly");
    if( preg_match("/jianshu\.com\/c\/(.+?)(&|\?|\/|$)/s", $url, $temp) ){
    	$feeds[] = array('title' => "专题", 'link' => "https://rsshub.app/jianshu/collection/".$temp[2]);
    }elseif (preg_match("/jianshu\.com\/(u|users)\/(.+?)(&|\?|\/|$)/s", $url, $temp)) {
    	$feeds[] = array('title' => "作者", 'link' => "https://rsshub.app/jianshu/user/".$temp[2]);
    }

    return $feeds;
}
