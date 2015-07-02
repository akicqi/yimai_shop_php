<?php

	//图片处理类

	class Image{
		//属性
		private $width;
		private $height;
		public $error;

		//构造方法
		public function __construct($width = 0,$height = 0){
			$this->width = ($width != 0) ? $width : $GLOBALS['config']['admin_goods_thumb_width'];
			$this->height = ($height != 0) ? $height : $GLOBALS['config']['admin_goods_thumb_height'];
		}

		/*
		 * 创建缩略图
		 * @param1 string $file，原图
		 * @param2 string $path，缩略图存放路径
		 * @return 缩略图的名字
		*/
		public function getThumb($file,$path){
			//判断文件是否存在
			if(is_file($file)){
				$this->error = '文件不存在！';
				return false;
			}

			//得到文件后缀
			$ext = $this->getExtension($file);	//gif,png,jpg,jpeg,pjpeg ==> gif,png,jpeg

			//定义数组
			$arr = array(
				'png'	=> 'png',
				'gif'	=> 'gif',
				'jpg'	=> 'jpeg',
				'jpeg'	=> 'jpeg',
				'pjpeg' => 'jpeg'
			);

			//得到函数名
			$create = 'imagecreatefrom' . $arr[$ext];	//imagecreatefromjpeg

			//得到原图资源
			//$src = $create($file);						//可变函数
			//获取缩略图资源
			$dst = imagecreatetruecolor($this->width,$this->height);
			//背景填充白色
			$bg = imagecolorallocate($dst,255,255,255);
			imagefill($dst,0,0,$bg);

			//获取图片信息
			$info = getimagesize($file);
			
			//通过宽高比求出：缩略图内容的实际宽高
			$src_b = $info[0] / $info[1];
			$dst_b = $this->width / $this->height;
			//比较
			if($src_b > $dst_b){
				//原图宽高比大于缩略图的宽高比
				$dst_width = $this->width;
				$dst_height = $this->ceil($dst_height * $src_b);
			}else{
				//原图宽高比小于缩略图的宽高比
				$dst_height = $this->height;
				$dst_width = ceil($dst_height * $src_b);
			}

			//求缩略图中的其实位置
			$start_x = floor(($this->width - $dst_width) / 2);
			$start_y = floor(($this->height - $dst_height) / 2);

			//采样复制
			if(imagecopyresampled($dst,$src,$start_x,$start_y,0,0,$dst_width,$dst_height,$info[0],$info[1])){
				//采样复制成功
				//保存缩略图：缩略图只要在原图前面加上thumb_
				//获取一个路径下对应文件的名字
				$file = 'thumb_' . basename($file);
				//imagepng($dst,$path . '/' . $file);
				//释放资源
				imagedestroy($src);
				imagedestroy($dst);

				//返回文件名
				return $file;
			}else{
				//失败
				$this->error = '采样复制失败！';
				return false;
			}
		}

		/*
		 * 获取文件后缀
		 * @param1 string $file
		 * @return $ext，文件后缀
		*/
		private function getExtension($file){
			return substr($file,strrpos($file,'.') + 1);
		}

	}