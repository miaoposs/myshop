<?php
	
	include_once "./includes/ini.php";

	$act = isset($_POST["act"]) ? $_POST["act"] : "login";
	if($act != "login")
	{
		$username = isset($_POST["username"]) ? $_POST["username"] : "";
		$password = isset($_POST["password"]) ? $_POST["password"] : "";
		$password = md5($password);
		if ($username && $password) {
			$sqlstr = "insert into ecs_admin values('".$username."','".$password."')";
			$db = new DB();
			if ($db->db_insert($sqlstr)>=0) {
				echo "插入成功";
			}
			else
			{
				echo "插入失败";				
			}
		}
	}
	else
	{
		include_once "./templates/template.html";
	}


?>