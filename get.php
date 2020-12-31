<?php
/**
 * Author: Wizos
 * Description: 搜索接口
 * ChangeLog:
 *   Date, Version, Explain
 *   2018-01-15, V1.0, First
 *   2018-07-14, V1.1, 修改为site router方式
 *   2018-06-24, V1.2, 增加优酷的路由
 *   2018-08-05, V1.3, 优化代码逻辑，支持按“一级域名”查找文件
 *   2018-08-11, V1.3.1, 修复q的值如果带有参数，无法传递的问题
 *   2018-09-06, V1.3.2, 修改site_router路径为常量
 *   2018-10-14, V1.4, 适应RSS+，改传递结构为json
 */

set_time_limit(600); #设置执行时间限时
date_default_timezone_set('PRC');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods: GET');
header("Content-Type:text/json; charset=utf-8");
error_reporting(E_ERROR);

define('site', dirname( __FILE__ )."/router/");


preg_match("/^q=(.+?)$/s", urldecode($_SERVER["QUERY_STRING"]), $temp);
$url = "http://".$temp[1];
$filepath = getFilePath ($url);
include($filepath);
$findResult = exe($url);



if(!$findResult){
	$data["status"] = 404;
}else{
	$data["status"] = 200;
	if( !is_array( $findResult ) ){
		$data["feeds"][] = array("title"=>"无名","link"=> $findResult);
	}else if(array_key_exists("link", $findResult)){
		$data["feeds"] =  array($findResult);
	}else{
	    $data["feeds"] =  $findResult;
	}
}
echo json_encode($data);

function getFilePath ($url){
	$uri = parse_url($url);
	$host = preg_replace("/^www\./s","",$uri['host']);
	$filepath = site.$host.".php";
	if(is_file($filepath)){
		return $filepath;
	}
	
	$filepath = site."www.".$host.".php";
	if(is_file($filepath)){
		return $filepath;
	}

	preg_match('/[\w][\w-]*\.(?:com\.cn|com|cn|co|net|org|gov|cc|biz|info)(\/|$)/isU', $url, $domain);
	$host = rtrim($domain[0], '/');
	$filepath = site.$host.".php";
	if(is_file($filepath)){
		return $filepath;
	}
	
	$filepath = site."#.php";
	if(is_file($filepath)){
		return $filepath;
	}
}