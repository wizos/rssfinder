<?php
function exe($url) {
    // http://www.t66y.com/thread0806.php?fid=7
    if (preg_match("/t66y\.com\/thread0806\.php\?fid=7/is", $url)) {
		$feeds[] = array('title' => "技术讨论区", 'link' => 'https://rsshub.app/t66y/7');
		$feeds[] = array('title' => "技术讨论区(过滤摘录的帖子)", 'link' => 'http://feeds.feedburner.com/cl-jstlq');
		$feeds[] = array('title' => "技术讨论区-周报", 'link' => 'http://feeds.feedburner.com/cl-jstlq-hot');
		return $feeds;
    }
    if (preg_match("/t66y\.com\/thread0806\.php\?fid=16/is", $url)) {
		return array('title' => "达盖尔的旗帜", 'link' => 'https://rsshub.app/t66y/16');
    }
    if (preg_match("/t66y\.com\/thread0806\.php\?fid=8/is", $url)) {
		return array('title' => "新时代的我们", 'link' => 'https://rsshub.app/t66y/8');
    }
    if (preg_match("/t66y\.com\/thread0806\.php\?fid=22/is", $url)) {
		return array('title' => "在线成人区", 'link' => 'https://rsshub.app/t66y/22');
    }
    if (preg_match("/t66y\.com\/thread0806\.php\?fid=21/is", $url)) {
		return array('title' => "HTTP 下载区", 'link' => 'https://rsshub.app/t66y/21');
    }
    if (preg_match("/t66y\.com\/thread0806\.php\?fid=27/is", $url)) {
		return array('title' => "转帖交流区", 'link' => 'https://rsshub.app/t66y/27');
    }
    if (preg_match("/t66y\.com\/thread0806\.php\?fid=26/is", $url)) {
		return array('title' => "中字原创区", 'link' => 'https://rsshub.app/t66y/26');
    }
    if (preg_match("/t66y\.com\/thread0806\.php\?fid=25/is", $url)) {
		return array('title' => "国产原创区", 'link' => 'https://rsshub.app/t66y/25');
    }
    if (preg_match("/t66y\.com\/thread0806\.php\?fid=5/is", $url)) {
		return array('title' => "动漫原创区", 'link' => 'https://rsshub.app/t66y/5');
    }
    if (preg_match("/t66y\.com\/thread0806\.php\?fid=4/is", $url)) {
		return array('title' => "欧美原创区", 'link' => 'https://rsshub.app/t66y/4');
    }
    if (preg_match("/t66y\.com\/thread0806\.php\?fid=15/is", $url)) {
		return array('title' => "亚洲有码原创区", 'link' => 'https://rsshub.app/t66y/15');
    }
    if (preg_match("/t66y\.com\/thread0806\.php\?fid=2/is", $url)) {
		return array('title' => "亚洲无码原创区", 'link' => 'https://rsshub.app/t66y/2');
    }
}
