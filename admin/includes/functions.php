<?php

	//跳转函数
	function admin_redirect($url = 'privilege.php',$msg = '请先登录',$time = 3)
	{
		
		include_once ADMIN_TEMP.'/redirect.html';

		exit;
	}

	//自动加载类文件
	function __autoload($class)
	{
		//默认从根目录的includes文件夹中寻找类文件,不存在再到admin目录下寻找
		if (is_file(HOME_INC."/$class.class.php")) {
			include_once HOME_INC."/$class.class.php";
		} else {
			include_once ADMIN_INC."/$class.class.php";
		}
		
	}

	//随机数产生函数
	function admin_captcha()
	{
		//生成随机字符串
		$strs='adbcefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$captcha = '';
		for($i=4;$i>0;$i--)
		{
			$captcha .= substr($strs, rand(0,61),1);
		}
		//生成画布
		$img = imagecreatetruecolor(145, 25);
		//得到颜色
		$white = imagecolorallocate($img, 255, 255, 255);
		$textcolor = imagecolorallocate($img,0,0,255);
		//在画布上生成干扰线
		for ($i=0; $i < 10 ; $i++) { 
			$lines = imageline($img, mt_rand(0,200), mt_rand(0,50), mt_rand(0,200), mt_rand(0,50), $textcolor);
		}
		//填充画布颜色
		imagefill($img, 0, 0, $white);
		//将字符串写在画布上
		imagestring($img, 5, 50, 1, $captcha, $textcolor);
		//调整输出流为png图片格式
		header('Content-Type:image/png');
		//向浏览器输出验证码图片
		imagepng($img);
		imagedestroy($img);
		return $captcha;
	}







?>