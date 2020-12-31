<?php
include_once dirname(dirname(__DIR__))."/lib/phpQuery.php";

function exe($url){
  # 【UP主发布的视频】
  // 示例：https://v.qq.com/detail/7/79npj83isb0ylvq.html
  if (preg_match("/v\.qq\.com\/detail\/.*\/([^?]+?)\.html/s", $url, $temp)) {
    $feeds = array();
    $feeds[] = array('title' => "播放列表", 'link' => "https://rsshub.app/tencentvideo/playlist/" . $temp[1]);
    return $feeds;
  }

  // 示例：https://v.qq.com/x/cover/79npj83isb0ylvq/h0029i49ce2.html
  if (preg_match("/v\.qq\.com\/x\/cover\//s", $url)) {
    $options = array(CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', CURLOPT_REFERER => "https://v.qq.com");
    $res = get_net($url, $options);
    phpQuery::newDocument( $res );
    
    $link = pq( '#div.player_header > h2 > a' ) -> attr('href');
    preg_match("/\/detail\/.*\/([^?]+?)\.html/s", $link, $temp);
    $title = pq( '#div.player_header > h2 > a' ) -> text();
    return array('title' => $title, 'link' => $temp[1] );
  }
}
