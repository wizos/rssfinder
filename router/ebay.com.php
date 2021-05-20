<?php
function exe($url) {
	// https://www.ebay.com/sch/i.html?_from=R40&_trksid=p2380057.m570.l1313&_nkw=%E6%97%A0%E4%BA%BA%E6%9C%BA&_sacat=0&_rss=1
	if (preg_match("/www\.ebay\.com\/sch\/i\.html.*?/s", $url) && !stripos($url, "&_rss=")) {
	    $feeds = array();
		$feeds[] =  array('title' => "RSS", 'link' => $url."&_rss=1");
		return $feeds;
	}
}