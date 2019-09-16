<?php
	include 'php/inc.init.php';
	include 'php/class.user.php';
	include 'php/lib.recaptcha.php';
	$user = new user();
	
	if ($user->logged_in) {
		header('Location: ' . $config['root'] . '/');
		exit;
	}
	
	if ($_POST['action'] == 'register') {
		$register = $user->register();
	}
	
	include 'php/tpl/tpl.head.php';
	include 'php/tpl/tpl.register.php';
	include 'php/tpl/tpl.footer.php';
?>