<?php 
/**
 * 易买网Admin类
 * Author: akic
 * Date:2015-05-15
 * pagename:Admin.Class.php
*/

class Admin extends MyPDO{
	protected $table = 'admin';
	
	/*
	* 检查用户登录输入账号与密码是否正确
	* @param1 string $username 用户账号
	* @param2 string $password 用户密码
	* @return 正确返回数组，否则返回false
	*/
	public function checkUsernameAndPassword($username) {
		//对即将入库查询的用户账号名进行转义
		$username = addslashes($username);
		//构建sql语句
		$sql = "select * from {$this->getTableName()} where a_username = '{$username}'";
		return $this->db_getOne($sql);

	}

	/*
	* 取得具备有效cookie管理员信息
	* @param int $id cookie中保存的id
	* @return 正确返回数组，否则返回false
	*/
	public function getById($id) {
		$sql = "select * from {$this->getTableName()} where id = '{$id}'";
		return $this->db_getOne($sql);
	}


	/*
	* 添加管理员
	* @param1 string $username 账号
	* @param2 string $password 密码
	* @param3 string $email 邮箱
	* @return 成功返回自增长id，失败返回false
	*/

	public function insertAdmin($username,$password,$email) {
		$getpasstime = 0;
		$password = sha1('yimai_' . $password);
		$sql = "insert into {$this->getTableName()} values(null,'{$username}','{$password}','{$email}','{$getpasstime}')";
		return $this->db_insert($sql);
	}

	/*
	* 取得管理员列表
	* @return 成功返回二维数组，否则返回false
	*/

	public function getAllAdmin() {
		$sql = "select * from {$this->getTableName()}";
		return $this->db_getAll($sql);
	}

	/*
	* 修改管理员信息
	* @param1 string $password 更新密码
	* @param2 string $email 更新邮箱
	* @param3 int $id 更新的id
	* @return 返回受影响行数，否则返回false
	*/

	public function updateAdmin($password,$email,$id) {
		$password = sha1('yimai_' . $password);
		$sql = "update {$this->getTableName()} set a_password = '{$password}',a_email = '{$email}' where id = '{$id}'";
		return $this->db_delete_update($sql);
	}

	/*
	* 删除管理员
	* @param int $id 要删除管理员id
	* @return 返回受影响的行数，否则返回false
	*/

	public function deleteAdmin($id) {
		$sql = "delete from {$this->getTableName()} where id = '{$id}'";
		return $this->db_delete_update($sql);
	}

	/*
	* 根据邮箱检查用户是否存在
	* @param string $email 管理员邮箱
	* @return 正确返回数组，否则返回false
	*/
	public function getByEmail($email) {
		$sql = "select * from {$this->getTableName()} where a_email = '{$email}'";
		return $this->db_getOne($sql);
	}

	/*
	* 更新发送邮件时间
	* @param1 string $getpasstime 发送时间
	* @param2 int $uid 更新的用户
	* @return 正确返回受影响的行数
	*/
	public function updateTime($getpasstime,$uid) {
		$sql = "update {$this->getTableName()} set getpasstime = '{$getpasstime}' where id = '{$uid}'";
		return $this->db_delete_update($sql);
	}

	/*
	* 重置管理员密码
	* @param1 int $id 更新的管理员id
	* @param2 string $password 更新的密码
	* @return 返回受影响行数，否则返回false
	*/

	public function resetPasswd($id,$password) {
		$password = sha1('yimai_' . $password);
		$sql = "update {$this->getTableName()} set a_password = '{$password}' where id = '{$id}'";
		return $this->db_delete_update($sql);
	}
}

