<?php
function exe($url) {
	// eg: https://xueqiu.com/u/6654628252
	if (preg_match("/xueqiu\.com\/u\/(\d+)/s", $url, $temp)) {
    	$feeds[] = array('title' => "用户的全部动态", 'link' => "https://rsshub.app/xueqiu/user/".$temp[1]);
    	$feeds[] = array('title' => "用户的原发布", 'link' => "https://rsshub.app/xueqiu/user/".$temp[1].'/0');
    	$feeds[] = array('title' => "用户的长文", 'link' => "https://rsshub.app/xueqiu/user/".$temp[1].'/2');
    	$feeds[] = array('title' => "用户的问答", 'link' => "https://rsshub.app/xueqiu/user/".$temp[1].'/4');
    	$feeds[] = array('title' => "用户的热门", 'link' => "https://rsshub.app/xueqiu/user/".$temp[1].'/9');
    	$feeds[] = array('title' => "用户的交易", 'link' => "https://rsshub.app/xueqiu/user/".$temp[1].'/11');
    	$feeds[] = array('title' => "用户的收藏", 'link' => "https://rsshub.app/xueqiu/favorite/".$temp[1]);
    	$feeds[] = array('title' => "用户的自选", 'link' => "https://rsshub.app/xueqiu/user_stock/".$temp[1]);
    	return $feeds;
	}
}