<?php
function exe($url){
	//eg: http://search.smzdm.com/?c=home&s=%E5%A5%B3%E8%A3%85&order=time&v=b
	if (preg_match("/search\.smzdm\.com\/\?.*?[\?&]s=([^?]+?)(\?|\/|&|$)/is", $url, $temp)) {
		return array('title' => "关键词：".urldecode($temp[1]), 'link' => "https://rsshub.app/smzdm/keyword/".$temp[1]);
	}
}
