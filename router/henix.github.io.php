<?php
function exe($url){
	# 示例：https://henix.github.io/feeds/weixin.sogou.wxieshuo/index.xml
	if( preg_match("/henix\.github\.io\/feeds\/([^?\/]+?)(\?|\/|$)/s", $url, $temp) ){
		$feeds[] = array('title' => "RSS", 'link' => "https://henix.github.io/feeds/".$temp[1]."/index.xml");
		return $feeds;
	}
}