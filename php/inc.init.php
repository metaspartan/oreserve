<?php
	set_include_path(dirname(__FILE__));
	include 'inc.config.php';
	include 'inc.functions.php';
	
	@mysqli_connect($config['mysql']['host'], $config['mysql']['user'], $config['mysql']['pass']) && @mysqli_select_db($config['mysql']['db']) || die(mysqli_error());
	
	array_walk_recursive($_GET, 'clean_input_data');
	array_walk_recursive($_POST, 'clean_input_data');
	array_walk_recursive($_COOKIE, 'clean_input_data');
?>