<?php
//新闻管理操作
 class News extends MyPDO{
   //属性
   protected $table='news';

    /*
	  * 查询所有的新闻列表
	  * return 成功，返回数组，失败 false
     */
	public function AllNews(){
	   //组织SQL
	  $sql="select * from ym_news";
      
	  //执行 
	  return $this->db_getAll($sql);
	}
    
	/*
	 * 插入新闻到数据库
	 * @ param1 string $title,
	 * @ param2 string $content,
	 * return 成功，返回受影响的行，失败false
	 */
	public function InsertNews($title,$content){
	 //SQL
	 $sql="insert into ym_news values(null,'{$title}','{$content}')";

	 //执行
	 return $this->db_insert($sql);
	
	}

	/*
	  * 通过id删除新闻列表
	  * @param1 int $id 要删除的id，
	  * return 成功返回受影响的行，失败，false
	 */
	public function DeleteNews($id){
	 //SQL
	 $sql="delete from ym_news where id='{$id}'";

	 //执行 
	 return $this->db_delete_update($sql);
	}

	/*
	 * 通过id获取需要编辑的新闻
	 * @param1 int $id 
	*/
    public function GetOneNews($id){
	 //SQL
	 $sql="select * from ym_news where id='{$id}'";

	 //执行
	 return $this->db_getOne($sql);
	}

	/*
	  * 通过id更新新闻
	  * @ param1 int $id 
	  * @ param1 string $title 
	  * @ param1 string $content 
	  * return 受影响的行，失败返回false
	 */
	public function UpdateNews($id,$title,$content){
	 //SQl
	 $sql = "update ym_news set n_title='{$title}',n_content='{$content}' where id='{$id}'";

	 //执行 
	 return $this->db_delete_update($sql);
	}
 }