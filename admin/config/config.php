<?php 
/**
 * 易买网config
 * Author: akic
 * Date:2015-05-15
 * pagename:config.php
*/

//数据库配置
return array(						
	//数据库配置
	'mysql' =>array(
	'type'     => 'mysql',
	'host'     => 'localhost',
	'port'     => '3306',
	'username' => 'root',
	'pass'     => '7712',
	'charset'  => 'utf8',
	'dbname'   => 'yimai',
	'prefix'   => 'ym_'			
),
//验证码配置
	'captcha'    => array(
		'width'  => 100,
		'height' => 30,
		'strlen' => 4,
		'pixels' => 50,
		'lines'  => 4,
		'font'   => 8

),

//邮件发送参数配置
	'email' => array(
		'Host' => "smtp.163.com",
		'Port' => 25,
		'SMTPAuth' => true,
		'CharSet' => "UTF-8",
		'Encoding' => "base64",
		'Username' => "a5712751@163.com",
		'Password' => "5712751zxc<>",
		'Subject'  => "尊敬的用户，您好！",
		'From'     => "a5712751@163.com",
		'FromName' => "易买网邮件管理",


),
	//后台商品数量分页显示数据量
		'admin_goods_pagecount' => 10,
		'admin_goods_trash_pagecount' => 5,
		'admin_order_pagecount' => 5,

		//后台商品文件上传允许的类型
		'admin_goods_mime' => 'image/gif,image/png,image/jpg,image/jpeg,image/pjpeg',

		//后台商品缩略图配置项
		'admin_goods_thumb_width' => 50,
		'admin_goods_thumb_height' => 50,
	
		//每页显示留言数
	   'guestbook_page'=>5
	
	)



?>
