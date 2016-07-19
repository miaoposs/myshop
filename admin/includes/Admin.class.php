
<?php
	
	class Admin extends DB
	{
		protected $table = 'admin';

		/*验证继承关系中构造
		函数覆盖问题用的
		public function __construct()
		{
			echo DB::__construct();
			echo 'admin';
			//echo $this->host;
		}*/

		/*
		*@param1 string username，用户名
		*@param2 string password，密码
		*
		*/
		public function checkByUsernameAndPassword($username,$password)
		{
			$password = md5($password);
			$sql = "select * from {$this->db_getTableName()} where username = '{$username}' and password = '{$password}' ";
			return $this->db_getInfo($sql);
			
		}

		
	}

	




?>