<?php
	session_start();

	$_session["strings"]="test";

	echo $_session["strings"]."<br />";
	var_dump($_session);

?>