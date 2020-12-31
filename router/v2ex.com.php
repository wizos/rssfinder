<?php
function exe($url) {
    // 【V2ex节点】
    // 前缀：https://www.v2ex.com/feed/{name}.xml
    // 示例1：https://www.v2ex.com/?tab=apple
    if (preg_match("/v2ex\.com\/\?tab=([^?]+?)(\?|\/|$)/s", $url, $temp)) {
        return "https://www.v2ex.com/feed/" . $temp[1] . ".xml";
    }
    // 示例2：https://www.v2ex.com/go/apple
    if (preg_match("/v2ex\.com\/go\/([^?]+?)(\?|\/|$)/s", $url, $temp)) {
        return "https://www.v2ex.com/feed/" . $temp[1] . ".xml";
    }
    // 【V2ex帖子】
    // 示例：https://www.v2ex.com/t/423065
    if (preg_match("/v2ex\.com\/t\/(\d+)/s", $url, $temp)) {
        return "https://rss.lilydjwg.me/v2ex/" . $temp[1];
    }
    // 【V2ex用户】
    // https://www.v2ex.com/member/xuanwu
    if (preg_match("/v2ex\.com\/member\/([^?]+?)(\?|\/|$)/s", $url, $temp)) {
        return "https://www.v2ex.com/feed/member/".$temp[1].".xml";
    }
}