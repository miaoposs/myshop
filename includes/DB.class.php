	<?php

	/*
		关于DB类所有错误都写入的日志，出现错误都是以结束程序作为处理方式。
	*/

	class DB
	{

		private $host;
		private $port;
		private $user;
		private $pwd;
		private $dbname;
		private $charset;
		private $prefix;
		private $link;

		//定义构造函数
		public function __construct($arr = array())
		{
			$this->host = isset($arr['host']) ? $arr['host'] : $GLOBALS['config']['mysql']['host'];
			$this->port = isset($arr['host']) ? $arr['port'] : $GLOBALS['config']['mysql']['port'];
			$this->user = isset($arr['user']) ? $arr['user'] : $GLOBALS['config']['mysql']['user'];
			$this->pwd = isset($arr['pwd']) ? $arr['pwd'] : $GLOBALS['config']['mysql']['pwd'];
			$this->dbname = isset($arr['dbname']) ? $arr['dbaname'] : $GLOBALS['config']['mysql']['dbname'];
			$this->charset = isset($arr['charset']) ? $arr['charset'] : $GLOBALS['config']['mysql']['charset'];
			$this->prefix = isset($arr['prefix']) ? $arr['prefix'] : $GLOBALS['config']['mysql']['prefix'];
			
		}

		/*
		*连接数据库
		*/
		private function connect()
		{
			$this->link = mysql_connect($this->host.':'.$this->port,$this->user,$this->pwd);

			if(!$this->link)
			{
				file_put_contents(HOME_LOG.'/'.date('Y_m_d').".txt", "database link error",FILE_APPEND);
				exit("数据库连接出现问题，请查看日志以确定问题所在~");
			}
		}

		/*
		*mysql_quary
		*@param string $sql,需要执行的sql语句
		*@return mixed,返回语句执行结果
		*/
		private function db_query($sql)
		{
			$this->connect();
			$this->selectDatabase();
			$this->setCharset();
			//防止sql注入
			//$sql = addslashes($sql);
			$res = mysql_query($sql);

			if(!$res)
			{
				file_put_contents(HOME_LOG.'/'.date('Y_m_d').".txt", mysql_errno().':'.mysql_error()."\r\n",FILE_APPEND);
				exit("sql语句执行出现问题，请查询日志以确定问题所在~");
			}
			return $res;
		}

		/*
		*设置字符集
		*/
		private function setCharset()
		{
			if (!mysql_set_charset($this->charset)) {
				file_put_contents(HOME_LOG.'/'.date('Y_m_d').".txt", mysql_errno().':'.mysql_error()."\r\n",FILE_APPEND);
				exit("字符集设置过程出现问题，请查询日志以确定问题所在~");
			}

		}

		/*
		*选择数据库
		*/
		private function selectDatabase()
		{
			if (!mysql_select_db($this->dbname)) {
				file_put_contents(HOME_LOG.'/'.date('Y_m_d').".txt", mysql_errno().':'.mysql_error()."\r\n",FILE_APPEND);
				exit("选择数据库的过程中出现问题，请查询日志以确定问题所在~");
			}
		}

		/*
		*插入数据
		*@param string $sql,要执行的sql语句
		*@retrun mixed,由于允许批量插入，当发生批量插入时返回受影响的行数；单条插入语句时，若有自增字段则返回ID值，否则返回受影响的行数
		*为了鉴别返回的是受影响的行数还是ID值，用数组装载id值返回
		*/
		public function db_insert($sql)
		{
			$ret = array();
			$this->db_query($sql);
			if (($num = mysql_affected_rows()) > 1 ) {
				return $num;
			}
			else if($num == 1)
			{
				return ($ret["id"]=mysql_insert_id()) == 0 ? $num : $ret;
			}
		}

		/*
		*删除数据
		*@param string $sql,要执行的sql语句
		*@retrun mixed,成功返回受影响的行数，失败返回flase
		*/
		public function db_delete($sql)
		{
			$this->db_query($sql);
			return mysql_affected_rows() ? mysql_affected_rows() : flase;
		}

		/*
		*更新数据
		*@param string $sql,要执行的sql语句
		*@retrun mixed,成功返回受影响的行数，失败返回flase
		*/
		public function db_update($sql)
		{
			$this->db_query($sql);
			return mysql_affected_rows() ? mysql_affected_rows() : flase;
		}

		/*
		*获取所有数据,只返回关联数组
		*@param string $sql,要执行的sql语句
		*@retrun mixed,成功返回结果数组，失败返回flase
		*/
		public function db_getInfo($sql)
		{
			$res = $this->db_query($sql);
			if (mysql_num_rows($res)) {
				$arr = array();
				while ($row = mysql_fetch_assoc($res)) {
					$arr[] = $row;
				}
				return $arr;
			}
			return false;
		}


		//__sleep方法
		public function __sleep(){
			//返回需要保存的属性的数组
			return array('host','port','user','pass','dbname','charset','prefix');
			
		}

		//__wakeup方法
		public function __wakeup(){
			//连接资源
			$this->connect();
			//设置字符集和选中数据库
			$this->setCharset();
			$this->setDbname();
		}

		/*
		*获取表名
		*@return string,返回当前操作的表全名
		*/
		public function db_getTableName()
		{
			return $this->prefix.$this->table;
		}




	}



?>