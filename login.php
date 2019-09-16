<?php
	include 'php/inc.init.php';
	include 'php/class.user.php';
	$user = new user();
	
	if ($user->logged_in) {
		header('Location: ' . $config['root'] . '/');
		exit;
	}
	
	if ($_POST['action'] == 'login') {
		$login = $user->login();
	}
	
	include 'php/tpl/tpl.head.php';
	include 'php/tpl/tpl.login.php';
	include 'php/tpl/tpl.footer.php';
?>