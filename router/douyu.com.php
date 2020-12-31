<?php
# TODO 大部分由 RSSHub 提供 RSS 服务，这里只保留了写常用的。
function exe($url){
  # 【直播间】
  //eg: https://www.douyu.com/24422
	if (preg_match("/douyu\.com\/(\d+)/is", $url, $temp)) {
		return array('title' => "斗鱼直播间", 'link' => "https://rsshub.app/douyu/room/".$temp[1]);
	}
}
