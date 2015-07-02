<?php

	//订单管理类
	class Order extends MyPDO{
	
		//属性：表名
		protected $table = 'order_info';
		
		//获取订单表内所有记录总数
		public function getOrderCounts(){

			$sql = "select count(*) as c from {$this->getTableName()}";
			return $this->db_getOne($sql);
		}
		//查询所有订单
		public function getAllOrder($page,$pagecount){

			//获取$offset
			$offset = ($page - 1) * $pagecount;
			//SQL
			$sql = "select * from {$this->getTableName()} limit {$offset},{$pagecount}";
			return $this->db_getAll($sql);
		
		}
		//通过订单ID删除订单
		public function deleteOrderById($id){
			
			$sql = "delete from {$this->getTableName()} where id = '{$id}'";
			return $this->db_delete_update($sql);
		}
		//通过订单ID更新订单
		public function updateOrderById($id){
		
			$sql = "update {$this->getTableName()} set status = 1 where id = '{$id}' ";
			return $this->db_delete_update($sql);
		}
	}