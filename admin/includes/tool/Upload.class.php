<?php

	//文件上传工具类

	class Upload{
		//公有错误静态属性
		static public $error;
		
		//静态方法
		/*
		 * 单文件上传
		 * @param1 array $file，要上传的文件信息（5个元素的数组）
		 * @param2 string $path，文件上传目录
		 * @param3 string $allow，允许上传的类型（MIME类型）//image/png,image/gif
		 * @param4 int max_size = 1000000，默认的允许的大小，最大1M
		 * @return 新的文件名（对上传文件进行重名）
		*/
		public static function uploadSingle($file,$path,$allow,$max_size = 1000000){
			//判断文件的合法性
			if(!is_array($file) || count($file) != 5){
				//错误
				self::$error = '上传文件不存在！';
				return false;
			}

			//判断错误代码
			switch($file['error']){
				case 1:	//文件超过服务器允许大小
					self::$error = '文件超过服务器允许的大小，服务器允许的最大值为：' . ini_get('upload_max_filesize');
					return false;
				case 2:	//文件超过表单允许大小
					self::$error = '文件超过表单允许大小！';
					return false;
				case 3:	//文件只上传一部分
					self::$error = '文件只上传部分！';
					return false;
				case 4:	//没有选中要上传的文件
					self::$error = '没有选中要上传的文件';
					return false;
				case 6:
				case 7:
					self::$error = '服务器错误，文件上传失败！';
					return false;
			}

			//判断文件类型是否符合
			if(strpos($allow,$file['type']) === false){
				//没有匹配到：不允许的类型
				self::$error = '不允许的文件类型：允许的类型有：' . $allow;
				return false;
			}

			//文件大小判断
			if($file['size'] > $max_size){
				self::$error = '文件超出当前允许的大小：当前允许的大小为：' . $max_size/1000000 . 'M';
				return false;
			}

			//移动文件到指定目录
			$new_name = self::getNewName($file['name']);
			if(move_uploaded_file($file['tmp_name'],$path . '/' .$new_name)){
				//文件移动成功
				return $new_name;
			}else{
				//失败
				self::$error = '文件移动失败！';
				return false;
			}
		}

		/*
		 * 生成新的文件名字
		 * @param1 string $filename，原文件名字
		 * @return新名字
		*/
		private static function getNewName($filename){
			//构造时间日期部分
			$newname = date('YmdHis');

			//构造随机部分
			$str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			for($i = 0;$i < 6;$i++){
				$newname .= $str[mt_rand(0,strlen($str) - 1)];
			}

			//获取后缀名
			return $newname . strrchr($filename,'.');
		}
	}