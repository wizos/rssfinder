<?php
include "./lib/net.php";
include "./lib/SqliteDB.php";
// include "./Finder.php";
// include "./lib/FormatUtils.php";
date_default_timezone_set('PRC');
set_time_limit(600); #设置执行时间限时
error_reporting(E_ERROR);
//ob_end_clean();
//ob_implicit_flush(1);

/**
 * Author: Wizos
 * Description: 搜索接口
 * ChangeLog:
 *   Date, Version, Explain
 *   2018-01-16, V2.3, 1.增加 Finder 服务，用于去查找输入的网址对应的 RSS; 2.改接收请求的方式为post，这样可以接收带有http://的参数（这个问题还是没解决，只是采用这个替代方案）。
 *   2018-01-13, V2.2, 
 *   2018-01-08, V2.1, 
 *   2018-01-08, V2.0, 增加 DB 存储
 */
 
if( @$_POST['q'] == '' ){ // @$_GET['type'] == '' ||
	eroor ();
}
$query = $_POST['q'];

$sql_table_records = <<<EOF
CREATE TABLE "Records" (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`word`	NVARCHAR(100) NOT NULL,
	`createdTime`	INTEGER DEFAULT (strftime('%s','now'))
)
EOF;
$sql_table_feeds = <<<EOF
CREATE TABLE "Feeds" (
	`id`	NVARCHAR(100) NOT NULL,
	`seedId`	INTEGER,
	`title`	NVARCHAR(100),
	`description`	NVARCHAR(100),
	`author`	NVARCHAR(100),
	`tags`	NVARCHAR(100),
	`siteUrl`	VARCHAR(255),
	`iconUrl`	VARCHAR(255),
	`feedUrl`	VARCHAR(255),
	`feedType`	CHAR(8) DEFAULT 'xml',
	`subscribers`	SMALLINT DEFAULT 0,
	`velocity`	SMALLINT DEFAULT 0,
	`lastUpdated`	INTEGER,
	`lastCrawled`	INTEGER DEFAULT (strftime('%s','now')),
	`createdTime`	INTEGER DEFAULT (strftime('%s','now')),
	`validity`	SMALLINT DEFAULT 0,
	`crawlInterval`	SMALLINT DEFAULT 604800,
	PRIMARY KEY(id)
)
EOF;


$db = new SqliteDB( 'Vault.db' );
$db->exec( $sql_table_records );
$db->exec( $sql_table_feeds );
if( $_POST['m'] != "debug" ){
	checkRecords ( $db, $query);
}

$feedlyFeeds = getFeedlyFeeds ( $query );
$yilanFeeds = getYilanFeeds ( $query );
$inoreaderFeeds = getInoreaderFeeds( $query );
$feedlyFeeds = optimizeFeeds ( $query, $feedlyFeeds, $yilanFeeds, $inoreaderFeeds);
outjson ( $query, $feedlyFeeds );
save2DB ( $db, $query, $feedlyFeeds );

exit;


function getFeedlyFeeds ( $query ){
	$feedly_url = 'http://cloud.feedly.com/v3/search/feeds?n=1000&query='.urlencode($query);
	$json = get_net( $feedly_url );
	$msg = json_decode($json, true);
	$feedlyFeeds = $msg['results'];
	return $feedlyFeeds;
}


function getYilanFeeds ( $query ){
	$yilan_url = 'http://www.yilan.io/site/search';
	$headers = array(
		'Content-Type:application/json;charset=UTF-8',
		'Cookie:Metrix-sid=s%3ARdRVFRryYG8oMFhGQHXCstWN0W8Gfj_o.cAAzjtnoWp5vRbGTPDR8pDbeXAP2vw6AK2SpXeZcKhs;',
		'X-XSRF-TOKEN:s81iPpqg-OIlZfoBDvRl1iD2gwOv3lV2KS1c'
	);
	$options = array(
		CURLOPT_HTTPHEADER => $headers,
		CURLOPT_POSTFIELDS => '{"keyword":"'.$query.'","sort":{"usersCount":-1},"limit":1000}' // 最大数量500
	);
	
	$json = post_net( $yilan_url, $options );
	$yilanFeeds = json_decode($json, true);
	return $yilanFeeds;
}

function getInoreaderFeeds ( $query ){
	$headers = array(
		'AppId:1000001277',
		'AppKey:8dByWzO4AYi425yx5glICKntEY2g3uJo',
		'Authorization:GoogleLogin auth=XuskoF9zMTifSB2uetBiR3zD9kt0Udlh'
	);
	$options = array(CURLOPT_HTTPHEADER => $headers );
	$inoreaderFeeds = array();
	$offset = 0;
	do{
		$inoreader_url = 'https://www.inoreader.com/reader/api/0/directory/search/'.urlencode($query).'?n=1000&offset='.$offset; // n最大未100
		$json = get_net( $inoreader_url, $options );
		$msg = json_decode($json, true);
		$offset = $offset + 100;
		$inoreaderFeeds = array_merge( $inoreaderFeeds, $msg['feeds']);
	} while ( $msg['found'] > $offset );
	return $inoreaderFeeds;
}

function getFeedlyFeedsFromDB ( $db, $query ){
	$sql = 'select * from Feeds where title like "%'.$query.'%" or description like "%'.$query.'%"  or tags like "%'.$query.'%" ORDER BY lastUpdated DESC,validity DESC';
	$dbFeeds = $db -> query( $sql );
	$feedlyFeeds = array();
	foreach( $dbFeeds as $li ){
		$feedlyFeeds[] = FormatUtils::db2Feedly ( $li );
	}
	return $feedlyFeeds;
}


function optimizeFeeds ( $query, $feedlyFeeds, $yilanFeeds, $inoreaderFeeds){
	$feedlyFeedIDs = array();
	foreach( $feedlyFeeds as $li ){
		$feedlyFeedIDs[] = $li['feedId'];
	}

	$finderFeedUrl = getFeedIDByFinder ($query);
	if( $finderFeedUrl && !in_array('feed/'.$finderFeedUrl, $feedlyFeedIDs) ){
		$feedIDs[] = 'feed/'.$finderFeedUrl;
		$feedlyFeedsFinder = getFeedlyFeedsByfeedIDs ($feedIDs);
		$feedlyFeeds = array_merge( (array)$feedlyFeedsFinder, (array)$feedlyFeeds );
	}
	
	$feedIDs = array();
	foreach( $yilanFeeds as $li ){
		if( !in_array('feed/'.$li['url'],$feedlyFeedIDs) && $li['type'] == 'rss' ){
			$feedIDs[] = 'feed/'.$li['url'];
		}
	}
	foreach( $inoreaderFeeds as $li ){
		if( !in_array('feed/'.$li['xmlUrl'],$feedlyFeedIDs) ){
			$feedIDs[] = 'feed/'.$li['xmlUrl'];
		}
	}

	// 将从一览和Inoreader获得的feeds再到feedly中搜一遍，以获取更详尽的资料
	$feedlyFeedsTemp = getFeedlyFeedsByfeedIDs ($feedIDs);
	
	// 合并各方数据
	$feedlyFeeds = array_merge( (array)$feedlyFeeds, (array)$feedlyFeedsTemp );
	return $feedlyFeeds;
}

function getFeedIDByFinder ($query){
	if( substr($query, 0, 7) != "http://" && substr($query, 0, 8) != "https://" ){
		return;
	}
	$findFeedUrl = Finder::findFeeds($query);
	if( $findFeedUrl ){
		return $findFeedUrl;
	}
}


/**
 * 传过来的 feedIDs 必须是数组，且不为空。其中的 feedID 必须要以 feed/ 开头
 */
function getFeedlyFeedsByfeedIDs ($feedIDs){
	if( !is_array($feedIDs) || count($feedIDs) == 0 ){
		return;
	}
	$feeds_meta_url = "http://cloud.feedly.com/v3/feeds/.mget";
	$headers = array(
		'Content-Type:application/json;charset=UTF-8'
	);
	$options = array(
		CURLOPT_HTTPHEADER => $headers,
		CURLOPT_POSTFIELDS => '["'.implode('","', $feedIDs).'"]' // 最大数量500
	);
	
	$json = post_net( $feeds_meta_url, $options );
	$msg_results = json_decode($json, true);
	$feedlyFeedsTemp = array();
	if($msg_results['errorCode']){
		return $feedlyFeedsTemp;
	}
	$li = array();
	foreach( $msg_results as $li ){
		if( $li['updated'] ){
			$li['lastUpdated'] = $li['updated'];
		}
		$feedlyFeedsTemp[] = $li;
	}
	return $feedlyFeedsTemp;
}



function outjson ( $query, $feedlyFeeds ){
	//header("Content-Type:text/plain; charset=utf-8");
	header("Content-Type:application/json; charset=utf-8");
	header('HTTP/1.1 200 OK');
	echo json_encode(array("hint"=>$query,"results"=>$feedlyFeeds ));
}

function checkRecords ( $db, $query ){
	getFeedlyFeedsFromDB ($db, $query);
	return;
	$sql = 'select createdTime from Records where word == "'.$query.'" ORDER BY createdTime DESC limit 1';
	$result = $db -> query( $sql );
	$createdTime = $result[0]['createdTime'];
	if( time() - $createdTime < 3*24*3600 ){
		outjson ( $query, getFeedlyFeedsFromDB ($db, $query) );
		exit;
	}
}


function save2DB ( $db, $query, $feedlyFeeds ){
	$db -> beginTransaction();
	foreach( $feedlyFeeds as $feedlyFeed ){
		$db->exec( insertFeedsSql( $feedlyFeed ) );
	}
	$db -> exec( insertRecordsSql ( $query ) );
	$db -> commit();
}




function insertRecordsSql ( $query ){
	return 'insert into Records (word) values("'.$query.'")';
}

function insertFeedsSql ( $feedlyFeed ){
	if(!is_array($feedlyFeed)){
		return;
	}
	if($feedlyFeed['subscribers']){
		$subscribers_key = ',subscribers';
		$subscribers_value = ','.$feedlyFeed['subscribers'];
		
	}
	if($feedlyFeed['velocity']){
		$velocity_key = ',velocity';
		$velocity_value = ','.$feedlyFeed['velocity'];
	}
	if($feedlyFeed['lastUpdated']){
		$lastUpdated_key = ',lastUpdated';
		$lastUpdated_value = ','.$feedlyFeed['lastUpdated'];
	}else if($feedlyFeed['updated']){
		$lastUpdated_key = ',lastUpdated';
		$lastUpdated_value = ','.$feedlyFeed['updated'];
	}
	return  'insert or replace into Feeds (id,title,description,siteUrl,iconUrl,feedUrl,tags'.$subscribers_key.$velocity_key.$lastUpdated_key.') values( "'.$feedlyFeed['feedId'].'","'.$feedlyFeed['title'].'","'.$feedlyFeed['description'].'","'.@$feedlyFeed['website'].'","'.@$feedlyFeed['visualUrl'].'","'.ltrim($feedlyFeed['feedId'],'feed/').'","'.implode(",",$feedlyFeed['deliciousTags']).'"'.$subscribers_value.$velocity_value.$lastUpdated_value.')';
}




function eroor ( $msg="请输入正确的参数" ){
	header("Content-Type:application/json; charset=utf-8");
	header("HTTP/1.1 400 Bad request");
	echo json_encode(array("status"=>"400","msg"=>$msg ));
	exit();
}

######################### 以下不用 ############################


function optimizeFeeds_old ( $feedlyFeeds, $yilanFeeds, $inoreaderFeeds){
	foreach( $yilanFeeds as $li ){
		if( !array_key_exists('feed/'.$li['url'],$feedlyFeeds) && $li['type'] == 'rss' ){
			$feedlyFeeds[] = FormatUtils::yilan2Feedly ( $li );
		}
	}
	foreach( $inoreaderFeeds as $li ){
		if( !array_key_exists('feed/'.$li['xmlUrl'],$feedlyFeeds) ){
			$feedlyFeeds[] = FormatUtils::ino2Feedly ( $li );
		}
	}
	return $feedlyFeeds;
}
function is_utf8($word){
	if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$word) == true){
		return true;
	}else{
		return false;
	}
}