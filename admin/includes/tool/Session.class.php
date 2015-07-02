<?php

	//session入库

	class Session extends MyPDO{
		//属性
		protected $table = 'session';

		//构造方法
		public function __construct(){
			//调用父类的构造方法
			parent::__construct();

			//修改session机制
			session_set_save_handler(
				array($this,'sess_open'),
				array($this,'sess_close'),
				array($this,'sess_read'),
				array($this,'sess_write'),
				array($this,'sess_destroy'),
				array($this,'sess_gc')
			);
		}

		//初始化方法
		public function sess_open(){
			//数据库连接初始化：MYPDO类已经做好，所以不需要做任何事情
		}

		//关闭方法
		public function sess_close(){
			//连接资源通常不关闭：又不需要做任何事情
		}

		//读取方法
		public function sess_read($id){
			//SQL组织
			$expire = time() - ini_get('session.gc_maxlifetime');
			$sql = "select * from {$this->getTableName()} where sess_id = '{$id}' and sess_expire >= '{$expire}'";

			//执行
			$row = $this->db_getOne($sql);

			//判断返回
			if($row){
				//有数据
				return $row['sess_content'];
			}else{
				//没有
				return '';
			}
		}

		//写入方法
		public function sess_write($id,$content){
			//SQL
			$time = time();
			$sql = "replace into {$this->getTableName()} values('{$id}','{$content}','{$time}')";

			return (boolean)$this->db_insert($sql);
		}

		//删除session方法
		public function sess_destroy($id){
			//SQL
			$sql = "delete from {$this->getTableName()} where sess_id = '{$id}'";
			return $this->db_exec($sql);
		}

		//垃圾回收
		public function sess_gc(){
			//计算过期时间
			$expire = time() - ini_get('session.gc_maxlifetime');
			$sql = "delete from {$this->getTableName()} where sess_expire < '{$expire}'";
			return $this->db_exec($sql);
		}
	}