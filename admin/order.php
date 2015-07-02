<?php

	//后台订单管理文件

	//接受用户动作
	$act = isset($_REQUEST['act']) ?  $_REQUEST['act'] : 'list';

	//加载公共文件
	include_once './includes/init.php';

	//判断动作，处理动作
	if($act == 'list'){
		
		//接受商品列表显示页码
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$pagecount = $config['admin_order_pagecount'];
		//获取该类商品的总记录数
		$order = new Order();
		$counts = $order->getOrderCounts()['c'];
		$pages = ceil($counts / $pagecount);
		//对用户传递$page进行判断
		if(!is_numeric($page) || $page > $pages || $page < 1){
			$page=1;
		}
		
		//获取记录
		$list = $order->getAllOrder($page,$pagecount);

		//获取分页链接
		$pageString = Page::getPageString('order.php','list',$counts,$pagecount,$page);
		//加载订单模板
		include_once ADMIN_TEMP . 'order.html';

	}elseif($act == 'delete'){
	
		$id = $_GET['id'];
		$order = new Order();
		if($order->deleteOrderById($id)){

			redirect('order.php','删除订单成功！',1000);
			
		}else{
			
			redirect('order.php','删除订单失败！');
		}

	}elseif($act == 'check'){
	
		$id = $_GET['id'];
		$order = new Order();
		if($order->updateOrderById($id)){
		
			redirect('order.php','订单审核通过！',1000);

		}else{

			redirect('order.php','订单审核失败！');
		}

	}

