<?php

	require_once "config";
	
	$catalog->addItem($DEFAULT[0]);
	echo mysql_error();
	
	require_once "list.php";

?>