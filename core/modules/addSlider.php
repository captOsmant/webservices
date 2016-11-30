<?php
	require "config";
	$sliders = $catalog->addItem(array("Новый слайдер",1,''));
	if(mysql_error()) echo mysql_error();
	