<?php
	require "config";
	$catalog->editValuesOf($_POST['id'],0,$_POST);
	echo mysql_error();
	