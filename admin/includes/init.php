<?php 
/**
 * 易买网全局初始化页
 * Author: akic
 * Date:2015-05-14
 * pagename:init.php
*/

//设置解析字符集
header("content-type:text/html;charset=utf-8");

//定义全局目录常量
define('ADMIN_ROOT',str_replace('includes','',str_replace('\\', '/', __DIR__)));
define('ADMIN_INCL',ADMIN_ROOT . 'includes/');
define('ADMIN_TEMP',ADMIN_ROOT . 'templates/');
define('ADMIN_CORE',ADMIN_INCL . 'core/');
define('ADMIN_MODE',ADMIN_INCL . 'mode/');
define('ADMIN_CONF',ADMIN_ROOT . 'config/');
define('ADMIN_TOOL',ADMIN_INCL . 'tool/');
define('ADMIN_UPLO',ADMIN_ROOT . 'upload/');	//上传目录

//加载初始函数库文件
include_once "functions.php";

//加载网站配置文件
$config = include_once ADMIN_CONF . "config.php";

//身份认证
//实例化session类
$session = new Session();
//开启session
@session_start();

//取得访问文件名
$page_name = basename($_SERVER['SCRIPT_NAME']);

//根据是否需要验证登陆对privilege文件动作是否进行过滤
if($page_name == 'privilege.php' && ($act == 'login' || $act == 'checklogin' || $act == 'captcha')) {
	//不需要判断用户是否登陆
}else {
	//通过服务器端的session判断用户是否已经登陆
	if($page_name == 'resetpasswd.php' || $page_name == 'resetemail.php') {
		//判断是否进过session页面检测
	}else{
		if(!isset($_SESSION['u_id'])) {
			//没找到session，判断用户端cookie
			if(!isset($_COOKIE['user_id'])) {
				linkRedirect('privilege.php','用户信息已失效，请重新登陆！',1);
			}
		}else {
			 $admin = new Admin();
		 	 $loginDate = $admin->getById($_SESSION['u_id']);

		}

	}
}
?>