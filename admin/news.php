<?php

// 新闻管理

  $act = isset($_REQUEST['act'])?$_REQUEST['act']:'newslist';

  //加载初始化文件
   include_once  'includes/init.php';

  if($act=='newslist'){
    //获取新闻信息
	 $news=new News();

	 $values=$news->AllNews();
    
     //加载模板
    include_once ADMIN_TEMP . 'news.html';
  }elseif($act=='add'){
       //获取新闻
	   $news=new News();
	   $news->AllNews();

     //加载模板
	include_once ADMIN_TEMP . 'news-add.html';
  }elseif($act=='insert'){
 
    //接收表单数据
	 $title=$_POST['title'];
	 $content=$_POST['content'];
	
	     //合法性判断
	    if(empty($title)){
	     redirect('news.php?act=add','新闻标题不能为空!');
	     }
		
	 
	    if(strlen($title) > 60){
	     redirect('news.php?act=add','新闻标题超出允许最大的长度约20个汉字!');
	    }

	    if(empty( $content)){
	     redirect('news.php?act=add','新闻内容不能为空!');
	    }

	     //插入数据
	     $news=new News();
		 //转码:因为用了在线编辑器
	    // $content=htmlspecialchars($content);
	   if($news->InsertNews($title,$content)){
	     //成功
	     redirect('news.php', '新闻插入成功!');
	    }else{
	     redirect('news.php?act=add', '新闻插入失败!');
	    }

    }elseif($act=='delete'){
        //接收id
	     $id=$_GET['id'];
	   
	     $news=new News();
	    if($news->DeleteNews($id)){
	     //删除成功
		 redirect('news.php', '删除成功!');
	    }else{
		 //删除成功
		 redirect('news.php', '删除失败!');
		}

    }elseif($act=='edit'){
		//获取新闻id
        $id=$_GET['id'];
        $news=new News();
        $values=$news->GetOneNews($id);
     
	   //加载模板
	 include_once ADMIN_TEMP .'news-modify.html';
	}elseif($act=='update'){
         $id=$_POST['id'];
		
	     //接收表单数据
	     $title=$_POST['title'];
	     $content=$_POST['content'];
	     //合法性判断
	    if(empty($title)){
	     redirect('news.php?act=add','新闻标题不能为空!');
	     }
		
	 
	    if(strlen($title) > 60){
	     redirect('news.php?act=add','新闻标题超出允许最大的长度约20个汉字!');
        }

		 if(empty( $content)){
	     redirect('news.php?act=add','新闻内容不能为空!');
	    }

	     //插入数据
	     $news=new News();
		 //转码:因为用了在线编辑器
	   // $content=htmlspecialchars($content);
	   if($news->UpdateNews($id,$title,$content)){
	     //成功
	     redirect('news.php', '新闻更新成功!');
	    }else{
	     redirect('news.php?act=add', '新闻更新失败!');
	    }
	}