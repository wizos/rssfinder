<?php
function exe($url) {
	//eg: https://danjuanapp.com/funding/001073?channel=1300100141
	if (preg_match("/danjuanapp\.com\/funding\/(\d+)/s", $url, $temp)) {
    	return array('title' => "基金净值更新", 'link' => "https://rsshub.app/xueqiu/fund/".$temp[1]);
	}
}