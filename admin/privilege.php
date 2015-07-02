<?php 
/**
 * 易买网
 * Author: akic
 * Date:2015-05-14
 * pagename:privilege.php
*/

header("Content-type:text/html;charset=utf-8");
//接受数据

$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'login';
//引入配置文件
include_once "./includes/init.php";

if($act == 'login') {
	include_once ADMIN_TEMP . 'login.html';
}elseif($act == 'checklogin') {
	$username = trim($_POST['userName']);
	$password = trim($_POST['passWord']);
	$captcha = trim($_POST['veryCode']);

	//合法性验证
	if(empty($username) || empty($password)){
		linkRedirect('privilege.php','用户名和登录密码都不允许为空！');
	}

	if(empty($captcha)) {
		linkRedirect('privilege.php','验证码不能为空！');
	}

	if(!Captcha::checkCaptcha($captcha)) {
		linkRedirect('privilege.php','验证码输入错误！');
	}

	//合理性验证
	$admin = new Admin();

	$adminInfo = $admin->checkUsernameAndPassword($username);
	
	//进行管理员登录判断
	//用户名判断
	if($adminInfo){
		//密码判断,使用强hash算法
		if($adminInfo['a_password'] == sha1('yimai_' . $password)) {
			//如果账号密码检查通过则将id加入session
			@session_start();
			$_SESSION['u_id'] = $adminInfo['id'];
	

			//cookie保存用户登录id
			if(isset($_POST['setAutoLogin'])) {
				setcookie('user_id',$adminInfo['id'],time() + (7 * 24 * 60 * 60));

			}
			linkRedirect('index.php','登陆成功！');
		}else {
			linkRedirect('privilege.php','密码错误！');
		}
	}else {
		linkRedirect('privilege.php','用户名错误！');
	}
}elseif($act == 'captcha') {
	// 输出验证码
	$captchaImage = new Captcha();
	header("Content-type:image/png");
	$captchaImage->generate();

}elseif ($act == 'add') {
	include_once ADMIN_TEMP . "admin-add.html";
}elseif ($act == 'insert') {
	//添加管理员
	//实例化管理员类
	$admin = new Admin();

	//取得post过来的数据
	$username = trim($_POST['userName']);
	$password = trim($_POST['passWord']);
	$email = trim($_POST['email']);

	//合法性验证
	//判断账号和密码是否为空
	if(empty($username) || empty($password)) {
		linkRedirect('privilege.php?act=add','账号或密码不允许为空！');
	}

	//判断邮箱是否合法
	if(!strlen($email)) {
		linkRedirect('privilege.php?act=add','邮箱名不能为空！');
	}
	//邮箱检测正则
	$emailRegular = '/^([\w\.\_]{2,10})@(\w{1,}).([a-z]{2,4})$/';
	if(!preg_match($emailRegular, $email)) {
		linkRedirect('privilege.php?act=add','邮箱名部分只能2到10位！');
	}

	//允许注册的邮箱列表
	$allowEmail = array("@qq.com","@163.com","@gmail.com","@outlook.com");

	//检测邮箱
	if($emailCheck = strstr($email,'@')){
		if(!in_array($emailCheck,$allowEmail)) {
			linkRedirect('privilege.php?act=add','只允许QQ、163、gmail和outlook邮箱注册');
		}
	}else {
		linkRedirect('privilege.php?act=add','邮箱名不合法！');
	}

	//合理性判断
	if($admin->checkUsernameAndPassword($username)) {
		linkRedirect('privilege.php?act=add','该用户名已存在，请登陆或者另起新名称！');
	}

	if($admin->insertAdmin($username,$password,$email)) {
		linkRedirect('privilege.php?act=list','添加管理员成功！');
	}else {
		linkRedirect('privilege.php?act=add','添加失败，请重试！');
	}

}elseif($act == 'list') {
	$admin = new Admin();
	$adminDate = $admin->getAllAdmin();
	include_once ADMIN_TEMP . "admin-list.html";
}elseif($act == 'edit') {
	$id = $_SESSION['gettId'];
	$admin = new Admin();
	$date = $admin->getById($_SESSION['gettId']);
	include_once ADMIN_TEMP . "admin-modify.html";
}elseif($act == "update") {
	$id = $_POST['id'];
	//取得用户修改后的数据
	$password = trim($_POST['passwdchange']);
	$passwordconfirm = trim($_POST['passwdconfirm']);
	$email = trim($_POST['emailchange']);

	//合法性验证
	//判断密码是否为空
	if(empty($password)) {
		linkRedirect('privilege.php?act=edit','密码不能为空！');
	}

	//判断密码强度
	if(strlen($password) < 5) {
		linkRedirect('privilege.php?act=edit','密码位数过少');
	}
	//正则，判断密码是否为纯数字
	$code = '/^(\d+|[0-9]+)$/i';
	$codeEnglish = '/^(\d+|[a-z]+)$/i';
	if(preg_match($code,$password && preg_match($codeEnglish, $password))) {
		linkRedirect('privilege.php?act=edit','密码不能为纯数字或者纯英文');
	}

	//判断密码与确认密码是否一致
	if(!($password === $passwordconfirm)) {
		linkRedirect('privilege.php?act=edit','两次输入的密码不一致！');
	}

	//判断邮箱合法性
	//判断邮箱是否为空
	if(!strlen($email)) {
		linkRedirect('privilege.php?act=edit','邮箱名不能为空！');
	}
	$emailRegular = '/^([\w\.\_]{2,10})@(\w{1,}).([a-z]{2,4})$/';
	if(!preg_match($emailRegular, $email)) {
		linkRedirect('privilege.php?act=edit','邮箱名部分只能2到10位！');
	}

	//允许注册的邮箱列表
	$allowEmail = array("@qq.com","@163.com","@gmail.com","@outlook.com");

	//检测邮箱
	if($emailCheck = strstr($email,'@')){
		if(!in_array($emailCheck,$allowEmail)) {
			linkRedirect('privilege.php?act=edit','只允许更新为QQ、163、gmail和outlook邮箱');
		}
	}else {
		linkRedirect('privilege.php?act=edit','邮箱名不合法！');
	}

	$admin = new Admin();
	// var_dump($admin);exit;
	if($admin->updateAdmin($password,$email,$id)) {
		linkRedirect('privilege.php?act=list','管理员信息更新成功！');
	}else {
		linkRedirect('privilege.php?act=edit','管理员信息更新失败，请重试！');
	}

}elseif($act == "delete") {
	$id = $_GET['id'];
	$admin = new Admin();
	if($admin->deleteAdmin($id)) {
		linkRedirect('privilege.php?act=list','删除成功！');
	}else {
		linkRedirect('privilege.php?act=list','删除失败，请重试！');
	}
}

