<?php
	include 'php/inc.init.php';
	include 'php/class.user.php';
	include 'php/class.transactions.php';
	$user = new user();
	$transactions = new transactions();
	
	if (!$user->logged_in) {
		header('Location: ' . $config['root'] . '/');
		exit;
	}
	
	include 'php/tpl/tpl.head.php';
	include 'php/tpl/tpl.account.php';
	include 'php/tpl/tpl.footer.php';
?>