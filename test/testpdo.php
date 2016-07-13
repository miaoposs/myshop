<?php

	$pdo = new PDO('mysql:host=localhost;port=3306;dbname=test','root','123456');
	//var_dump($pdo);

	/*测验query的能力
	$sql = "show tables";
	$ret = $pdo->query($sql);
	var_dump($ret->fetchAll());

	循环数据集
	$sql = "select * from test";
	$ret = $pdo->query($sql)->fetchAll();
	foreach ($ret as $key) {
		var_dump($key);
		echo "<br />";
	}
	//var_dump($ret);*/

	var_dump($pdo->getattribute(PDO::ATTR_AUTOCOMMIT));
	var_dump($pdo->getattribute(PDO::ATTR_CASE));


?>