<?php
function exe($url) {
	// 示例：https://twitter.com/Haneristy
	if (preg_match("/twitter\.com\/([^?]+?)(\?|\/|$)/s", $url, $temp)) {
		$feeds[] = array('title' => "动态", 'link' => "http://www.twitrss.me/twitter_user_to_rss/?user=".$temp[1]);
		$feeds[] = array('title' => "动态", 'link' => "https://rsshub.app/twitter/user/".$temp[1]);
		if(is_admin){
			$feeds[] = array('title' => "动态", 'link' => "http://rss.wizos.me/twitter.php?id=".$temp[1]);
		}
		return $feeds;
	}

}