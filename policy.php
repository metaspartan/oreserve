<?php
	include 'php/inc.init.php';
	include 'php/class.user.php';
	include 'php/lib.recaptcha.php';
	$user = new user();

	
	include 'php/tpl/tpl.head.php';
	include 'php/tpl/tpl.policy.php';
	include 'php/tpl/tpl.footer.php';
?>