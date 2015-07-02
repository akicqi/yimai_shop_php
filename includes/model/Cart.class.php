<?php

	//购物车功能

	class Cart extends MyPDO{
		
		protected $table = 'cart';
		
		/*
		 * 添加商品到购物车
		 * @parameter1 int goods_id 购物车里的商品ID
		 * return 返回自增长ID或false
		 */
		public function replaceGoodsToCart($goods_id){
			
			$user_id = $_SESSION['user_id'];
			//判断购物车里是否有该商品		
			if($cartGoods = $this->getCartGoodsByUserIdAndGoodsId($goods_id)){

				$c_number = $cartGoods['c_number'] + 1;

			}else{
				
				$c_number = 1;	  
			}
			//购物车里面没有该商品
			//获取商品信息
			$goods = new Goods();
			$oneGoods = $goods->getGoodsById($goods_id);

			$sessionID = session_id();
			$c_name = $oneGoods['g_name'];
			$c_price = $oneGoods['g_price'];
			$g_code  = $oneGoods['g_code'];
		
			$sql = "replace into {$this->getTableName()} values('{$user_id}',{$goods_id},'{$sessionID}','{$c_name}','{$c_price}','{$c_number}','{$g_code}')";

			return $this->db_insert($sql);
			
		}

		/*
		 * 通过用户ID显示购物车商品
		 * @parameter1 int @user_id 登陆用的ID
		 * @paremeter2 int @goods_id = 0 
		 * return 返回数组或者false
		 */
		public function getCartGoodsByUserId(){

			$user_id = $_SESSION['user_id'];
		
			$sql = "select * from {$this->getTableName()} where u_id = '{$user_id}'";
			return $this->db_getAll($sql);
		}

		/*
		 * 通过用户ID和购物车商品ID查询商品
		 */
		public function getCartGoodsByUserIdAndGoodsId($goods_id){

			$user_id = $_SESSION['user_id'];
		
			$sql = "select * from {$this->getTableName()} where u_id = '{$user_id}' and g_id = '{$goods_id}'";
			return $this->db_getOne($sql);
		}

		/*
		 * 通过商品ID删除购物车商品
		 * @parameter1 int $goods_id 要删除的购物车商品的id
		 * return 返回受影响行数或者false
		 */
	    public function deleteCartGoodsByUserIdAndGoodsId($goods_id){
		
			$user_id = $_SESSION['user_id'];
			$sql = "delete from {$this->getTableName()} where u_id = '{$user_id}' and g_id = '{$goods_id}'";

			return $this->db_delete_update($sql);
		}

		//通过商品id获取商品信息
		public function getCartGoodsByGoodsId($goods_id){
			
			$user_id = $_SESSION['user_id'];
			$sql = "select * from {$this->getTableName()} where u_id = '{$user_id}' and  g_id = '{$goods_id}'";
			return $this->db_getOne($sql);
		}
	}