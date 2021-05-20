<?php
function exe($url){
    # 【知乎用户】
	// 示例1：https://www.zhihu.com/people/zhupengfei
	// 示例2：https://www.zhihu.com/org/lao-ba-ping-ce/answers
	if( preg_match("/zhihu\.com\/(people|org)\/([^?]+?)(\?|\/|$)/s", $url, $temp) ){
		if(is_admin){
		    $feeds[] = array('title' => "用户的动态", 'link' => "https://rss.wizos.me/zhihu.php?n=".$temp[2]."&t=activities");
		    $feeds[] = array('title' => "用户的回答与想法", 'link' => "https://rss.wizos.me/zhihu.php?n=".$temp[2]."&t=original");
		}
		$feeds[] = array('title' => "用户的动态", 'link' => "https://rsshub.app/zhihu/people/activities/".$temp[2]);
		$feeds[] = array('title' => "用户的回答", 'link' => "https://rsshub.app/zhihu/people/answers/".$temp[2]);
		$feeds[] = array('title' => "用户的想法", 'link' => "https://rsshub.app/zhihu/people/pins/".$temp[2]);
		
        // $feeds[] = array('title' => "知乎日报", 'link' => "https://rsshub.app/zhihu/daily");
        // $feeds[] = array('title' => "知乎热榜", 'link' => "https://rsshub.app/zhihu/hotlist");
        // $feeds[] = array('title' => "知乎新书", 'link' => "https://rsshub.app/zhihu/bookstore/newest");
        // $feeds[] = array('title' => "知乎想法-24小时新闻汇总", 'link' => "https://rsshub.app/zhihu/pin/daily");
		    // $feeds[] = array('title' => "用户的回答", 'link' => "https://rss.lilydjwg.me/zhihu/".$temp[1]);// （只支持回答和文章两种类型)
		return $feeds;
	}
	
	if( preg_match("/zhihu\.com\/collection\/(\d*)(\?|\/|$)/s", $url, $temp ) ){
	  if(is_admin){
		    $feeds[] = array('title' => "收藏夹", 'link' => "https://rss.wizos.me/zhihu-collection.php?id=".$temp[1]);
		}
		$feeds[] = array('title' => "收藏夹", 'link' => "https://rsshub.app/zhihu/collection/".$temp[1]);
		return $feeds;
	}
	
	
	if( preg_match("/zhihu\.com\/question\/(\d+)(\?|\/|$)/s", $url, $temp) ){
		$feeds[] = array('title' => "该问题的RSS", 'link' => "https://rsshub.app/zhihu/question/".$temp[1]);
		return $feeds;
	}
	
	# 【知乎专栏】
	// 示例：https://zhuanlan.zhihu.com/p/28089565?group_id=873134374130970624
	if( preg_match("/zhuanlan\.zhihu\.com\/p\/\d*(\?|\/|$)/s", $url ) ){
		$html = get_net($url);
		preg_match('/ColumnPageHeader-TitleColumn.+href="(.+?)"/s', $html, $temp);
		$url = "http://".trim($temp[1],"/");
	}
	// 示例：https://zhuanlan.zhihu.com/dingxiangyisheng
	if( preg_match("/zhuanlan\.zhihu\.com\/(?!p\/)([\w][\w-]*)(\?|\/|$)/isU", $url, $temp) ){
		//return "https://rss.lilydjwg.me/zhihuzhuanlan/".$temp[1];
		//return "http://zhihurss.miantiao.me/zhihuzhuanlan/".$temp[1];
		$feeds[] = array('title' => "专栏", 'link' => "https://rsshub.app/zhihu/zhuanlan/".$temp[1]);
	}
	// 示例：https://zhuanlan.zhihu.com/dingxiangyisheng
	if( preg_match("/zhihu\.com\/column\/([\w][\w-]*)(\?|\/|$)/isU", $url, $temp) ){
		$feeds[] = array('title' => "专栏", 'link' => "https://rsshub.app/zhihu/zhuanlan/".$temp[1]);
	}
	return $feeds;
}