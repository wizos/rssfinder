<?php
function exe($url){
	// 示例：https://blog.csdn.net/u011729865/rss/list
    if( preg_match("/blog\.csdn\.net\/([^?]+?)(\?|\/|$)/s", $url, $temp) ){
    	return "https://blog.csdn.net/".$temp[1]."/rss/list";
    }

}