<?php
function exe($url) {
	// 示例1：https://publicwife123.tumblr.com
	if (preg_match("/www\.tumblr\.com/s", $url)) {
		return null;
	}
	if (preg_match("/([\w-]*)\.tumblr\.com/s", $url, $temp)) {
	    if(is_admin){
	        return array('title' => "用户的动态", 'link' => "http://rss.wizos.me/tumblr.php?id=".$temp[1]);
	    }else{
	        return null;
	    }
	}
}