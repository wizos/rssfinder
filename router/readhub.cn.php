<?php
function exe($url) {
	// 来源：http://readhub.bayes.cafe/
	if (preg_match("/readhub\.cn/s", $url)) {
		$feeds[] = array('title' => "所有频道", 'link' => "http://readhub.bayes.cafe/rss?channel=all");
		$feeds[] = array('title' => "热门话题", 'link' => "http://readhub.bayes.cafe/rss?channel=topics");
		$feeds[] = array('title' => "科技动态", 'link' => "http://readhub.bayes.cafe/rss?channel=news");
		$feeds[] = array('title' => "开发者资讯", 'link' => "http://readhub.bayes.cafe/rss?channel=technews");
		return $feeds;
	}
}