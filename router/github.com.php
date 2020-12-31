<?php
function exe($url){
	// 仓库 releases: https://github.com/:owner/:repo/releases.atom
	// 仓库 commits: https://github.com/:owner/:repo/commits.atom
	// 用户动态: https://github.com/:user.atom
	if( preg_match("/github\.com\/([^?]+?)\/([^?]+?)(\?|\/|$)/s", $url, $temp) ){
		return "https://github.com/$temp[1]/$temp[2]/releases.atom";
		//return "https://github.com/$temp[1]/$temp[2]/commits.atom";
		//return "https://github.com/$temp[1].atom";

		//return "https://rsshub.app/github/issue/$temp[1]/$temp[2]";
		//return "https://rsshub.app/github/stars/$temp[1]/$temp[2]";
		//return "https://rsshub.app/github/user/followers/$temp[1]";
	}
}