<?php
# 【优酷】
function exe($url){
    if(!is_admin){
        return "";
    }
	if( preg_match( '/i\.youku\.com\/[iu]\/([^?]+?)(\?|\/|$)/', $url, $temp ) ){
		return "http://rss.wizos.me/youku.php?id=".$temp[1]."&t=videos";
	}
	if( preg_match( '/list\.youku\.com\/show\/id_(.*?)\.html/', $url, $temp ) ){
		return "http://rss.wizos.me/youku.php?id=".$temp[1]."&t=list";
	}
}