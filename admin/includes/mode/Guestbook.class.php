<?php

   //留言表操作类
   class Guestbook extends MyPDO{

	   //获取所有留言信息   $page =1   $length每页数据个数基本不变 $offset通过页码和$length计算   //$pagecount=1  页码默认第一页
       public function getAllMessage($pagecount,$page=1){
          //计算$offset
		  //$length=10;
		  $offset=($page-1) * $pagecount;
	  
	      //查询留言信息
	      //sql语句
		  $sql="select * from ym_guestbook limit {$offset},{$pagecount}";
		  return $this->db_getAll($sql);	   
	  }

	  //获取总记录数
	  public function getCounts(){
	     //sql语句
		 $sql="select count(*) as g from ym_guestbook";
		 $res=$this->db_getOne($sql);
         return $res['g'];
	  }

	  //删除留言
	  public function deleteMessage($id){
	     //sql语句
		 $sql="delete from ym_guestbook where g_id='{$id}'";
		 return $this->db_delete_update($sql);
	  }

	  //新增留言
	  public function insertMessage($id){
	     //sql语句
		 $sql="insert into ym_guestbook values(default,$g_name,$g_send_text)";
		 return $this->db_insert($sql);
	  }

	  //回复留言
	  public function updateReplay($id,$g_text_replay){
	     //sql语句
		 $sql="update ym_guestbook set g_is_replay='1',g_text_replay='{$g_text_replay}' where g_id='{$id}'";
		 return $this->db_delete_update($sql);
	  }
      
	  //查询单挑留言
	  public function getMessageById($id){
	     //sql
		 $sql="select * from ym_guestbook where g_id='$id'";
		 return $this->db_getOne($sql);
	  }

   
   }

?>