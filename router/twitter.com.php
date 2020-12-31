<?php
function exe($url) {
	// 示例：https://twitter.com/Haneristy
	if (preg_match("/twitter\.com\/([^?]+?)(\?|\/|$)/s", $url, $temp)) {
		return "http://www.twitrss.me/twitter_user_to_rss/?user=".$temp[1];
	}

}