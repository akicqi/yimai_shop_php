<?php

	//公共函数

	/*
	 * 重定向函数
	 * @parameter1 string $url 要跳转的目标对象
	 * @parameter2 string $msg1 提示信息
	 * @parameter2 string $msg2 提示信息
	 * @parameter3 int $time = 3000 跳转时间
	 */
	function my_redirect($url,$msg1,$msg2,$time = 3000){
	
		//加载重定向模板
		include_once YIMAI_TEMP.'redirect.html';
		exit;
	}

	/*
	 * 自动加载类函数
	 * @parameter1 string $class 要加载的类名
	 */
	 function __autoload($class){
	 
		$core = YIMAI_CORE."{$class}.class.php";
		$mode = YIMAI_MODE."{$class}.class.php";
		$tool = YIMAI_TOOL."{$class}.class.php";

		if(is_file($core)){

			include_once $core;

		}elseif(is_file($mode)){

			include_once $mode;
		}elseif(is_file($tool)){
		
			include_once $tool;
		}
	 }