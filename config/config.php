<?php

	//前台初始化配置文件
	
	return array(	
		'mysql' => array(
			
			'type' => 'mysql',
			'port' => '3306',
			'dbname' => 'yimai',
			'charset' => 'utf8',
			'host' => 'localhost',
			'username' => 'root',
			'pass' => '7712',
			'prefix' => 'ym_'

		),

		'captcha' => array(
		
			'width' => 100,
			'height' => 20,
			'strlen' => 4,     //随机字符串长度
			'pixels' => 200,   //干扰像素点数量
			'lines' => 3,      //干扰线数量
			'font' => 5     
		),

		'pagecount' => 12,   //前台分页

		//每页显示留言数
	   'guestbook_page' => 5

	);