<?php
function exe($url){
# 【Youtobe频道】
// 示例：https://www.youtube.com/channel/UCpzx9sMpCwKP_xTwoYZx7lA
	if( preg_match("/youtube\.com\/channel\/([^?]+?)(\?|\/|$)/s", $url, $temp) ){
		$feeds[] = array('title' => "官方", 'link' => "https://www.youtube.com/feeds/videos.xml?channel_id=".$temp[1]);
		$feeds[] = array('title' => "RSSHub(支持播放视频)", 'link' => "https://rsshub.app/youtube/channel/".$temp[1]);
		return $feeds;
	}
}