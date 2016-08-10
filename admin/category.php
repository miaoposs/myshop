<?php

	include_once 'includes/ini.php';

	$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'list';

	$category = new category();

	if ($act == 'list') 
	{
		$categories = $category->getAllCategories();
		include_once ADMIN_TEMP.'/category_list.html';
	}
	else if ($act == 'add') 
	{
		$categories = $category->getAllCategories();
		include_once ADMIN_TEMP.'/category_add.html';
	}
	else if ($act == 'insert' || $act == 'update') 
	{
		$cat_name = isset($_POST['cat_name']) ? $_POST['cat_name'] : '';
		$parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : '';
		$sort_order = isset($_POST['sort_order']) ? $_POST['sort_order'] : '';

		if (empty($cat_name))
		{
			admin_redirect('category.php?act=add','分类名称不能为空',2);
		}

		if (!is_numeric($sort_order)) 
		{
			admin_redirect('category.php?act=add','排序字段只能为整数',2);
		}

		if (strlen($cat_name) > 60) 
		{
			admin_redirect('category.php?act=add','分类名称长度不能超过20个字符',2);
		}
		
		if ($category->checkWithParentidAndName($parent_id,$cat_name)) 
		{
			if ($act == 'insert') {
				admin_redirect('category.php?act=add','您输入的分类已存在',2);
			}
			else
			{
				admin_redirect('category.php','您所选择的上级分类中已存在当前要修改的分类',3);
			}
			
		}
		else
		{
			if ($act == 'insert') 
			{
				$category->insertCategory($cat_name,$parent_id,$sort_order);
				admin_redirect('category.php','插入成功',1);
			}
			else
			{
				$cat_id = $_POST['cat_id'];
				$category->updateCategory($cat_id,$cat_name,$parent_id,$sort_order);
				admin_redirect('category.php','更新成功',1);
			}
		}
	}
	elseif ($act == 'delete') 
	{
		$cat_id = $_GET['cat_id'];
		if ($category->canDelete($cat_id)) 
		{
			admin_redirect('category.php','删除成功',1);
		}
		else
		{
			admin_redirect('category.php','非末级分类不能删除',2);
		}
	}
	elseif ($act == 'edit') 
	{
		$cat_id = $_GET['cat_id'];
		$info = $category->selectByid($cat_id)[0];
		$categories = $category->getAllCategories();
		include_once ADMIN_TEMP.'/category_edit.html';
	}
	

?>