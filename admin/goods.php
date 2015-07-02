<?php
	//商品管理

	//获取动作
	$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'product';

	//加载初始化文件
	include_once 'includes/init.php';

	//判断动作
	if($act == 'product'){
		//商品列表
		//可通过外部调用方法的时候传入对应的页码参数
		//$page = 2;
		//接收page
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$pagecount = $config['admin_goods_pagecount'];

		//获取所有的商品
		$goods = new Goods();

		//获取当前数据的总记录数
		$counts = $goods->getCounts();

		//判断当前页码是否合理
		$pages = ceil($counts / $pagecount);
		if(!is_numeric($page) || $page > $pages || $page < 1){
			//不合理：给出初始化结果（默认值）
			$page = 1;
		}	
		//分页获取数据
		$product = $goods->getAllGoods($pagecount,$page);

		//获取分页字符串
		$page_str = Page::getPageString('goods.php','product',$counts,$pagecount,$page);


		//加载显示模板
		include_once ADMIN_TEMP . 'product.html';

	}elseif($act == 'add'){
		//新增商品

		//获取商品分类
		$category = new Product;
		$categories = $category->getProduct();
		//加载表单
		include_once ADMIN_TEMP . 'product-add.html';
		
	}elseif($act == 'modify') {
		//修改商品
		$id = $_GET['id'];
		//获取商品分类
		$category = new Product;
		$categories = $category->getProduct();

		$goods = new Goods();
		$goodss = $goods->getOne($id);
		//var_dump($goodss);exit;
  
		include_once ADMIN_TEMP . 'product-modify.html';

	}elseif($act == 'delete'){
		//删除商品
		$id = $_GET['id'];

		$goods = new Goods();
		
		if($goods->GoodsByDelete($id)){
			//成功
			ym_manage('goods.php','商品删除成功！');
		}else{
			//失败
			ym_manage('goods.php?act=product','商品删除失败！');
		}

		//include_once ADMIN_TEMP . 'product.html';

	}elseif($act == 'insert'){
		//新增商品入库
		
		//接收数据：使用数组接收
		$_goods['g_name'] 		= trim($_POST['goods_name']);        //商品名字
		$_goods['c_id'] 		= trim($_POST['category_id']);        //商品分类id

		//用户提交
		$_goods['g_image'] 		= '';    //用户提交
		$_goods['g_thumb'] 		= '';    //系统生成
		$_goods['g_water'] 		= '';

		$_goods['g_price'] 		= trim($_POST['goods_price']);        //商品价格
		$_goods['g_inv'] 		= trim($_POST['goods_inv']);        //商品库存
		$_goods['g_brand'] 		= trim($_POST['goods_brand']);        //商品品牌
		$_goods['g_code'] 		= trim($_POST['goods_code']);        //商品条码号
		
		//var_dump($_POST['goods_price']);
		// var_dump($_goods['g_price']);

		//合法性验证
		if (empty($_goods['g_name'])) {
			ym_manage('goods.php?act=add', '商品名称不能为空！');
		}

		if (empty($_goods['g_name']) > 40) {
			ym_manage('goods.php?act=add', '商品名称过长，不能超过20个字符');
		}

		//价格验证
		if (!is_numeric($_goods['g_price'])) {
			ym_manage('goods.php?act=add', '商品价格必须是数值！');
		}

		//库存验证
		if(!is_numeric($_goods['g_inv']) || $_goods['g_inv'] < 0) {
			ym_manage('goods.php?act=add', '商品库存必须是大于0的整数！');
		}
			//商品分类验证
			if ($_goods['c_id'] == 0) {
				ym_manage('goods.php?act=add', '必须选择所属商品分类！');
			}

		//合理性验证
		$goods = new Goods();

		//var_dump($_goods['g_code']);exit;
			if(!empty($_goods['g_code'])){
				//用户提交了商品条码号：条码号验证
				if(strlen($_goods['g_code']) !=8 || substr($_goods['g_code'],0,2) !== 'YM' || !is_numeric(substr($_goods['g_code'],3))){
					ym_manage('goods.php?act=add','商品货号不符合书写规则，规则是：YM+6位数字！');
				}

				if($goods->checkCode($_goods['g_code'])){
					//条码号已经存在
					
					ym_manage('goods.php?act=add','当前货号：' . $_goods['g_code'] . '已经存在！');
				}

			}else{
				//用户没有输入条码号：系统自动增加
				$_goods['g_code'] = $goods->generateCode();
			}

			//使用文件上传
			if($filename= Upload::uploadSingle($_FILES['g_image'],ADMIN_UPLO,$config['admin_goods_mime'])){
				//文件上传成功
				$_goods['g_image'] = $filename;

			//制作缩略图
			$image = new Image();
			if($thumb_file = $image->getThumb(ADMIN_UPLO . $filename,ADMIN_UPLO)){
				//成功
				$_goods['g_thumb'] = $thumb_file;

			}else{
				//错误：跟用户无关：记录到系统日志
				}
			}
         // var_dump($_goods['g_price']);exit;
			//判断插入数据库
			if($goods->insertGoods($_goods)){
				//插入成功：不代表文件上传成功
				if(Upload :: $error){
					//文件上传失败
					ym_manage('goods.php?act=product','商品新增成功！但是文件上传失败，原因是：'.Upload :: $error,3);
				}else{
					//文件上传成功
					ym_manage('goods.php','商品新增成功！',3);
				}
			}else{
				//插入失败
				ym_manage('goods.php?act=add','新增商品失败！',3);
			}
	}elseif($act == 'update'){
		
		$id = $_POST['id'];
		//接收数据：使用数组接收
		$_goods['g_name'] 		= trim($_POST['goods_name']);        //商品名字
		$_goods['c_id'] 		= trim($_POST['category_id']);        //商品分类id

	
		$_goods['g_price'] 		= trim($_POST['goods_price']);        //商品价格
		$_goods['g_inv'] 		= trim($_POST['goods_inv']);        //商品库存
		$_goods['g_brand'] 		= trim($_POST['goods_brand']);        //商品品牌
		
		//合法性验证
		if (empty($_goods['g_name'])) {
			ym_manage("goods.php?act=modify&id={$id}", '商品名称不能为空！');
		}

		if (empty($_goods['g_name']) > 40) {
			ym_manage("goods.php?act=modify&id={$id}", '商品名称过长，不能超过20个字符');
		}

		//价格验证
		if (!is_numeric($_goods['g_price'])) {
			ym_manage("goods.php?act=modify&id={$id}", '商品价格必须是数值！');
		}

		//库存验证
		if(!is_numeric($_goods['g_inv']) || $_goods['g_inv'] < 0) {
			ym_manage("goods.php?act=modify&id={$id}", '商品库存必须是大于0的整数！');
		}
			//商品分类验证
			if ($_goods['c_id'] == 0) {
				ym_manage("goods.php?act=modify&id={$id}", '必须选择所属商品分类！');
			}

		//合理性验证
		$goods = new Goods();

		//var_dump($_goods['g_code']);exit;
		
			
         // var_dump($_goods['g_price']);exit;
			//判断插入数据库
			if($goods->updateGoodsById($id,$_goods)){
				//成功：
				ym_manage("goods.php", '商品修改成功！');
			}else{
				//失败
				ym_manage("goods.php?act=modify&id={$id}", '商品修改失败！');
			}
		}
