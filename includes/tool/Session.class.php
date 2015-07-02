<?php

	//session入库工具类

	class Session extends MyPDO{
		
		//属性
		protected $table = 'session';

		//构造方法
		public function __construct(){

			//调用父类的构造方法
			parent::__construct();
			
			//初始化修改sesssion机制
			session_set_save_handler(
				array($this,'sess_open'),
				array($this,'sess_close'),
				array($this,'sess_read'),
				array($this,'sess_write'),
				array($this,'sess_destroy'),
				array($this,'sess_gc')
			);
			
		}

		// session开启 
		public function sess_open(){
		
		}
		// session结束
		public function sess_close(){
	
		}
		// session数据读取
		public function sess_read($id){
			
			
			$expire = time() - ini_get('session.gc_maxlifetime');
			$sql = "select * from {$this->getTableName()} where sess_id = '{$id}' and sess_expire >= {$expire}";
			$row = $this->db_getOne($sql);
			if($row){
				
				return $row['sess_content'];
			}else{

				return '';
			}
		}
		//session数据写
		public function sess_write($id,$content){
		
			$time = time();
			$sql = "replace into {$this->getTableName()} values('{$id}','{$content}','{$time}')";
			return (boolean)$this->db_insert($sql);
		}

		//删除session数据
		public function sess_destroy($id){
		
			$sql = "delete from {$this->getTableName()} where sess_id = '{$id}'";
			return $this->db_delete_update($sql);
		}

		//回收session文件
		public function sess_gc(){
			
			$expire = time() - ini_get('session.gc_maxlifetime');
			$sql = "delete from {$this->getTableName()} where sess_expire < {$expire}";
			return $this->db_delete_update($sql);
		}

	}