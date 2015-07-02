<?php

	//封装验证码图片工具类

	class Captcha{
	
		//属性
		private $width;
		private $height;
		private $strlen;    //随机字符串长度
		private $pixels;	//干扰像素点数量
		private $lines;		//干扰线数量
		private $font;		//写入字符大小

		//构造方法，初始化属性
		public function __construct($captchaInfo = array()){
		
			$this->width = isset($captchaInfo['width']) ? $captchaInfo['width'] : $GLOBALS['config']['captcha']['width'];
			$this->height = isset($captchaInfo['height']) ? $captchaInfo['height'] :$GLOBALS['config']['captcha']['height'];
			$this->strlen = isset($captchaInfo['strlen']) ? $captchaInfo['strlen'] : $GLOBALS['config']['captcha']['strlen'];
			$this->pixels = isset($captchaInfo['pixels']) ? $captchaInfo['pixels'] : $GLOBALS['config']['captcha']['pixels'];
			$this->lines = isset($captchaInfo['lines']) ? $captchaInfo['lines'] : $GLOBALS['config']['captcha']['lines'];
			$this->font = isset($captchaInfo['font']) ? $captchaInfo['font'] : $GLOBALS['config']['captcha']['font'];

		}

		/*
		 *获取验证码图片
		*/
		public function generate(){
		
			//制作画布
			$img = imagecreatetruecolor($this->width,$this->height);
			//获取背景颜色
			$color = imagecolorallocate($img,mt_rand(180,255),mt_rand(180,255),mt_rand(180,255));
			//填充背景颜色
			$bgColor = imagefill($img,0,0,$color);

			//设置干扰点
			$this->setPixels($img);

			//设置干扰线
			$this->setLines($img);

			//写入字符
			//获取文字
			//$this->getStringRandom();
			$captcha = $this->setChar($img);

			//将capta保存到session中
			$this->saveCaptcha($captcha);
			//显示图片
			//header('content-type:image/png');
			imagepng($img);


			//释放资源
			imagedestroy();
		}

		/*
		 *保存验证码图片中的字符串
		 *@parameter string $captcha 要保存到session中的$capcha
		*/
		private function saveCaptcha($captcha){
		
			//开启session
			@session_start();
			//保存captcha
			$_SESSION['captcha'] = $captcha;
		}
		/*
		 *写入字符方法
		 *@parameter1 resouce $img 需要写入字符的资源
		*/
		private function setChar($img){

			//定义一个空字符串
			$captcha = '';
		
			//循环写入字符
			for($i = 0;$i < $this->strlen;$i++){
				$start_x = ceil(($this->width / $this->strlen))-10;
				$start_y = ($this->height / 2)- 10;
				//分配字符颜色
				$charColor = imagecolorallocate($img,mt_rand(0,100),mt_rand(0,100),mt_rand(0,100));
				//获取字符
				$char = $this->getCharRandom();
				//写入字符
				imagestring($img,$this->font,mt_rand($i * $start_x + 10,($i + 1) * ($start_x)),mt_rand(0,$start_y),$char,$charColor);

				//将写入的字符连接到$captcha
				$captcha .= $char;
			}

			 return $captcha;
		}
		/*
		 *随机获取字符串
		 *return 返回一个字符
		*/
		private function getCharRandom(){
		
			//定义原始字符串
			$str = 'abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
			$char = $str[mt_rand(0,strlen($str)-1)];
			return $char;
		}
		
		/*
		 *设置干扰线方法
		 *parameter1 resouce $img 需要设置干扰点的资源
		*/
		private function setLines($img){
			
			//循环添加干扰线
			for($i = 0;$i < $this->lines;$i++){
				//分配干扰线颜色
				$lineColor = imagecolorallocate($img,mt_rand(100,180),mt_rand(100,180),mt_rand(100,180));
				imageline($img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$lineColor);
			}
		}
		/*
		 *设置干扰点方法
		 *parameter1 resouce $img 需要设置干扰点的资源
		*/
		private function setPixels($img){
		
			//循环添加干扰点
			for($i = 0;$i < $this->pixels;$i++){

				//分配干扰点颜色
				$pixelColor = imagecolorallocate($img,mt_rand(100,180),mt_rand(100,180),mt_rand(100,180));
				imagesetpixel($img,mt_rand(0,$this->width),mt_rand(0,$this->width),$pixelColor);
			}
		}

		/*
		 *验证码验证
		 *@parameter1 string $captcha 用户输入的验证码
		 *return boolean 成功返回true，失败返回false
		*/
		public static function checkCaptcha($captcha){

			//开启session
			@session_start();
			//比较用户提交的验证码和生成的验证码是否相同并返回结果
			return (strtolower($captcha) === strtolower($_SESSION['captcha']));	
		}
	}
		 