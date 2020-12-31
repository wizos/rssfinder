<?php
//https://music.163.com/#/playlist?id=35798529
function exe($url){
	if( preg_match("/music\.163\.com\/#\/playlist\?id=(\d+)/s", $url, $temp) ){
		return "https://rsshub.app/ncm/playlist/$temp[1]";
	}
}