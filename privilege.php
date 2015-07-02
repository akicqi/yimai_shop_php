<?php

	//用户权限认证文件
	
	$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'login';

	//加载初始化文件
	include_once './includes/init.php';
	
	//判断用户动作，处理请求
	if($act == 'login'){
		
		//加载登陆模板
		include_once YIMAI_TEMP.'login.html';

	}elseif($act == 'register'){

		//加载注册模板
		include_once YIMAI_TEMP.'register.html';

	}elseif($act == 'insert'){
		
		//接受注册表单数据
		$username = trim($_POST['userName']);
		$password = trim($_POST['passWord']);
		$re_password = trim($_POST['rePassWord']);
		$captcha = trim($_POST['veryCode']);

		//合法性判断
		//验证码合法性判断
		if(empty($captcha)){
		
			my_redirect('privilege.php?act=register','验证码不能为空！','正在为您重新跳转到注册页面');
		}
		//数据合法性判断
		if(empty($username) || empty($username)){
			
			//跳转
			my_redirect('privilege.php?act=register','用户名或密码不能为空！','正在为您重新跳转到注册页面');
		}	
		//判断两次输入密码是否相同
		if($password !== $re_password){
		
			my_redirect('privilege.php?act=register','两次输入密码不一致！','正在为您重新跳转到注册页面！');
		}	
		
		//验证码合理性判断
		if(!Captcha::checkCaptcha($captcha)){

			my_redirect('privilege.php?act=register','验证码错误！','正在为您重新跳转到注册页面');
		}
		//合理性判断
		$user = new User();
		if($user->getUserByUsername($username)){

			//用户名存在
			my_redirect('privilege.php?act=register','该用户名已经存在！','正在为您重新跳转到注册页面！');
		}
		
		//将数据插入数据库
		if($id = $user->insertUser($username,$password)){
			
			//注册成功
			//将用户id写入到session
			$_SESSION['user_id'] = $id;
			my_redirect('index.php','注册成功！','正在为您重新跳转到首页！',1000);	
		}else{
			//注册失败
			my_redirect('privilege.php?act=register','注册失败！','正在为您重新跳转到注册页面！');	
		}
		
	}elseif($act == 'captcha'){
	
		$captcha = new Captcha();
		header('content-type:image/png');
		$captcha->generate();
	}elseif($act == 'check'){
		
		//接受注册表单数据
		$username = trim($_POST['userName']);
		$password = trim($_POST['passWord']);
		$captcha = trim($_POST['veryCode']);

		//合法性判断
		//验证码合法性判断
		if(empty($captcha)){
		
			my_redirect('privilege.php?act=login','验证码不能为空！','正在为您重新跳转到页面登陆');
		}
		//数据合法性判断
		if(empty($username) || empty($username)){
			
			//跳转
			my_redirect('privilege.php?act=login','用户名或密码不能为空！','正在为您重新跳转到登陆页面');
		}
		
		//合理性判断
		if(!Captcha::checkCaptcha($captcha)){

			my_redirect('privilege.php?act=login','验证码错误！','正在为您重新跳转到登陆页面');
		}
		$user = new User();
		if($users = $user->getUserByUsername($username)){

			//用户名存在
			if(md5('yimai'.$password) === $users['u_password']){

				//密码正确
				//将用户信息写入session
				@session_start();
				$_SESSION['user_id'] = $users['id'];
				if(!isset($_SESSION['uri'])){
					my_redirect('index.php?act=view&id=2','登陆成功！','正在为您重新跳转到首页！',1000);
				}else{
					my_redirect("$_SESSION[uri]",'登陆成功！','正在为您重新跳转到易买网！',1000);
				}

			}else{	
				//密码错误
				my_redirect('privilege.php?act=login','密码错误！','正在为您重新跳转到登陆页面！');

			}

		}else{
			//用户名不存在
			my_redirect('privilege.php?act=login','该用户名不存在！','正在为您重新跳转到登陆页面！');

		}

		
	}