<?php
function exe($url) {
	// eg:https://dribbble.com/search?q=google
	if( preg_match("/dribbble\.com\/search\?q=([^?]\w+?)(\?|\/|$)/s", $url, $temp) ){
		return array('title' => "Shots tagged '".$temp[1]."'", 'link' => "https://rsshub.app/dribbble/keyword/".$temp[1]);
	}
	// 示例：https://dribbble.com/Orizon
	if (preg_match("/dribbble\.com\/([^?]\w+?)(\?|\/|$)/s", $url, $temp)) {
		return array('title' => $temp[1]."'s Shots", 'link' => "https://rsshub.app/dribbble/user/".$temp[1]);
	}
}