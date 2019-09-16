<?php
	include 'php/inc.init.php';
	include 'php/class.user.php';
	include 'php/class.transactions.php';
	$user = new user();
	
	if (!$user->logged_in) {
		header('Location: ' . $config['root'] . '/');
		exit;
	}
	
	if ($_POST['action'] == 'update_profile') {
		$update = $user->update_profile();
	}
	$values = $user->get_profile_values();
	
	include 'php/tpl/tpl.head.php';
	include 'php/tpl/tpl.profile.php';
	include 'php/tpl/tpl.footer.php';
?>