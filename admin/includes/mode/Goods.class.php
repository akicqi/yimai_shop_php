<?php
	//商品管理表对应的类

	class Goods extends MyPDO{
		//属性
		protected $table = 'goods';

		/*
		  *获取所有的商品信息
		  *return 成功返回一个二维数组，失败返回一个空数组
		 */ 
		public function getAllGoods($pagecount,$page = 1){

			//计算offset
			$offset = ($page - 1) * $pagecount;
			//SQL
			$sql = "select * from {$this->getTableName()} order by id desc limit {$offset},{$pagecount}";
			
			//执行
			return $this->db_getAll($sql);

		}
		
		/*
		 *查询单个商品信息
		 *成功返回一个数组，失败返回false
		*/
		public function getOne($id){
			//SQL
			$sql = "select * from {$this->getTableName()} where id = '{$id}'";

			//执行
			return $this->db_getOne($sql);
		}

		/*
		 *获取总记录数
		 *要获取的商品
		 *return int 总记录数
		*/
		public function getCounts(){
			//查询SQL
			$sql = "select count(*) as c from {$this->getTableName()}";
		
			//执行
			$res = $this->db_getOne($sql);

			//获取内部数据
			return $res['c'];
		}
	

		/*
		 *更新数据
		 *@param1 int $id 要更新的id 
		 *return 受影响的行数
		*/
		public function updateGoodsById($id,$_goods){
			//SQL
			$sql = "update {$this->getTableName()} set g_name='{$_goods['g_name']}',c_id='{$_goods['c_id']}',g_price='{$_goods['g_price']}',g_inv='{$_goods['g_inv']}',g_brand='{$_goods['g_brand']}' where id = '{$id}'";

			//执行
			return $this->db_delete_update($sql);
		}
	
		/*
		 * 删除商品
		 * @param1 int $id 要删除的id
		 * return 受影响的行数
		 */
		public function GoodsByDelete($id){
			//SQL
			$sql = "delete from {$this->getTableName()} where id = '{$id}'";

			//执行
			//$res = $this->db_delete_update($sql);
			//var_dump($res);exit;		出现异常有可能是火狐浏览器的原因
			return $this->db_delete_update($sql);
		}


		/*
		 * 验证货号
		 * @param1 string $code
		 * return boolean，如果数据库存在返回true，不存在返回false
		 */
		public function checkCode($code){
			//查询SQL
			$sql = "select id from {$this->getTableName()} where g_code = '{$code}'";

			//执行
			return (boolean)$this->db_getOne($sql);
		}

		/*
		 * 验证货号
		 * @return boolean，如果数据库存在返回true，否则返回false
		*/
		public function generateCode(){
			//获取最大的货号
			$sql = "select g_code from {$this->getTableName()} order by g_code desc limit 1";
			$res = $this->db_getOne($sql);

			//判断结果
			if($res){
				$code = $res['g_code'];		//最大货号

				//获取后6位对应的数值
				$last = (integer)substr($code,3);	//字符串=>整型

				$last = $last + 1;
				//填充为一个6位的字符串：右边边补0
				$last = str_pad($last,6,'0',STR_PAD_LEFT);		//6位字符串

				//最终货号
				$new_code = 'YM' . $last;
			}else{
				//没有货号
				$new_code = 'YM000000';
			}
			//返回
			return $new_code; 
		}

		/*
		 *插入数据
		 * @param1 array $data ，包含要插入数据的字段集合（不一定包含全部字段）
		 * @return 成功返回自增id，失败返回false
		 */
		public function insertGoods($_goods){
			//组织insert SQL语句
			//insert into sh_goods字段 values 值列表
			//insert into values（'值1','值2'）
            //var_dump($_goods['g_code']);exit;
			//自动构造字段列表和值列表
			$fields = $values = '';

			//遍历数组
			foreach($_goods as $k => $v){
				//k代表字段名，v代表字段值
				$fields .= $k .',';
				$values .= "'". $v ."',";

			}
			//清除多余的逗号
			$fields = rtrim($fields,',');
			$values = rtrim($values,',');
						
			//组织SQL
			$sql = "insert into {$this->getTableName()} ({$fields}) values({$values})";

			//执行
			return $this->db_insert($sql);
		}

	 }