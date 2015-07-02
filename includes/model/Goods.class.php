<?php

	//商品类

	class Goods extends MyPDO{
	
		//属性
		protected $table = 'goods';

		/*
		 * 查询所有商品
		 * @parameter1 int $length = 99999将查询的结果返回多少条记录
		 * @parameter2 int $is_offer = 0 查询的商品默认不是特价商品
		 * @parameter3 int $is_hot = 0 查询的商品是否为热销商品，默认不是
		 * return 成功返回二维数组失败返回false
		 */
	    public function getGoods($length = 99999,$is_offer = 0,$is_hot = 0){
		
			$sql = "select * from {$this->getTableName()} where g_is_offer = '{$is_offer}' limit $length ";
			return $this->db_getAll($sql);
		}


		/*
		 * 通过商品ID查询商品
		 * @parameter1 int $id 要查询的商品ID
		 * @return 返回一个一维数组或者false
		 */
		public function getGoodsById($id){
		
		
			$sql = "select * from {$this->getTableName()} where id = '{$id}'";
			return $this->db_getOne($sql);
		}

		/*
		 * 通过分类id获取商品
		 * @parameter1 int $c_id 商品的分类id
		 * return 成功返回二维数组，失败返回false
		 */
		public function getGoodsByCartId($c_id,$page,$pagecount){
			
			//获取$offset
			$offset = ($page - 1) * $pagecount;
			//SQL
			$sql = "select * from {$this->getTableName()} where c_id = '{$c_id}' limit {$offset},{$pagecount}";
			return $this->db_getAll($sql);
		}
		
		//通过分类ID获取该类商品的总记录数
		public function getCartGoodsCounts($c_id){
		
			$sql = "select count(*) as c from {$this->getTableName()} where c_id = '{$c_id}'";
			return $this->db_getOne($sql);
		}
	}