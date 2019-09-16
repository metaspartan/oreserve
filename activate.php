<?php
	include 'php/inc.init.php';
	include 'php/class.user.php';
	$user = new user();
	
	if ($user->logged_in) {
		header('Location: ' . $config['root'] . '/');
		exit;
	}
	
	$activate = $user->activate();
	
	include 'php/tpl/tpl.head.php';
	include 'php/tpl/tpl.activate.php';
	include 'php/tpl/tpl.footer.php';
?>