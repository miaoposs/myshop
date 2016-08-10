<?php
	//后台权限请求处理

	$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'login';

	include_once 'includes/ini.php';

	if ($act == 'login') 
	{
		include_once ADMIN_TEMP.'/login.html';
	} 
	//退出时清除session信息和与session有关的cookie信息
	else if ($act == 'logout') 
	{
		session_destroy();
		include_once ADMIN_TEMP."/login.html";
	}
	//请求加载验证码
	elseif ($act == 'captcha') {
		$_SESSION['captcha'] = admin_captcha();
	}
	else 
	{
		$username = isset($_POST['username']) ? $_POST['username'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		$captcha = isset($_POST['captcha'])  ? $_POST['captcha'] : '';

		//用户勾选了记住登录信息，该信息将在一小时后过期
		if (isset($_POST['remember'])) {
			setcookie('username',$username,time()+60*60);
		}

		if(empty($username) || empty($password) || empty($captcha))
		{
			admin_redirect('privilege.php','用户名、密码、验证码均不能为空',3);
		}else
		{
			//验证验证码是否正确
			if (strtolower($captcha) != strtolower($_SESSION['captcha'])) {
				admin_redirect('privilege.php','验证码有误',3);
			}

			//检查用户名、密码是否正确
			$admin = new Admin();
			if($admin->checkByUsernameAndPassword($username,$password))
			{
				$_SESSION['username'] = $username;
				admin_redirect('index.php','登录成功，转到首页',1);
			}else
			{
				admin_redirect('privilege.php','用户名与密码有误',3);
			}
		}
	}

?>