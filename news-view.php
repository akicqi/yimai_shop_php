<?php
//前台新闻展示
    $act=isset($_REQUEST['act'])?$_REQUEST['act']:'list';
 //加载初始化文件
  include_once 'includes/init.php';
   if($act=='list'){
	 //获取列表
   $news=new News();

   $lists=$news->AllList();
     var_dump($lists);exit;
   include_once YIMAI_TEMP .'index.html';
   }elseif($act='view'){
	   //获取列表id
     $id=$_GET['id'];
      //获取所有的列表
	 $news=new News();
	 $lists=$news->AllList();
      

	 //通过id获取到单条记录
     $content=$news->OneList($id);
	 
	 //在线编辑器转码
	 //htmlspecialchars_decode($content['n_content']);
    //加载模板
	 include_once YIMAI_TEMP.'News-view.html';
   } 