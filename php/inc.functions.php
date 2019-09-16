<?php
	function valid_username ($username) {
		return preg_match('#^[a-z0-9-_]{3,16}$#i', $username);
	}
	function username_exists ($username) {
		$username = mysqli_real_escape_string($username);
		$q = mysqli_query("SELECT * FROM `users` WHERE `user_name` = '$username'");
		return (bool) mysqli_num_rows($q);
	}
	function clean_input_data (&$item, $key) {
		if (is_string($item)) {
			$item = get_magic_quotes_gpc() ? stripslashes($item) : $item;
		}
	}
	function valid_email ($email) {
		return preg_match('#^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$#i', $email);
	}
	function email_exists ($email) {
		$q = mysqli_query("SELECT * FROM `users` WHERE `user_email` = '$email'");
		return (bool) mysqli_fetch_assoc($q);
	}
	function valid_pin ($pin) {
		return preg_match('#^[0-9]{4,4}$#', $pin);
	}
	function generate_account_number () {
		$num = 'P' . rand(1000000000, 9999999999);
		$q = mysqli_query("SELECT * FROM `users` WHERE `user_account_number` = '$num'");
		while (mysqli_num_rows($q)) {
			$num = 'P' . rand(1000000000, 9999999999);
			$q = mysqli_query("SELECT * FROM `users` WHERE `user_account_number` = '$num'");
		}
		return $num;
	}
	function valid_account_number ($account_number) {
		$account_number = mysqli_real_escape_string($account_number);
		$q = mysqli_query("SELECT * FROM `users` WHERE `user_account_number` = '$account_number'");
		return (bool) mysqli_num_rows($q);
	}
	function get_user_by_account_number ($account_number) {
		$account_number = mysqli_real_escape_string($account_number);
		$q = mysqli_query("SELECT * FROM `users` WHERE `user_account_number` = '$account_number'");
		return mysqli_fetch_assoc($q);
	}
	function send_email ($recipient, $subject, $template, $data) {
		global $config;
		ob_start();
		extract($data);
		include rtrim($_SERVER['DOCUMENT_ROOT'], '/') . $config['root'] . '/email_templates/' . $template;
		$content = ob_get_clean();
		@mail($recipient, $subject, $content, "From: {$config[email][name]} <{$config[email][address]}>\r\nContent-Type: text/html\r\n");
	}
	function generate_txn_id () {
		$txn_id = rand(10000, 99999) . rand(10000, 99999) . rand(10000, 99999) . rand(10000, 99999);
		$q = mysqli_query("SELECT * FROM `transactions` WHERE `txn_real_id` = $txn_id");
		while (mysqli_num_rows($q)) {
			$txn_id = rand(10000, 99999) . rand(10000, 99999) . rand(10000, 99999) . rand(10000, 99999);
			$q = mysqli_query("SELECT * FROM `transactions` WHERE `txn_real_id` = $txn_id");
		}
		return $txn_id;
	}
?>