<?php
 //商品分类管理

  //接收用户的动作请求
   $act=isset($_REQUEST['act'])?$_REQUEST['act']:'list';
  
  //加载初始化文件
    include_once 'includes/init.php';

   if($act=='list'){
	   
     //查看所有的商品分类列表
	 $product = new Product();
	 $products=$product ->getProduct();
	 //加载模板
	 include_once ADMIN_TEMP.'productClass.html';
    }elseif($act=='add'){
     //查看所有的商品分类列表
	 $product = new Product();
	 $products=$product ->getProduct();
     
	 //加载模板
	 include_once ADMIN_TEMP .'productClass-add.html';
	}elseif($act=='insert'){
	 //新增商品入库
	 $c_name=trim($_POST['className']);
	 $c_parent_id=trim($_POST['parentId']);
		
	    //合法性验证
	   if(empty($c_name)){
	     //如果为空，跳转到添加页面
	     redirect('productClass.php?act=add','分类名不能为空!');
	     }
		
	 
	     //合理性验证
	     $product = new Product();
	    //同一分类下不能有相同的分类名
	   if($product->CheckParentIdAndName($c_name,$c_parent_id)){
	     //存在:自动警告
		 redirect('productClass.php?act=add','分类名:'. $c_name . '重复');
	    }

         //插入数据
		if($product ->InsertProduct($c_name,$c_parent_id)){
		  //插入成功
		  redirect('productClass.php','商品插入成功',1000);
		}else{
		 //插入失败
		 redirect('productClass.php?act=add','商品插入失败');
		}
		   
	   
	}elseif($act=='delete'){
	     //接收用户id
	    $id=$_GET['id'];
		
        $product = new Product();

	     //此分类不是叶子节点
	    if($product->IsNoleaf($id)){
		  //不是叶子节点,不能删除分类
		  redirect('productClass.php','当前分类下还存在分类,不允许直接删除');
		}
	      
	     //判读节点下的分类是否存在商品关联
		if($product->HasGoods($id)){
		   //存在商品 ,不允许删除
		 redirect('productClass.php','当前分类下还存在商品,不允许直接删除');
		}
			
		 //删除商品分类
		if($product->DeletePreductId($id)){
		 redirect('productClass.php','删除成功',1000);
		}
	       
	}elseif($act=='edit'){
		//编辑分类信息
	     //接收用户id
	     $id=$_GET['id'];

         $product = new Product();
		 $pro=$product ->getProductById($id);
      

		//获取 商品分类信息 
		 $products=$product ->getProduct();
		 
	     //加载模板 
	     include_once ADMIN_TEMP . "productClass-modify.html";
	}elseif($act=='update'){
		 //更新商品分类
		$id=$_GET['id'];
		    
	     //获取用户提交的数据
	     $c_name=trim($_POST['className']);
	     $c_parent_id=trim($_POST['parentId']);
		
	    //合法性判断
		 //合法性验证
	   if(empty($c_name)){
	     //如果为空，跳转到添加页面
	     redirect('productClass.php?act=edit','分类名不能为空!');
	     }
		
	
	 
	     //合理性验证
	     $product = new Product();
	    //同一分类下不能有相同的分类名
	   if($product->CheckParentIdAndName($c_name,$c_parent_id)){
	     //存在:自动警告
		 redirect('productClass.php?act=edit','分类名:'. $c_name . '重复');
	    }

		//更新分类数据
	    if($res=$product->UpdateProductById($id,$c_name,$c_parent_id)){

			//成功更新数据

		 redirect('productClass.php','更新商品成功',1000);
		}else{
		
		  //更新失败
		  redirect('productClass.php'.$id,'更新商品失败');
		}

	}