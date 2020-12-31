<?php
# TODO 大部分由 RSSHub 提供 RSS 服务，这里只保留了写常用的。
function exe($url){
	 # 【直播间】
	//eg: https://www.panda.tv/10300
	if (preg_match("/panda\.tv\/(\d+)/is", $url, $temp)) {
		return array('title' => "熊猫直播间", 'link' => "https://rsshub.app/panda/room/".$temp[1]);
	}
}
