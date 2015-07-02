<?php

	//学生表类

	class User extends MyPDO{
	
		//属性，表名
		protected $table = 'user';

		/*
		 * 通过用户名查询数据
		 * @parameter1 string 通过用户名获取用户信息
		 * @return 返回一个一维数组或false
		 */
		public function getUserByUsername($username){
			
			$sql = "select * from {$this->getTableName()} where u_username = '{$username}'";
			return $this->db_getOne($sql);
		}

		/*
		 * 插入数据
		 * @parameter1 string $username 要添加的用户名
		 * @parameter2 string $password 要添加的用户密码
		 * @return 返回自增长ID或者false
		 */
		public function insertUser($username,$password){
		
			$password = md5('yimai'.$password);
			$sql = "insert into {$this->getTableName()}(id,u_username,u_password) values(null,'{$username}','{$password}')";
			return $this->db_insert($sql);
		}

		/*
		 * 通过用户ID查询用户信息
		 * @parameter1 int $id 要查询用户的ID
		 * @return 返回一个数组或者false
		 */
		public function getUserById($id){
		
			$sql = "select * from {$this->getTableName()} where id = {$id}";
			return $this->db_getOne($sql);
		}

	}