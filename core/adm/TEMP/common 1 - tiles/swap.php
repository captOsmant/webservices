<?php

	require "config";	
	$catalog->swap($_GET['b'], $_GET['a'], 0);
	
	echo mysql_error();
	
	require "list.php";
?>