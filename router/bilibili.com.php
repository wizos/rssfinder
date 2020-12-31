<?php
function exe($url){
  # 【UP主发布的视频】
  // 示例：http://space.bilibili.com/88461692
  // UP主前缀1：https://api.prprpr.me/bilibili2rss/user/，https://rsshub.app/bilibili/user/video/ [作者：github.com/DIYgod]
  // UP主前缀2：https://api.lim-light.com/bilibili/rss/?id=
  // UP主前缀3：https://script.google.com/macros/s/AKfycbzojPIDsSo3fC2sb8xLWnXh9YwSUC_TsvSe9araLFuwnGLd8CXP/exec?mid=
  // UP主前缀4：http://rss.wizos.me/bilibili.php?id= , [作者：github.com/Wizos]
  if (preg_match("/space\.bilibili\.com\/(\d+)/s", $url, $temp)) {
    $feeds = array();
    if(is_admin){
       $feeds[] = array('title' => "UP主的投稿视频", 'link' => "http://rss.wizos.me/bilibili.php?id=" . $temp[1]); 
    }
    $feeds[] = array('title' => "UP主的投稿视频", 'link' => "https://rsshub.app/bilibili/user/video/" . $temp[1]);
    $feeds[] = array('title' => "UP主的专栏文章", 'link' => "https://rsshub.app/bilibili/user/article/".$temp[1]);
    $feeds[] = array('title' => "UP主的动态", 'link' => "https://rsshub.app/bilibili/user/dynamic/".$temp[1]);
    $feeds[] = array('title' => "UP主的默认收藏夹", 'link' => "https://rsshub.app/bilibili/user/fav/".$temp[1]);
    $feeds[] = array('title' => "UP主的投币视频", 'link' => "https://rsshub.app/bilibili/coin/fav/".$temp[1]);
    $feeds[] = array('title' => "UP主的粉丝", 'link' => "https://rsshub.app/bilibili/followers/fav/".$temp[1]);
    $feeds[] = array('title' => "UP主关注的用户", 'link' => "https://rsshub.app/bilibili/followings/fav/".$temp[1]);
    return $feeds;
  }

  // 示例：https://www.bilibili.com/video/av33147686
  if (preg_match("/bilibili\.com\/video\//s", $url)) {
    $options = array(CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', CURLOPT_REFERER => "http://space.bilibili.com/", CURLOPT_ENCODING => 'gzip');
    $res = get_net($url, $options);
    preg_match("/space\.bilibili\.com\/(\d+)/s", $res, $temp1);
    preg_match('/"name":"(.*?)"/s', $res, $temp2);
    //return array('title' => $temp2[1] . "的投稿视频", 'link' => "http://rss.wizos.me/bilibili.php?id=" . $temp1[1]);
    if(is_admin){
        return array('title' => $temp2[1] . "的投稿视频", 'link' => "http://rss.wizos.me/bilibili.php?id=" . $temp1[1]);
    }else{
        return array('title' => $temp2[1] . "的投稿视频", 'link' => "https://rsshub.app/bilibili/user/video/" . $temp[1]);
    }
  }
  
  # 【番剧】
  // 示例：http://bangumi.bilibili.com/anime/5800
  // 前缀1：https://api.prprpr.me/bilibili2rss/bangumi/{id} （作者：github.com/DIYgod/bilibili2RSS）
  // 前缀2：https://bilibili2rss.bid/anime/{id} （作者：github.com/wdssmq/Bilibili2RSS）
  if (preg_match("/bangumi\.bilibili\.com\/anime\/(\d+)/s", $url, $temp)) {
    return array('title' => "该番剧的RSS", 'link' => "https://rsshub.app/bilibili/bangumi/".$temp1[1]);
  }

  # 【直播间】
  //eg: https://live.bilibili.com/23058
  if (preg_match("/live\.bilibili\.com\/(\d+)/is", $url, $temp)) {
    return array('title' => "直播间", 'link' => "https://rsshub.app/bilibili/live/room/".$temp[1]);
  }
}
