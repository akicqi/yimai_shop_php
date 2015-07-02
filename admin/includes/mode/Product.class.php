<?php
//商品分类

  class Product extends MyPDO{
    //属性
	 protected $table ='product';
	 
	 /*
	  * 查询分类 数据
	  * return 数组，失败返回 空数组
	 */
     public function getProduct($stop_id=0){
	   //组织SQL
	   $sql = "select * from ym_category";

	   //执行sql
	   $products= $this->db_getAll($sql);
	   //调用无限级分类
	    return $this->Nolist($products,0,$stop_id);
	  }

	  /*
	    * 无限级分类
		* @ param1 array $products 要分类的数组
		* @ param2 int $parent_id  分类的id
		* @ Param3 string $level  缩进的层级
		* return 成功返回分类好的数组，失败返回false
	  */
	  private function Nolist($products,$parent_id,$stop_id=0,$level=0){
	   //定义一个数组来保存分类好的数据 
	   static $list=array();

	   //遍历数组找出所有需要分类的顶级类 
		 foreach($products as $pro){
		  //判断遍历出的结果是否符合顶级分类
		   if($pro['c_parent_id']==$parent_id&&$pro['id']!=$stop_id){

			  //符合当前层级:将当前层级属性添加到对应的属性列表
			  $pro['level']=$level;

		     //符合要求:存放到数组中
			  $list[]=$pro;
              $this->Nolist($products,$pro['id'],$stop_id,$level+1);
		   }	
	    }
	    //返回对应数组
		return $list;
	 }
	 
	/*
	  * 验证商品分类名称是否存在
	  * @param1 string $name ,要查找的分类名称
	  * @param2 int  $parent_id,要查找的父分类id
	  * return 成功，返回一维数组，失败返回false
	 */
	 public function CheckParentIdAndName($name,$parent_id){
	   //SQL
	   $sql = "select id from ym_category where c_name='{$name}' and c_parent_id='{$parent_id}' limit 1";
      
	  return $this->db_getOne($sql);
	 }

	 /*
	   * 插入商品分类数据
	   * @param1 string  $name,需要插入的分类名称
	   * @param2 int    $number ,商品分类数量
	   * @param3 int  $parent_id ,插入商品分类的父id
	   * return 成功返回受影响的行数，失败false
	 */
	public function InsertProduct($name,$parent_id){
	 //SQl
	 $sql = "insert into ym_category values(null,'{$name}',1,'{$parent_id}')";
     //执行
	  return $this->db_insert($sql);
	}

	/*
	 * 查找叶子节点
	 * @param1 int $id ,要查找的分类id
	 * return 成功返回数组 ，失败false
	 * 需要如果返回数组,那么此节点就不是叶子节点
	*/
	public function IsNoleaf($id){
	 //SQL
	 $sql = "select id from ym_category where c_parent_id='{$id}' limit 1";
	 
	 //执行:需要的是叶子节点，如果查询出的是数组，则要取反
	 return $this->db_getOne($sql);
	
	}

	/*
	  * 分类是否存在商品
	  * @param1 int $id ,查询的分类id
	  * return 成功返回数组 ，失败false
	 */
	public function  HasGoods($id){
	 //SQL 
	 $sql="select id from ym_category where c_parent_id='{$id}' limit 1 ";

	 //执行
	 return (boolean)$this->db_getOne($sql);
	}

	/*
	  * 通过id删除商品分类
	  * @param1 int $id,分类id
	  * return 成功受影响的行 ，失败false
	 */
	public function DeletePreductId($id){
	 //SQL
	 $sql="delete from ym_category where id='{$id}'";

	 //执行
	 return $this->db_delete_update($sql);
	}

	/*
	  * 通过id获取商品id
	  * @param1 int $id 商品id
	  * return 成功返回数组，失败返回false
	 */
	public function getProductById($id){
	 //SQl
	 $sql = "select * from ym_category where id='{$id}'";

	 //执行
	 return $this->db_getOne($sql);
	}

	/*
	  * 更新商品分类
	  * @ param1 int $id,
	  * @ param2 string $name,
	  * @ param3 int $parent_id,
	  * return 成功返回受影响的行，失败返回false
	 */
	public function UpdateProductById($id,$name,$parent_id){
	 //SQL
	 $sql = "update ym_category set c_name='{$name}',c_parent_id='{$parent_id}' where id='{$id}'";

	 //执行
	 return $this->db_delete_update($sql);
	}
  }
  