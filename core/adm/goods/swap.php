<?php

	require "config";	
	$level = $_GET['level'] ? $_GET['level'] : 0;
	$catalog->swap($_GET['b'], $_GET['a'], $level);
	
	echo mysql_error();
	
	require "list.php";
?>