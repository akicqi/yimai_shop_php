<?php
	//后台留言管理
	$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'list';
	//加载配置文件
	include_once './includes/init.php';
	//后台用户管理
	if($act == 'list'){
		$user = new Users();
		$res = $user->getAllUser();

		//加载公共文件
		include_once ADMIN_TEMP . 'user.html';
	}else if($act == 'edit'){
		//接受要修改的用户id
		$id = $_GET['id'];
		$_SESSION['id'] = $id;
		//通过id获取用户信息
		$user = new Users();
		$res = $user->getUserInfoById($id);
		//加载模版
		include_once ADMIN_TEMP . 'user-modify.html';
	}else if($act == 'update'){
		//var_dump($_FILES);exit;
		$id = $_POST['id'];
		$_SESSION['id'] = $id;
		$_user['id'] = $id;
		//$_goods['g_name']		= trim($_POST['goods_name']);
		$_user['u_username'] = trim($_POST['userName']);
		$_user['u_name'] = trim($_POST['name']);
		$_user['u_sex'] = trim($_POST['sex']);
		$_user['u_address'] = trim($_POST['address']);
		$_user['u_number'] = trim($_POST['mobile']);
		$_user['u_email'] = trim($_POST['email']);
		$_user['u_headportrait'] = '';
		$by = $_POST['birthyear'];
		$bm = str_pad($_POST['birthmonth'],2,'0',STR_PAD_LEFT);
		$bd = $_POST['birthday'];
		$_user['u_time'] = $by . $bm . $bd;
		//var_dump($_user);exit;
		if(empty($_user['u_username'])){
			admin_redirect('用户名不能为空',"user.php?act=edit&id={$_SESSION['id']}");
		}
		if(empty($_user['u_name'])){
			admin_redirect('姓名不能为空',"user.php?act=edit&id={$_SESSION['id']}");
		}
		//邮件唯一
		$user = new Users();
		if($user->getUserEmail($_user['u_email'])){
			admin_redirect('此邮件已经存在',"user.php?act=edit&id={$_SESSION['id']}");
		}
		
		//使用文件上传
		if($filename = Upload::uploadSingle($_FILES['photo'],ADMIN_UPLO,$config['admin_goods_mime'])){
			//文件上传成功
			$_user['u_headportrait'] = $filename;
		}
		//入库
		
		if($user->updateUserInfoById($id,$_user)){
			admin_redirect('成功',"user.php");
		}else{
			admin_redirect('失败',"user.php?act=edit&id={$_SESSION['id']}");
		}
	}else if($act == 'delete'){
		$id = $_GET['id'];
		$user = new Users;
		if($user->deleteUserById($id)){
			//成功
			admin_redirect('删除成功','user.php');
		}else{
			//失败
			admin_redirect('删除失败','user.php');
		}
	}else if($act == 'add'){
		
		//加载模版
		include_once ADMIN_TEMP . 'user-add.html';
	}else if($act == 'insert'){
		//var_dump($_FILES);exit;
		$_user['u_username'] = trim($_POST['userName']);
		$_user['u_name'] = trim($_POST['name']);
		$_user['u_sex'] = trim($_POST['sex']);
		$_user['u_address'] = trim($_POST['address']);
		$_user['u_number'] = trim($_POST['mobile']);
		$_user['u_email'] = trim($_POST['email']);
		$_user['u_headportrait'] = '';
		$by = $_POST['birthyear'];
		$bm = str_pad($_POST['birthmonth'],2,'0',STR_PAD_LEFT);
		$bd = $_POST['birthday'];
		$_user['u_time'] = $by . $bm . $bd;
		if(empty($_user['u_username'])){
			admin_redirect('用户名不能为空',"user.php?act=add");
		}
		if(empty($_user['u_name'])){
			admin_redirect('姓名不能为空',"user.php?act=add");
		}
		if(empty($_user['u_number'])){
			admin_redirect('手机号码不能为空',"user.php?act=add");
		}
		if(empty($_user['u_address'])){
			admin_redirect('地址不能为空',"user.php?act=add");
		}
		$user = new Users;
		if($user->getUserEmail($_user['u_email'])){
			admin_redirect('此邮件已经存在',"user.php?act=edit&id={$_SESSION['id']}");
		}
		//使用文件上传
		if($filename = Upload::uploadSingle($_FILES['photo'],ADMIN_UPLO,$config['admin_goods_mime'])){
			//文件上传成功
			$_user['u_headportrait'] = $filename;
		}
		//入库
		if($user->insertUserInfo($_user)){
			admin_redirect('成功','user.php');
		}else{
			admin_redirect('失败','user.php?act=add');
		}
	}
?>