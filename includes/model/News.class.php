<?php
//前台新闻类
  class News extends MyPDO{
     //属性
	 protected $table="news";

	 /*
	  * 查询出所有的列表
	  * return 返回数组，失败false
	 */
	 public function AllList(){
	   //SQl
	   $sql = "select * from ym_news";

	   //执行
	   return $this->db_getAll($sql);
	 }
  
      /*
	  * 通过id查询出
	  * return 返回数组，失败false
	 */
	 public function OneList($id){
	   //SQl
	   $sql = "select * from ym_news where id='{$id}'";

	   //执行
	   return $this->db_getOne($sql);

	 }
  }
  