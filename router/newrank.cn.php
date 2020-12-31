<?php
function exe($url) {
	if (preg_match("/newrank\.cn\/public\/info\/detail\.html\?account=([^?]+?)(\?|\/|$)/s", $url, $temp)) {
	    if(is_admin){
	        return "http://rss.wizos.me/weixin.php?id=".strtolower($temp[1]);
	    }else{
	        return "http://rss.wizos.me/anyv.php?id=".strtolower($temp[1]);
	    }
		
	}
}