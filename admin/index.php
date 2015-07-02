<?php 
/**
 * 易买网后台首页
 * Author: akic
 * Date:2015-05-14
 * pagename:index.php
*/
//判断传过来是否有act
$act = isset($_GET['act']) ? $_GET['act'] : 'index';

//加载配置文件
include_once "./includes/init.php";

//判断动作
if($act == 'index') {
	include_once ADMIN_TEMP . "index.html";
}
