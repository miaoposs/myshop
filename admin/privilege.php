<?php
	//后台权限请求处理

	$act = isset($_POST['act']) ? $_POST['act'] : 'login';

	include_once 'includes/ini.php';


	if ($act == 'login') 
	{
		include_once ADMIN_TEMP.'/login.html';
	} 
	else 
	{
		$username = isset($_POST['username']) ? $_POST['username'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		if(empty($username) || empty($password))
		{
			admin_redirect('privilege.php','用户名密码不能为空',3);
		}else
		{
			$admin = new Admin();
			if($admin->checkByUsernameAndPassword($username,$password))
			{
				admin_redirect('index.php','登录成功，转到首页',1);
			}else
			{
				admin_redirect('privilege.php','用户名与密码有误',3);
			}
		}
	}
	
?>