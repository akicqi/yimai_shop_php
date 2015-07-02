<?php
  
  //后台留言表权限管理脚本
  
  //获取动作
  $act=isset($_REQUEST['act']) ? $_REQUEST['act'] : 'list';
  //加载初始化文件
  include_once './includes/init.php';
  
  
  //判断动作
  if($act=='list'){
	  //留言列表
	  
	  //接收page页码（GET传递）
	  $page=isset($_GET['page']) ? $_GET['page'] : 1;


	  //获取所有留言
	  $guestbook=new Guestbook();
	  $pagecount=$config['guestbook_page'];
	  //分页数据获取
	  $list=$guestbook->getAllMessage($pagecount,$page);
	
	  //获取当前总留言数量
	  $counts=$guestbook->getCounts();


	  //计算当前显示留言数
	  $pages = ceil($counts / $config['guestbook_page']);

	  //判断页码合理性
	  //if(!is_numeric($page) || $page>$pages || $page<1){
			//$page=1;		
	  //}

	  //获取分页字符串
	  $page_str=Page::getPageString('guestbook.php','list',$counts,$pagecount,$page);

	  //加载留言表页面
	  include_once ADMIN_TEMP . 'guestbook.html';
  
  }elseif($act=='delete'){
	  //删除留言
	  $id=$_GET['id'];
	  $guestbook=new Guestbook();
	  //判断执行结果
	  if($guestbook->deleteMessage($id)){
		  //成功：加载留言管理页面
		  admin_redirect('留言删除成功','guestbook.php'); 
	  }else{
	      //失败
		  admin_redirect('留言删除失败','guestbook.php');
	  }
  
  }elseif($act=='replay'){
	  //回覆留言，加載回覆留言板
	  $id=$_GET['id'];
	  $guestbook=new Guestbook();
      $list=$guestbook->getMessageById($id);
	  include_once ADMIN_TEMP . 'guestbook-modify.html';

  }elseif($act=='update'){

	  $g_text_replay=$_GET['replyContent'];
	  //留言回复
	  $id=$_GET['id'];
	  $guestbook=new Guestbook();
	  //判斷
	  if($guestbook->updateReplay($id,$g_text_replay)){
		 
			  //回复成功
	          admin_redirect('guestbook.php','回复留言成功');

	 }else{
		      //回复失败
	          admin_redirect('guestbook.php','回复留言失败');
	 }
	          
      
  }
