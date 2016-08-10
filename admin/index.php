<?php
	
	$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
	include_once "includes/ini.php";

	if(isset($_SESSION["username"]))
	{
		include_once "templates/index.html";
		$username = $_SESSION["username"];
	}
	else
	{
		admin_redirect('privilege.php','非法登录，即将转到登录界面',3);
	}

	

	


