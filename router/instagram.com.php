<?php
function exe($url) {
    if(preg_match("/instagram\.com\/(accounts|about|developer|legal|explore|directory)(\?|\/|$)/is", $url)){
        return null;
    }
    // 【INS】
    // 示例：https://www.instagram.com/adax.l
    // 前缀：http://feed.exileed.com/instagram/feed/{user_name}
    if (preg_match("/instagram\.com\/([^?]+?)(\?|\/|$)/s", $url, $temp)) {
        return "https://rsshub.app/instagram/user/" . $temp[1];
    }
}