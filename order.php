<?php

	//订单
	
	//接收用户动作
	$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'add';

	//加载前台初始化文件
	include_once './includes/init.php';

	//判断用户是否登陆
	if(!isset($_SESSION['user_id'])){
		my_redirect('privilege.php','请先登陆！','正在为您跳转到登陆页面！');
	}

	//判断用户动作，处理用户动作
	if($act == 'add'){
		
		//显示购物车里面商品信息
		$goods_id = $_GET['goods_id'];
		$cart = new cart();
		$cartGoods = $cart->getCartGoodsByGoodsId($goods_id);
	
		$_SESSION['orderGoods'] = $cartGoods;
			//var_dump($_SESSION['orderGoods']);exit;
	
		//var_dump($_SESSION['orderGoods'][$_GET['goods_id']]);exit;
		include_once YIMAI_TEMP.'order.html';

	}elseif($act == 'insert'){

		$goods_id = $_POST['goods_id'];

		$_info['i_name'] = trim($_POST['name']);
		$_info['i_address'] = trim($_POST['province']).trim($_POST['city']).trim($_POST['county']).trim($_POST['address']);
		$_info['i_phone'] = trim($_POST['phone']);
		$_goods['o_comment'] = trim($_POST['comment']);
		$_info['u_id']= $_SESSION['user_id'];
		$totals = $_POST['totalPrice'];
	
		//合法性判断
		if(empty($_info['i_name'])){

			my_redirect("order.php?goods_id={$goods_id}",'接收人姓名不能为空！','正在为您跳转到订单页面！');
		}
		if(empty($_info['i_address'])){

			my_redirect("order.php?goods_id={$goods_id}",'接收人地址不能为空！','正在为您跳转到订单页面！');
		}
		if(empty($_info['i_phone'])){

			my_redirect("order.php?goods_id={$goods_id}",'接收人电话不能为空！','正在为您跳转到订单页面！');
		}
		
		if(strlen($_info['i_phone']) != 11){
			my_redirect("order.php?goods_id={$goods_id}",'电话号码长度必须为11位！','正在为您跳转到订单页面！');
		}

		//获取订单详情对象
		$orderInfo = new OrderInfo();
		$orderNumber = $orderInfo->getOrderNumber();
		$_info['i_number'] = $orderNumber;

		//订单详情插入订单表内
		//$_SESSION['order_goods']['o_id'] = $orderInfo->insertOrderInfo($_info);
		if($order_id = $orderInfo->insertOrderInfo($_info)){

			//将订单内商品信息插入订单商品表
			//var_dump($_SESSION['orderGoods']);exit;
			$order_goods = new OrderGoods();
			$_goods['o_id']     = $order_id;
			$_goods['g_id']     = $_SESSION['orderGoods']['g_id'];
			$_goods['g_code']   = $_SESSION['orderGoods']['g_code'];
			$_goods['o_name']   = $_SESSION['orderGoods']['c_name'];
			$_goods['o_price']  = $_SESSION['orderGoods']['c_price'];
			$_goods['o_number'] = $_SESSION['orderGoods']['c_number'];
			
			//往订单商品表添加商品
			if($order_goods->insertOrderGoods($_goods)){

				$_SESSION['totalPrice']  = $totals;
				$_SESSION['orderNumber'] = $orderNumber;
				$_SESSION['orderId']     = $order_id;

				my_redirect("order.php?act=pay&orderId={$order_id}",'生成订单成功！','正在为您跳转到支付页面！');
			}

		}else{	

			my_redirect('order.php','生成订单失败！','正在为您跳转到订单页面！');

		}

  }elseif($act == 'pay'){
  
		//$orderId = $_GET['orderId'];
		//加载支付模板
		include_once YIMAI_TEMP . 'pay.html';

  }elseif($act == 'success'){
		
		//将订单里面的商品从购物车里面删除
		$orderGoods = new OrderGoods();
		$goods_id = $orderGoods->getOrderGoodsIdByOrderId($_SESSION['orderId']);

		foreach($goods_id as $id){

			$cart = new Cart();
			$cart->deleteCartGoodsByUserIdAndGoodsId($id['g_id']);	
		}
		$orderGoods->updateOrderGoodsByOrderId($_SESSION['orderId']);
		//加载成功模板
		include_once YIMAI_TEMP . 'shopping-result.html';
  }