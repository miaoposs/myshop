<?php

	class category extends DB
	{
		protected $table = 'category';


		public function getAllCategories()
		{
			$sql = "select * from {$this->db_getTableName()}";
			$categories = $this->db_getInfo($sql);
			return $this->noLimitCategory($categories);
		}


		/**
		 * 无限极分类
		 * @param1 array    categories  数据库查询返回的商品类别数据；  
		 * @param2 integer  parent_id   当前递归层所要收集的商品分类，默认为0；
		 * @param3 integer  level       标志当前递归层，同时也标志了该层商品的级别，默认为0；
		 * @return array    ret         返回分类后的数组;
		 */


		public function noLimitCategory($categories,$parent_id=0,$level=0)
		{
			static $ret = array();

			foreach ($categories as $row) 
			{
				if ($row['parent_id'] == $parent_id) 
				{
					$row['level'] = $level;
					$ret[] = $row;
					$this->noLimitCategory($categories,$row['cat_id'],$level+1);
				}
			}
			return $ret;
		}


		/*
		*验证插入的分类信息在选定的父分类下是否有同名分类
		*@param1 integer parent_id 父分类的id
		*@param2 string  cat_name  分类名称
		*@return boolean           存在同名分类返回ture，否则返回false
		*/
		public function checkWithParentidAndName($parent_id,$cat_name)
		{
			$sql = "select * from {$this->db_getTableName()} where parent_id={$parent_id} and cat_name='{$cat_name}'";
			return $this->db_getInfo($sql);
		}


		/*
		*插入分类信息
		*@param1 string    cat_name    分类名称
		*@param2 integer   parent_id   父级id
		*@param3 integer   sort_order  排序号
		*@return boolean               成功返回cat_id，失败返回false
		*/
		public function insertCategory($cat_name,$parent_id,$sort_order)
		{
			$sql = "insert into {$this->db_getTableName()}(cat_name,parent_id,sort_order) values('{$cat_name}',{$parent_id},{$sort_order})";
			return $this->db_insert($sql);
		}


		/*
		*检查当前类别信息是否可以删除，规则是有子节点的不能删除
		*@param    integer   cat_id   当前分类的id值
		*@return   bollean            删除成功返回ture，否则返回false
		*/
		public function canDelete($cat_id)
		{
			$sql = "select * from {$this->db_getTableName()} where parent_id={$cat_id}";
			if (!$this->db_getInfo($sql)) 
			{
				$sql = "delete from {$this->db_getTableName()} where cat_id={$cat_id}";
				return $this->db_delete($sql);
			}
			else
			{
				return false;
			}
		}

		/*
		*根据cat_id查询分类信息
		*@param    integer    cat_id   当前分类的id
		*@return   array      ret      返回根据id查询到的信息
		*/
		public function selectById($cat_id)
		{
			$sql = "select * from {$this->db_getTableName()} where cat_id={$cat_id}";
			return $this->db_getInfo($sql);
		}

		/*
		*根据cat_id修改分类信息
		*@param1 integer   cat_id      分类id
		*@param2 string    cat_name    分类名称
		*@param3 integer   parent_id   父级id
		*@param4 integer   sort_order  排序号
		*@return boolean               成功返回受影响的行数，失败返回false
		*/
		public function updateCategory($cat_id,$cat_name,$parent_id,$sort_order)
		{
			$sql = "update {$this->db_getTableName()} set cat_name='{$cat_name}',parent_id={$parent_id},sort_order={$sort_order} where cat_id={$cat_id}";
			return $this->db_update($sql);
		}

	}





	/*
		*自己写的无限极分类	
		
		public function noLimitCategory()
		{
			$sql = "select * from {$this->db_getTableName()}";
			$ret = $this->db_getInfo($sql);
			$list = array();
			$i = 0;
			foreach ($ret as $category) 
			{
				if( isset($category['pop']) || $category['pop'] == true)
				{
					break;
				}
					$children = array();
					$j = 0;
					foreach ($ret as $row) 
					{
						if ($category['cat_id'] == $row['parent_id']) 
						{
							$children[$j++] = $row;
							$row['pop'] = true;
						}
					}
					$category['children'] = $children;
					$list[$i++] = $category;
			}
			return $list;
			
		}*/


?>