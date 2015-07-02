<?php
	//include_once '../init.php';
	//用户表操作
	//继承DB
	class Users extends MyPDO{
		//属性
		protected $table='user';
		/*
		*得到所有用户
		*@return 成功返回二位数组,失败返回false
		*/
		public function getAllUser(){
			//sql
			$sql = "select * from ym_user";
			//执行
			$res = $this->db_getAll($sql);
			for($i = 0,$len = count($res);$i < $len;$i++){
				if($res[$i]['u_sex'] == 0){
					$res[$i]['u_sex'] = '男';
				}
				if($res[$i]['u_sex'] == 1){
					$res[$i]['u_sex'] = '女';
				}
			}
			return $res;
		}
		/*
		*通过id获取用户数据
		*@param1 int $id ,
		*@return 成功返回一维数组,失败返回false
		*/
		public function getUserInfoById($id){
			//sql
			$sql = "select * from ym_user where id = '{$id}'";
			//执行
			return $this->db_getOne($sql);
		}
		/*
		*通过id修改用户数据
		*@param1 int $id 
		*@param2 array $arr
		*@return 成功返回受影响的行数,失败返回false
		*/
		public function updateUserInfoById($id,$arr){
			//sql
			$sql = "update ym_user set u_username='{$arr['u_username']}',u_name='{u_name}',u_sex='{$arr['u_sex']}',u_email='{$arr['u_email']}',u_number='{$arr['u_number']}',u_address='{$arr['u_address']}',u_headportrait='{$arr['u_headportrait']}',u_time='{$arr['u_time']}'";
			//执行
			return $this->db_delete_update($sql);
		}
		/*
		*删除用户
		*@param1 $id int
		*@retrun 成功返回受影响的行数,失败返回false
		*/
		public function deleteUserById($id){
			//sql 
			$sql = "delete from ym_user where id = '{$id}'";
			//执行
			return $this->db_delete_update($sql);
		}
		/*
		*新增用户
		*@param1 arr $arr
		*@return 成功返回自增长id失败false
		*/
		public function insertUserInfo($arr){
			//组织insertSQL语句
			//insert into sh_goods(字段列表) values(值列表);
			//insert into values('值1','值2');

			//自动构造字段列表和值列表
			$fields = $values = '';
			//遍历数组
			foreach($arr as $k => $v){
				//k代表字段名，v代表值
				$fields .= $k . ',';
				$values .= "'" . $v . "',";
			}

			//去除右边的多余逗号
			$fields = rtrim($fields,',');
			$values = rtrim($values,',');

			//组织SQL
			$sql = "insert into ym_user ({$fields}) values({$values})";

			//执行
			return $this->db_insert($sql);
		}
		/*
		*判断邮件是否唯一
		*@param1 string $email,
		*@return 成功返回true,失败返回false
		*/
		public function getUserEmail($email){
			//sql
			$sql = "select id from ym_user where u_email = '{$email}'";
			//执行
			return (boolean)$this->db_getOne($sql);
		}
	}
	//$user = new User();
	//var_dump($user);
	//$res = $user->getAllUser();
	//var_dump($res);
?>