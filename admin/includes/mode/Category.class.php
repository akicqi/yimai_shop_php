<?php

		//操作category表的类

	class Category extends MyPDO{
			//属性
		protected $table = 'category';

			/*获取所有商品分类方法
			 *@param1 int $stop id	= 0 不需要获取的商品分类的id
			 *return ： 成功返回二维数组，失败返回空数组
			*/
		public function getAllCategories($stop_id = 0){
				//组织SQL语句
				$sql = "select * from {$this->getTableName()} order by c_sort";

				//执行
				$categories = $this->db_getAll($sql);

				//调用无限级分类
				return $this->noLimitCategories($categories,0,0,$stop_id);
			}

			/*
			 *无限级分类
			 *@Parma1 array() $categories，要分类的二维数组
			 *@Parma2 int $parent id = 0，要找的分类
			 *@param3 int $level = 0，当前分类所属的层数
			 *@param4 int $stop_id = 0，不需要获取的商品分类的id
			 *@return 一个进行分类好的二维数组
			*/

		public function noLimitCategories($categories,$parent_id=0,$level=0,$stop_id = 0){
			//定义一个二维数组，保存新的找出的结果
			static $lists = array();	//子函数中要共用
			//找出所有的顶级分类
			foreach($categories as $category){
				//判断是否是当前要找的分类
				if($category['c_parent_id'] == $parent_id && $category['id'] != $stop_id){
				//符合当前层级：当前层级属性加到对应的商品分类中
				$category['level'] = $level;

				//符合条件
				$lists[] = $category;

				//递归点：$category有可能还有自己的子分类
				$funcname = __FUNCTION__;
				$this->$funcname($categories,$category['id'],$level+1,$stop_id);
					}
					//递归出口：不满足条件就没有子分类
				}
				//递归出口：遍历数组结束也没有遇到合适的

			//返回对应的数组
			return $lists;	
			}
		/*
		 *验证商品分类名字是否存在
		 *@param1 int $parent_id，当前要查找的父分类id
		 *@param2 string $name，要匹配的商品分类的名称
		 *@param3 int $except_id = 0，不需要去判断的商品分类id
		 *@return 存在返回一个数组，不存在返回一个false
		*/
		public function checkCategoryByParentIdAndName($parent_id,$name,$except_id = 0){
			//组织SQL语句
			$name = addslashes($name);		//防止SQL注入

			$sql = "select id from {$this->getTableName()} where c_parent_id = '{$parent_id}' and c_name = '{$name}' and id <> '{$except_id}' limit 1";

			//执行
			return $this->db_getOne($sql);
			}

		/*
		 *插入商品分类
		 *@Parma1 string $name
		 *@parma2 int $parent_id
		 *@param3 int $sort
		 *@return 成功返回自增长id，失败返回false
		*/
		public function insertCategory($name,$parent_id,$sort){
			//组织SQL语句
			$sql = "insert into {$this->getTableName()} values(null,'{$name}','{$sort}',0,'{$parent_id}')";

			//执行SQL
			return $this->db_insert($sql);
			}
		/*
		 *判断当前商品分类是否包含子分类
		 *@param1 int $id，要判断的商品分类
		 *@return 布尔类型
		*/
		public function isLeaf($id){
			//判断当前商品分类的id是否是其他分类的父id
			$sql = "select id from {$this->getTableName()} where c_parent_id = '{$id}' limit 1";

			//执行
			$res = $this->db_getOne($sql);	//正确：数组；错误：false
			//数组代表不是叶子节点；false代表是叶子节点
			//因为查询的结果与要判断的结果刚好相反（取反）
			return !((boolean)$res);
			}

		/*
		 *判断商品分类是否包含商品子类
		 *@Parma1 int $id
		 *@return 有商品返回true，没有商品返回false
		*/
		public function hasGoods($id){
			//sql
			$sql = "select id from {$this->getTableName()} where c_goods > 0 and id = '{$id}'";

			//执行
			return (boolean)$this->db_getOne($sql);
			}

		/*
		 *通过商品分类id删除商品
		 *@Parma1 int $id;
		 *$return 受影响的行数
		*/
		public function deleteCategoryById($id){
			//SQL
			$sql = "delete from {$this->getTableName()} where id = '{$id}'";

			//执行
			return $this->db_exec($sql);
			}

		/*
		 *通过id获取商品分类
		 *@param1 int $id
		 *@return 成功返回数组，失败返回false
		*/
		public function getCategoryById($id){
			//查询SQL
			$sql = "select * from {$this->getTableName()} where id = '{$id}'";

			//执行
			return $this->db_getOne($sql);
			}
		/*
		 *通过id更新商品分类
		 *@param1 int $id
		 *@param2 string $name
		 *@param3 int $parent_id 
		 *@param4 int $sort
		 *@return 受影响的行数
		*/
		public function updateCategoryById($id,$name,$parent_id,$sort){
			//更新SQL
			$sql = "update {$this->getTableName()} set c_name = '{$name}',c_parent_id = '{$parent_id}',c_sort = '{$sort}' where id = '{$id}'";

			//执行SQL
			return $this->db_exec($sql);
			}
		}	
	