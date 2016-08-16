<?php
class goods extends DB{

	protected $table = 'goods';


	/**
	* 根据choose的值选择显示（返回）不同的商品数据
	* @param1   integer   choose     选择操作类型
	* @param2   integer   goods_id   商品的编号，默认值为null,参数有默认值，所以在调用的时候若不需要，可以不用传值 
	* @return   bool|resource
	*/
	public function getGoodsInfo($choose,$page=1,$goods_id=null)
	{
		$pagesize = $GLOBALS['config']['admin_pagecounts'];
		$start = ($page-1)*$pagesize;
		switch ($choose) {
			case 0:
				$sql = "select * from {$this->db_getTableName()} where is_delete=0 limit {$start},{$pagesize}";
				break;

			case 1:
				$sql = "select * from {$this->db_getTableName()} where is_delete=0 and goods_id={$goods_id}";
				break;

			case 2:
				$sql = "select * from {$this->db_getTableName()} where is_delete=1";
				break;
			
			default:
				return false;
				break;
		}
		return $this->db_getInfo($sql);
	}


	/**
	* 获得商品(或回收站商品)的数量
	*/
	public function getCounts($choose)
	{
		switch ($choose) {
			case 0:
				$sql = "select count(*) counts from {$this->db_getTableName()} where is_delete=0";
				break;
			
			case 1:
				$sql = "select count(*) counts from {$this->db_getTableName()} where is_delete=1";
				break;
		}
		
		return $this->db_getInfo($sql)[0]['counts'];
	}


	/**
	* 回收商品或将商品放入垃圾篓，更改商品is_delete的值
	* @param1   integer   goods_id   商品的编号
	* @param2  integer    choose     只能为0或者1
	* @return  bool|infect row      
	*/
	public function trashOrRestore($goods_id,$choose)
	{
		$sql = "update {$this->db_getTableName()} set is_delete={$choose} where goods_id={$goods_id}";
		return $this->db_update($sql);
	}


	/**
	* 删除商品信息
	* @param   integer   goods_id   商品的编号
	* @return  bool|infect row
	*/
	public function deleteGoodsInfo($goods_id)
	{
		$sql = "delete from {$this->db_getTableName()} where goods_id={$goods_id}";
		return $this->db_delete($sql);
	}
}



?>