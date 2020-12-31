<?php
function exe($url){
	//eg: https://book.qidian.com/info/1010400217
	if (preg_match("/book\.qidian\.com\/info\/(\d+)/is", $url, $temp)) {
		$feeds[] = array('title' => "本书章节更新", 'link' => "https://rsshub.app/qidian/chapter/".$temp[1]);
		$feeds[] = array('title' => "本书讨论区", 'link' => "https://rsshub.app/qidian/forum/".$temp[1]);
		return $feeds;
	}
}
