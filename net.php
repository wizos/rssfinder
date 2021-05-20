<?php

function post_net( $url, $options = array() ) {
    return common_net( true, $url, $options );
}


function get_net( $url, $options = array() ){
    return common_net( false, $url, $options );
}

function common_net( $is_post = false, $url, $options = array() ){
	$curl = curl_init();
    if (preg_match('/^https/', $url)){
    	//$options[CURLOPT_SSLVERSION] = 3;
        $options[CURLOPT_SSL_VERIFYHOST] = false; //是否检测服务器的域名与证书上的是否一致 
        $options[CURLOPT_SSL_VERIFYPEER] = false; //禁止 cURL 验证对等证书
    }
    if( $is_post ){
	    curl_setopt($curl, CURLOPT_POST, 1);//post方式提交
	    // curl_setopt($curl, CURLOPT_COOKIEJAR, 'stormss.txt' );
    }
    curl_setopt($curl, CURLOPT_URL, $url ); 
    curl_setopt($curl, CURLOPT_NOSIGNAL, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//设置不输出在浏览器上
    curl_setopt($curl, CURLOPT_HEADER, false);//非零值时，将 header 包含在输出中
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); //加入重定向处理
    curl_setopt_array($curl, $options);
    $data = curl_exec($curl);
    $curl_errno = curl_errno($curl);
	if( $curl_errno == 60 ){
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$data = curl_exec($curl);
		$curl_errno = curl_errno($curl); 
	}
    //print_r($curl_errno);
    //print_r("_");
    //print_r("_");
    //print_r("_");
    //print_r($data);
    curl_close($curl);//关闭cURL资源，并且释放系统资源
    if($curl_errno>0){
        return 'error';
    }else{
        return $data;
    }
}