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
	
	if ($_POST['action'] == 'send_money') {
		$send = $transactions->send_money();
	}
	
	include 'php/tpl/tpl.head.php';
	include 'php/tpl/tpl.send-money.php';
	include 'php/tpl/tpl.footer.php';
?>