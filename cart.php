<?php

	//商品购买
	
	//接受用户动作
	$act = isset($_REQUEST['act']) ? $_REQUEST['act'] :'cart';

	//加载初始化文件
	include_once "./includes/init.php";
	
	//判断动作，处理动作
	if($act == 'cart'){
		
		//判断用户是否登陆过
		if(!isset($_SESSION['user_id'])){
			my_redirect('privilege.php','请先登陆！','正在为您跳转到登陆页面！');
		}
		
		$cart = new Cart();
		if(!$cartList = $cart->getCartGoodsByUserId()){

			my_redirect('index.php','对不起，您的购物车里面没有商品！','正在为您跳转到首页！');
		}

		//加载购物车模板
		include_once YIMAI_TEMP.'shopping.html';

	}elseif($act == 'add'){

		//将商品加入购物车
		//判断是否登陆
		if(!isset($_SESSION['user_id'])){
			//未登陆
			my_redirect('privilege.php','请先登陆！','正在为您跳转到登陆页面！');
		}
		
		$goods_id = $_GET['id'];

		$cart = new Cart();
	    $cart->replaceGoodsToCart($goods_id);
		
		//取出购物车数据放入$_SESSION中
		if(!$cartList =  $cart->getCartGoodsByUserId($_SESSION['user_id'])){
		
			my_redirect('index.php','获取购物车商品失败！','请重新获取');
		}

		//加载购物车模板
		include_once YIMAI_TEMP.'shopping.html';

	}elseif($act == 'replace'){
		
		//将商品加入购物车
		//判断是否登陆
		if(!isset($_SESSION['user_id'])){
			//未登陆
			my_redirect('privilege.php','请先登陆！','正在为您跳转到登陆页面！');
		}
		
		$goods_id = $_GET['id'];
		$user_id = $_SESSION['user_id'];

		$cart = new Cart();
		$cart-> replaceGoodsToCart($goods_id);
		
		if(!$cartList =  $cart->getCartGoodsByUserId()){
		
			my_redirect('index.php','获取购物车商品失败','请重新获取！');
		}
	
		//获取商品详情
		$goods = new Goods();
		$oneGoods = $goods->getGoodsById($goods_id);
		//加载购物车模板
		include_once YIMAI_TEMP.'goods_view.html';

	}elseif($act == 'delete'){

		$goods_id = $_GET['goods_id'];

		$cart = new Cart();
		if($cart->deleteCartGoodsByUserIdAndGoodsId($goods_id)){
			//删除成功
			my_redirect('cart.php','删除购物车商品成功！','正在为您重新加载购物车！',1000);
		
		}else{
			//删除失败
			my_redirect('cart.php','删除购物车商品失败！','请在购物车里重新删除！');
		}
	
	}