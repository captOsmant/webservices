<?php

	require "config";
	if(!$_GET['id']) die("Не передано изображение для удаления!");
	
	Imager::removeImage($_GET['id']);
	if(!mysql_error()) echo "OK";
	else echo mysql_error();