<?php

	require "config";
	if(!$_GET['id']) die("Не передана папка для удаления!");
	
	Imager::removeFolder($_GET['id']);
	if(!mysql_error()) echo "OK";
	else echo mysql_error();