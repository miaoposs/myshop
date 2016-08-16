<?php

	//分页类
	class Page{
		

		/*
		 * 分页方法
		 * @param1   string    $basename    请求的脚本文件
		 * @param2   int       $counts      总记录数
		 * @param3   int       $page        当前页码
		 * @return   string                 具有分页点击a标签的字符串
		 *
		 * 示例：总共多少条记录，每页显示多少条记录，当前是第几页，<a>首页</a>，<a>前一页</a>，后一页，末页
		*/
		public static function show($basename,$counts,$page = 1){
			//计算出总页数
			$pagesize = $GLOBALS['config']['admin_pagecounts'];
			$pageCounts = ceil($counts / $pagesize);

			//计算上一页和下一页
			$prev = ($page == 1) ? $page : ($page - 1);
			$next = ($page == $pageCounts) ? $page : ($page + 1);
			
			//使用定界符来平凑字符串
			$str = <<<ENDF
			<span id="str_page">
			总共有{$counts}条记录,当前是第{$page}页&nbsp;&nbsp;
			<a href="{$basename}&page=1">首页</a>
			<a href="{$basename}&page={$prev}">上一页</a>
			<a href="{$basename}&page={$next}">下一页</a>
			<a href="{$basename}&page={$pageCounts}">末页</a>&nbsp;&nbsp;</span>
ENDF;
			return $str;

		}

	}