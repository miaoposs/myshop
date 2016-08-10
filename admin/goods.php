<?php

	$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'list';

	include_once 'includes/ini.php';

	if ($act == 'list') 
	{
		include_once ADMIN_TEMP.'/goods_list.html';
	}


?>