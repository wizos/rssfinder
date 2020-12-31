<?php
function exe($url) {
    // $feeds[] = array('title' => "即将上映的电影", 'link' => "https://rsshub.app/douban/movie/later");
    // $feeds[] = array('title' => "北美票房榜", 'link' => "https://rsshub.app/douban/movie/ustop");
    // $feeds[] = array('title' => "浏览发现", 'link' => "https://rsshub.app/douban/explore");
    // $feeds[] = array('title' => "新书速递", 'link' => "https://rsshub.app/douban/book/latest");
    // $feeds[] = array('title' => "新书速递-商务印书馆", 'link' => "https://rsshub.app/douban/commercialpress/latest");
    // $feeds[] = array('title' => "豆瓣书店", 'link' => "https://rsshub.app/douban/bookstore");
    // $feeds[] = array('title' => "新书速递-商务印书馆", 'link' => "https://rsshub.app/douban/commercialpress/latest");
    
    
	// 示例：https://www.douban.com/group/blabla/
	if (preg_match("/douban\.com\/group/([^?]+?)(\?|\/|$)/s", $url, $temp)) {
		$feeds[] = array('title' => "小组", 'link' => "https://rsshub.app/douban/group/".$temp[1]);
		return $feeds;
	}

	// https://www.douban.com/people/48007616/
	if (preg_match("/douban\.com\/people\/([^?]+?)(\?|\/|$)/s", $url, $temp)) {
		$feeds[] = array('title' => "用户的收藏", 'link' => "https://www.douban.com/feed/people/".$temp[1]."/interests");
		$feeds[] = array('title' => "用户的日记", 'link' => "https://www.douban.com/feed/people/".$temp[1]."/notes");
		//$feeds[] = array('title' => "用户的广播", 'link' => "https://www.douban.com/feed/people/".$temp[1]."/status");
		
		if(is_admin){
		    $feeds[] = array('title' => "用户的动态", 'link' => "http://rss.wizos.me/douban.php?n=".$temp[1]);
		}
		return $feeds;
	}
	
	// https://book.douban.com/subject/6723066/
	// https://music.douban.com/subject/5958397/
	// https://movie.douban.com/subject/1292063/
	if (preg_match("/douban\.com\/subject\/(\d+)(\?|\/|$)/s", $url, $temp)) {
		$feeds[] = array('title' => "该项目RSS", 'link' => "https://www.douban.com/feed/subject/".$temp[1]."/reviews");
		return $feeds;
	}
	
	//https://rsshub.app/douban/explore/column/2
	if (preg_match("/douban\.com\/explore\/column/\/(\d+)(\?|\/|$)/s", $url, $temp)) {
		$feeds[] = array('title' => "豆瓣发现", 'link' => "https://rsshub.app/douban/explore/column/".$temp[1]);
		return $feeds;
	}
	
	
}