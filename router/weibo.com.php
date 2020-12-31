<?php
function exe($url) {
	// 示例1：http://weibo.com/u/1452388845
	if (preg_match("/weibo\.(com|cn)\/(u|profile)\/(\d+)/s", $url, $temp)) {
	    $feeds = array();
		$feeds[] =  array('title' => "博主的RSS(方案1-推荐)", 'link' => "https://rsshub.app/weibo/user/".$temp[3]);
		$feeds[] =  array('title' => "博主的RSS(方案2)", 'link' => "https://rssfeed.today/weibo/rss/".$temp[3]);
		return $feeds;
	}
	// 示例2：https://weibo.com/kaifulee
	if (preg_match("/weibo\.(com|cn)\/([^?]+?)(\?|\/|$)/s", $url, $temp)) {
		$options = array(CURLOPT_COOKIE => "SUB=_2AkMsKm8sf8NxqwJRmPAVyW7qbIt-wwHEieKadp73JRMxHRl-yT83qnQ5tRB6B6pBwkRHY75zEeGJzJOxFuRR_nVwKxGp;");
		$res = get_net($url,$options);
		preg_match("/fuid=(\d+)/s", $res, $temp);
	    $feeds = array();
		$feeds[] =  array('title' => "博主的RSS(方案1-推荐)", 'link' => "https://rsshub.app/weibo/user/".$temp[1]);
		$feeds[] =  array('title' => "博主的RSS(方案2)", 'link' => "https://rssfeed.today/weibo/rss/".$temp[1]);
		return $feeds;
	}
}