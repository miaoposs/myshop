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







?>