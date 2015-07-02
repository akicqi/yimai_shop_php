<?php
   //前台留言显示

   //接收动作
   $act=isset($_REQUEST['act']) ? $_REQUEST['act'] : 'list';
   //加载初始化文件
   include_once 'includes/init.php';

   //判断动作
   if($act=='list'){
        //前台留言列表

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
		//获取分页字符串
	    $page_str=Page::getPageString('guestbooks.php','list',$counts,$page,$pagecount);

		//加载前台留言界面
		include_once YIMAI_TEMP . 'guestbook.html';

   }elseif($act=='insert'){   
	   //留言入库
	   $g_name=$_REQUEST['guestName'];	   
	   $g_send_message=$_REQUEST['guestTitle'];	   
	   $g_send_text=$_REQUEST['guestContent'];
	   //var_dump($g_send_message,$g_send_text);exit;

	   if(empty($g_send_message) || empty($g_send_text)){
	       my_redirect('guestbooks.php','留言标题或内容不能为空！','正在为您跳转到留言板');
	   } 

	   $guestbook=new Guestbook();
	   if($guestbook->insertMessage($g_name,$g_send_message,$g_send_text)){
		 
			//留言成功
			my_redirect('guestbooks.php','留言成功！','正在为您跳转到留言板',1000);
		}else{
		    //留言失败
			my_redirect('guestbooks.php','留言失败！','正在为您跳转到留言板');
		}
   
   }

?>