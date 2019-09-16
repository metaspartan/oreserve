<?php
	include 'php/inc.init.php';
	include 'php/class.user.php';
	$user = new user();
	$change = $user->change_email();
	
	include 'php/tpl/tpl.head.php';
	include 'php/tpl/tpl.change_email.php';
	include 'php/tpl/tpl.footer.php';
?>