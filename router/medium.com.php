<?php
function exe($url){
	//eg: https://medium.com/censorship/shadowsocks-all-clients-157d02c15182
	//eg: https://medium.com/@unbiniliumm/%E5%A6%82%E4%BB%8A%E6%88%91%E8%BF%99%E6%A0%B7%E7%A7%91%E5%AD%A6%E4%B8%8A%E7%BD%91-95187ef07ced
	if (preg_match("/medium\.com\/([@\w]+?)(\?|\/|$)/s", $url, $temp)) {
		return array('title' => $temp[1], 'link' => "https://medium.com/feed/".$temp[1]);
	}
}
