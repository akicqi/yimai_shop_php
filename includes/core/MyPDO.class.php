<?php
	
	header('content-type:text/html;charset=utf-8');
	//封装PDO类
	class MyPDO{
	
		//属性
		private $type;
		private $host;
		private $port;
		private $username;
		private $pass;
		private $dbname;
		private $charset;
		private $prefix;

		private $pdo;
		//构造方法
		public function __construct($arr = array()){
		
			//数据库初始化
			$this->type = isset($arr['type']) ? $arr['type'] : $GLOBALS['config']['mysql']['type'];
			$this->host = isset($arr['host']) ? $arr['host'] : $GLOBALS['config']['mysql']['host'];
			$this->port = isset($arr['port']) ? $arr['port'] : $GLOBALS['config']['mysql']['port'];
			$this->username = isset($arr['username']) ? $arr['username'] : $GLOBALS['config']['mysql']['username'];
			$this->pass = isset($arr['pass']) ? $arr['pass'] : $GLOBALS['config']['mysql']['pass'];
			$this->charset = isset($arr['charset']) ? $arr['charset'] : $GLOBALS['config']['mysql']['charset'];
			$this->dbname = isset($arr['dbname']) ? $arr['dbname'] : $GLOBALS['config']['mysql']['dbname'];
			$this->prefix = isset($arr['prefix']) ? $arr['prefix'] : $GLOBALS['config']['mysql']['prefix'];

			//连接数据库
			$this->db_connect();

			//开启异常模式
			
			$this->db_exception();
		}
		//异常模式
		private function db_exception(){
		
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		}

		//数据库连接
		private function db_connect(){
			//连接认证
			$this->pdo = new PDO("{$this->type}:host={$this->host};port={$this->port};dbname={$this->dbname};charset={$this->charset}",$this->username,$this->pass);

			if(!$this->pdo){

				echo '数据库连接认证错误！<br/>';
				//echo '错误编号：'.$this->pdo->errorCode().'<br/>';
				//echo '错误信息：'.$this->pdo->errorInfo().'<br/>';
				exit;
			}

		}

		//写操作的错误异常
		private function db_write_exception($sql){

			try{
			
				return $this->pdo->exec($sql);

			}catch(PDOException $error){
			
				echo 'SQL语句出错！<br/>';
				echo '错误编码：'.$error->getCode().'<br/>';
				echo '错误信息：'.$error->getMessage().'<br/>';
				echo '错误脚本: '.$error->getFile().'<br/>';
				echo '错误行号：'.$error->getLine().'<br/>';
				exit;
			}
		}

		//读操作的错误异常
		private function db_read_exception($sql){
		
			try{
				
				return $this->pdo->query($sql);

			}catch(PDOException $error){
			
				echo 'SQL语句出错！<br/>';
				echo '错误编码：'.$error->getCode().'<br/>';
				echo '错误信息：'.$error->getMessage().'<br/>';
				echo '错误脚本: '.$error->getFile().'<br/>';
				echo '错误行号：'.$error->getLine().'<br/>';
				exit;
			}
		}

		//数据新增功能
		/*
		*@parameter1 string $sql 要新增的SQL语句
		*@parameter2 mixed $res 返回自增长ID或false
		*/
		public function db_insert($sql){
		
			 $this->db_write_exception($sql);
			 //返回自增长ID
			 return $this->pdo->lastInsertId();
		}

		//删除和更新功能
		/*
		*@parameter1 string $sql 要执行的SQL语句
		*@parameter2 mixed $res 返回受影响的行数或false
		*/
		public function db_delete_update($sql){
			
			 //返回受影响的行数
			 return $this->db_write_exception($sql);
		}

		//查询功能 结果为一条记录
		/*
		*@parameter1 string $sql 要执行的SQL语句
		*@parameter2 mixed $res 返回一维数组或false
		*/
		public function db_getOne($sql){
		
			$statement = $this->db_read_exception($sql);
			//执行fetch方法
			return $statement->fetch(PDO::FETCH_ASSOC);
		}

		//查询功能 结果为多条记录
		/*
		*@parameter1 string $sql 要执行的SQL语句
		*@parameter2 mixed $res 返回二维数组或false
		*/
		public function db_getAll($sql){
			
			$statement = $this->db_read_exception($sql);
			//执行fetch方法
			//定义一个数组
			
			$lists = $statement->fetchAll(PDO::FETCH_ASSOC);
				
	
			return $lists;
		}

		/*
		 *获取全表名
		 *return string $allName 全表名
		 */
		 protected function getTableName(){
		 
			return $this->prefix.$this->table;
		 }
	}


	//$db = new MyPDO(array('type'=>'mysql','host'=>'localhost','port'=>'3306','dbname'=>'shop','charset'=>'utf8','username'=>'root','pass'=>'7712','prefix'=>'sh_'));

	//var_dump($db->db_getOne('update sh_admin set a_last_login_ip = '{$ip}',a_last_login_time = {$time} where id = 1'));

