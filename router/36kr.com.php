<?php
function exe($url){
	//eg: https://36kr.com/newsflashes
	if (preg_match("/36kr\.com\/newsflashes/is", $url)) {
		$feeds[] = array('title' => "快讯 - 36氪", 'link' => "https://rsshub.app/36kr/newsflashes");
		return $feeds;
	}


	// https://www.36kr.com/search/articles/ofo， https://rsshub.app/36kr/search/article/ofo
	if (preg_match("/36kr\.com\/search\/articles\/([^?]+?)(\?|\/|$)/is", $url, $temp)) {
		$feeds[] = array('title' => $temp[1]." - 36氪", 'link' => "https://rsshub.app/36kr/search/article/".$temp[1]);
		return $feeds;
	}
}
