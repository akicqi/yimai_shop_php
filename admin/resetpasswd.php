<?php 
/**
 * 易买网
 * Author: akic(蔡)
 * Date:2015-05-18
 * pagename:resetpasswd.php
 * 重置admin密码
*/

header("Content-type:text/html;charset=utf-8");
//接受数据

$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'login';
//引入配置文件
include_once "./includes/init.php";
include_once "./includes/tool/class.phpmailer.php";

if($act == 'login') {
	include_once ADMIN_TEMP . "reset.html";
}elseif ($act == 'reset') {
	//取得要发送重置的邮箱
	$resetemail = $_POST['resetemail'];

	$admin = new Admin();

	//判断重置邮箱在数据库中是否存在
	if(!$date = $admin->getByEmail($resetemail)) {
		linkRedirect('resetpasswd.php','该邮箱未注册');
	}
	//取得当前时间戳
	$getpasstime = time();
	//取得用户id
	$uid = $date['id'];
	//取得username、password
	$username = $date['a_username'];
	$password = $date['a_password'];
	//进行md5散列
	$token = md5($uid . $username . $password);
	//构造url
	$url = "http://127.0.0.1:8080/yimai/admin/resetemail.php?email=".$resetemail."&token=".$token;
	$time = date('Y-m-d H:i');


	//实例化邮件类并配置参数
	$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
	$mail->Host       = $GLOBALS['config']['email']['Host'];
	$mail->Port       = $GLOBALS['config']['email']['Port'];  
	$mail->SMTPAuth   = $GLOBALS['config']['email']['SMTPAuth'];  
	 
	$mail->CharSet    = $GLOBALS['config']['email']['CharSet'];  
	$mail->Encoding   = $GLOBALS['config']['email']['Encoding']; 
	 
	$mail->Username   = $GLOBALS['config']['email']['Username']; 
	$mail->Password   = $GLOBALS['config']['email']['Password'];
	$mail->Subject    = $GLOBALS['config']['email']['Subject'];
	 
	$mail->From       = $GLOBALS['config']['email']['From'];
	$mail->FromName   = $GLOBALS['config']['email']['FromName'];
	 
	$address          = "$resetemail";
	$mail->AddAddress($address, "亲");
	 
	$mail->IsHTML(true); 
	$mail->Body = "亲爱的".$resetemail."：<br/>您在".$time."提交了重置密码请求。请点击下面的链接重置密码（按钮24小时内有效）。<br/><a href='".$url."' target='_blank'>".$url."</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问。<br/>如果您没有提交找回密码请求，请忽略此邮件。"; //邮件主体内容 
	 

	if(!$mail->Send()) { 
	  echo "Mailer Error: " . $mail->ErrorInfo; 
	} else { 
	  //更新时间戳
	  $admin->updateTime($getpasstime,$uid);
	  echo "重置链接已发送，请检查您的邮箱！"; 
	  linkRedirect('privilege.php','',2);
	} 

}elseif ($act == 'pass') {
	include_once ADMIN_TEMP . "resetpasswd.html";
}elseif ($act == 'checkpasswd') {
	//取得session中的用户id以及post过来的password
	$id = $_SESSION['userreset'];
	$password = trim($_POST['passWord']);
	$passwdconfirm = trim($_POST['passconfirm']);

	//合理性验证
	if(!($password === $passwdconfirm)) {
		linkRedirect('resetpasswd.php?act=pass','两次输入的密码不一致！请重试！');
	}else {
		$admin = new Admin();
		if($admin->resetPasswd($id,$password)) {
			linkRedirect('privilege.php','重置密码成功，正在为您跳转至登陆页！');
		}else {
			//记录进系统日志
		}
	}
}


?>