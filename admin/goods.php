<?php

	$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'list';

	include_once 'includes/ini.php';

	$goods = new goods;

	if ($act == 'list') {

		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$goods_list = $goods->getGoodsInfo(0,$page);
		$page_str = page::show('goods.php?act=list',$goods->getCounts(0),$page);
		include_once ADMIN_TEMP.'/goods_list.html';

	}elseif ($act == 'add') {

		include_once ADMIN_TEMP.'/goods_add.html';

	}elseif ($act == 'remove') {

		$goods_id = isset($_GET['goods_id']) ? $_GET['goods_id'] : '';
		if (!empty($goods_id)) {

			if (!$goods->getGoodsInfo(1,$goods_id)) {
				admin_redirect('goods.php','您选择的商品编号不存在',2);
			}

			if ($goods->trashOrRestore($goods_id,1)) {
				admin_redirect('goods.php','成功将商品放入回收站',2);
			}else{
				admin_redirect('goods.php','商品回收操作失败',2);
			}
		}

	}elseif ($act == 'trash') {

		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$goods_trash = $goods->getGoodsInfo(2,$page);
		$page_str = page::show('goods.php?act=trash',$goods->getCounts(1),$page);
		include_once ADMIN_TEMP.'/goods_trash.html';
		
	}elseif ($act == 'restore') {
		
		$goods_id = isset($_GET['goods_id']) ? $_GET['goods_id'] : '';
		if ($goods->trashOrRestore($goods_id,0)) {
			admin_redirect('goods.php?act=trash','商品还原成功',2);
		}else{
			admin_redirect('goods.php','商品还原失败',2);
		}

	}elseif ($act == 'delete') {
		
		$goods_id = isset($_GET['goods_id']) ? $_GET['goods_id'] : '';
		if ($goods->deleteGoodsInfo($goods_id)) {
			admin_redirect('goods.php?act=trash','商品已彻底删除',2);
		}else{
			admin_redirect('goods.php?act=trash','商品删除失败',2);
		}

	}


?>