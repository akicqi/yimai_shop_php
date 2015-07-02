<?php 
/**
 * 易买网函数/方法初始化页
 * Author: akic
 * Date:2015-05-14
 * pagename:functions.php
*/

/*
* 页面跳转函数
* @param1 string $url 需要跳转页面文件名
* @param2 string $mst 跳转提示信息
* @param3 int $time = 3 跳转等待时间，默认为3s
*/
function linkRedirect($url,$mst,$time = 3) {
	include_once ADMIN_TEMP . "prompt.html";
	exit;
}

function redirect($url,$msg,$time=3000){
	 //加载跳转模板
	  include_once ADMIN_TEMP .'manage-result.html';
	  exit;
}

function admin_redirect($msg,$url,$time = 3000){

		//加载跳转模版
		include_once ADMIN_TEMP . 'redirect.html';
		exit;
}

function ym_manage($url,$msg,$time = 3){

		//加载跳转模板
		include_once ADMIN_TEMP . 'manage-result.html';
		exit;
}

//定义自动加载实例化类
function __autoload($class) {
	//判断文件是否存在
	$mode = ADMIN_MODE . "{$class}.class.php";
	$core = ADMIN_CORE . "{$class}.class.php";
	$tool = ADMIN_TOOL . "{$class}.class.php";
	
	//存在则自动加载
	if(file_exists($mode)) {
		include_once "$mode";
	}elseif(is_file($core)) {
		include_once "$core";
	}elseif (is_file($tool)) {
		include_once "$tool";
	}
}
