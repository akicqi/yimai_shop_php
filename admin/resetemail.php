<?php 
/**
 * 易买网
 * Author: akic(蔡)
 * Date:2015-05-18
 * pagename:resetemail.php
 * 检测email和token
*/

header("Content-type:text/html;charset=utf-8");
//接受数据

$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'login';
//引入配置文件
include_once "./includes/init.php";

//取得get过来的token和email
$token = trim($_GET['token']);
$email = trim($_GET['email']);

//实例化Admin类
$admin = new Admin();

if($datecheck = $admin->getByEmail($email)) {
	//散列从数据库中取得的id、用户名、密码组成的字符串
	$tokencheck = md5($datecheck['id'] . $datecheck['a_username'] . $datecheck['a_password']);
	//与get过来的token进行比较
	if($tokencheck === $token) {
		//判断是否超过24小时
		if(time() - $datecheck['getpasstime'] > 24 * 60 * 60) {
			$msg = '该链接已过期，请重新请求！';
		}else {
			@session_start();
			//将要重置密码的用户id存入session
			$_SESSION['userreset'] = $datecheck['id'];
			linkRedirect('resetpasswd.php?act=pass','正在为您跳转密码重置页面！');
		}
	}else {
		$msg =  '链接已失效<br/>';
	}
}else{
	$msg =  '错误的链接！';	
}

echo $msg;


?>