<?php

	//后台初始化文件

	//字符集设置
	header("Content-Type:text/html;charset=utf-8");

	//定义目录常量
	//定义网站根目录.'\\'前一个\是转义符
	define('HOME_ROOT',str_replace('\\', '/', substr(__DIR__,0,strpos(__DIR__,'\admin\includes'))));

	//定义前台公共目录
	define('HOME_INC', HOME_ROOT.'/includes');

	//日志文件目录
	define('HOME_LOG', HOME_ROOT.'/log');

	//配置文件目录
	define('HOME_CONF', HOME_ROOT.'/conf');

	//后台目录常量
	define('ADMIN_ROOT', HOME_ROOT.'/admin');
	define('ADMIN_INC', ADMIN_ROOT.'/includes');
	define('ADMIN_TEMP', ADMIN_ROOT.'/templates');
	
	//设置错误处理机制
	@ini_set('error_reporting', E_ALL);
	@ini_set('display_errors', 1);

	//引入公共函数
	include_once  ADMIN_INC.'/functions.php';

	//加载配置文件
	//global $config;
	$config = include_once HOME_CONF.'/config.php';
	//$config = $GLOBALS['config']['mysql']['host'];

	

?>
