<?php
	
	//订单商品类
	class OrderGoods extends MyPDO{

		//属性:表名
		protected $table = 'order_goods';
		
		//订单商品表插入数据
		public function insertOrderGoods($_goods){
		
			//定义两个空字符串
			$fields = $values = '';
			foreach($_goods as $k => $v){
			
				$fields .= $k . ',';
				$values .= '\'' . $v . '\',';
			}
			
			//去掉最后一个逗号
			$fields = rtrim($fields,',');
			$values = rtrim($values,',');

			//SQL语句
			$sql = "insert into {$this->getTableName()}({$fields}) values({$values})";
			return $this->db_insert($sql);
		}

		/*
		 * 通过订单ID获取商品ID
		 * @parameter1 int $id 要获取的商品的ID
		 * @return 成功返回一个二维数组失败返回false
		 */
		 public function getOrderGoodsIdByOrderId($id){
		 
			//SQL
			$sql = "select g_id from {$this->getTableName()} where o_id = '{$id}'";
			return $this->db_getAll($sql);
		 }

		 /*
		  * 修改是否支付字段
		  * @parameter1 int $order_id 订单id
		  * @return 成功返回受影响的行数
		  */
		 public function updateOrderGoodsByOrderId($order_id){
			
			$sql = "update {$this->getTableName()} set o_is_pay = '1' where o_id = '{$order_id}'";
			return $this->db_delete_update($sql); 
		 }
	}