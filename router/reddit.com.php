<?php
function exe($url) {
	// 示例：https://www.reddit.com/r/Anki/top
	if (preg_match("/reddit\.com\/r\/([\w\W]+)(\?|\/|$)/Uis", $url, $temp)) {
		$temp = rtrim($temp[1], "/");
		$temp = rtrim($temp, ".rss");
		$feeds[] = array('title' => "Community Posts", 'link' => "https://www.reddit.com/r/".$temp.".rss");
		return $feeds;
	}
}