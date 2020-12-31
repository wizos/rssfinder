<?php
function exe($url){
	// https://maojundabai.lofter.com/
	if (preg_match("/\/\/(.+?)\.lofter\.com/s", $url, $temp)) {
		$feeds = array();
		if(is_admin){
			$feeds[] = array('title' => "Lofter主的RSS", 'link' => "https://rss.wizos.me/lofter.php?id=".$temp[1]); 
		}
		return $feeds;
    }
}
