<?php

	//验证码工具类

	class Captcha{
		//属性
		private $width;		//图片宽度
		private $height;	//图片高度
		private $strlen;	//随机字符串的长度
		private $font;		//随机字符串的大小
		private $pixels;	//干扰点的数量
		private $lines;		//干扰线数量

		//初始化
		public function __construct($arr = array()){
			//初始化属性
			$this->width = isset($arr['width']) ? $arr['width'] : $GLOBALS['config']['captcha']['width'];
			$this->height = isset($arr['height']) ? $arr['height'] : $GLOBALS['config']['captcha']['height'];
			$this->strlen = isset($arr['strlen']) ? $arr['strlen'] : $GLOBALS['config']['captcha']['strlen'];
			$this->pixels = isset($arr['pixels']) ? $arr['pixels'] : $GLOBALS['config']['captcha']['pixels'];
			$this->lines = isset($arr['lines']) ? $arr['lines'] : $GLOBALS['config']['captcha']['lines'];
			$this->font = isset($arr['font']) ? $arr['font'] : $GLOBALS['config']['captcha']['font'];
		}

		/*
		 * 制作验证码图片
		 * 直接输出
		*/
		public function generate(){
			//1.制作画布
			$img = imagecreatetruecolor($this->width,$this->height);

			//2.画布背景（随机：200-255）
			//分配颜色
			$bg = imagecolorallocate($img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
			//填充
			imagefill($img,0,0,$bg);

			//3.获取随机字符串
			$captcha = $this->getRandomString();
			

			//4.增加干扰点
			$this->setPixel($img);

			//5.增加干扰线
			$this->setLines($img);

			//6.将验证码写入到图片
			$start_x = ceil($this->width / 2) - 20;
			$start_y = ceil($this->height / 2) - 10;
			//分配颜色
			$string = imagecolorallocate($img,mt_rand(0,100),mt_rand(0,100),mt_rand(0,100));
			imagestring($img,$this->font,$start_x,$start_y,$captcha,$string);

			//7.输出图片
			//header('Content-type:image/png');
			imagepng($img);

			//8.释放资源
			imagedestroy($img);

		}

		/*
		 * 设置干扰线
		 * @param1 source $img，要操作的资源
		*/
		private function setLines($img){
			//设置干扰线：先需要分配颜色
			for($i = 0;$i < $this->lines;$i++){
				//随机颜色
				$line = imagecolorallocate($img,mt_rand(100,150),mt_rand(100,150),mt_rand(100,150));

				//画线
				imageline($img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$line);
			}
		}

		/*
		 * 设置干扰点
		 * @param1 source $img，要操作的资源
		*/
		private function setPixel($img){
			//设置干扰点：先分配颜色
			for($i = 0;$i < $this->pixels;$i++){
				//获取颜色：随机
				$pixel = imagecolorallocate($img,mt_rand(150,200),mt_rand(150,200),mt_rand(150,200));

				//画点
				imagesetpixel($img,mt_rand(0,$this->width),mt_rand(0,$this->height),$pixel);
			}
		}

		/*
		 * 获取随机字符串
		 * @return 一个随机生成的字符串
		*/
		private function getRandomString(){
			//定义目标字符串
			$str = 'abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';

			//随机获取
			$captcha = '';
			for($i = 0;$i < $this->strlen;$i++){
				$captcha .= $str[mt_rand(0,strlen($str) - 1)];
			}

			//将验证码保存到session
			@session_start();
			$_SESSION['captcha'] = $captcha;
			

			//返回字符串
			return $captcha;
		}

		/*
		 * 验证验证码
		 * @param1 string $captcha，用户提交的验证码
		 * @return boolean，成功返回true，失败返回false
		*/
		public static function checkCaptcha($captcha1){
			//从session取出验证码进行验证
			//比较：验证码不区分大小写：全部转换后再比较
			return @(strtolower($captcha1) === strtolower($_SESSION['captcha']));
		}
	}
