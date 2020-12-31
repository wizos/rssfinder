<?php
function exe($url) {
	// 【喜玛拉雅】
	// 示例：http: //www.ximalaya.com/renwen/5088879/
	if (preg_match("/ximalaya\.com\/([^?]+?)\/(\d+)(\?|\/|$)/s", $url, $temp)) {
	    $feeds[] = array('title' => "官方 RSS(可能不存在)", 'link' => "https://www.ximalaya.com/album/".$temp[2].".xml");
	    $feeds[] = array('title' => "三方 RSS(RSSHub)", 'link' => "https://rsshub.app/ximalaya/album/".$temp[1]."/".$temp[2]);
	    $feeds[] = array('title' => "三方 RSS(Podcast4us)", 'link' => "http://podcast4us.herokuapp.com/xmly/".$temp[2].'.xml');
		return $feeds;
	}
}