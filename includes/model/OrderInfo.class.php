<?php

	//订单信息类
	class OrderInfo extends MyPDO{
	
		//属性：表名
		protected $table = 'order_info';
		
		//生成订单号
		public function getOrderNumber(){
			
			//取出当前订单表中的最大订单号
			$sql = "select count(*) as c from {$this->getTableName()} order by i_number desc limit 1";
			if(!$number = $this->db_getOne($sql)){

				return '0000000000';
			
			}else{
				$number = $number['c'] + 1;
				return str_pad($number,10,'0',STR_PAD_LEFT);
			}
		
		}

		//将订单信息插入表单
		 public function insertOrderInfo($_info){
		 
			//定义两个空字符串
			$fields = $values = '';
			foreach($_info as $k => $v){
			
				$fields .= $k . ',';
				$values .= '\'' . $v . '\',';
			}
			$fields = rtrim($fields,',');
			$values = rtrim($values,',');

			//SQL语句
			$sql = "insert into {$this->getTableName()}({$fields}) values({$values})";
			return $this->db_insert($sql);
		 }

	}