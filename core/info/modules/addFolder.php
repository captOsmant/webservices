<?php
	require "config";
	
	$parent = $_GET['parent'];
	$name = $_GET['name'];
	
	$Q = "INSERT INTO cata_manual VALUES (default, $parent,  1, '$name','', '','')";
	$sql->query($Q);
	
	if(mysql_error()) echo mysql_error();