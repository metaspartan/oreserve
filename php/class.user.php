<?php
	class user {
		
		var $logged_in = false, $is_admin = false;
		var $info = array();
		
		function user () {
			if (isset($_COOKIE['user']) || isset($_COOKIE['pass'])) {
				$unset = false;
				$user_id = mysqli_real_escape_string($_COOKIE['user']);
				$q = mysqli_query("SELECT * FROM `users` LEFT JOIN `logins` ON `login_user_id` = `user_id` WHERE `user_id` = '$user_id' ORDER BY `login_id` DESC");
				if (mysqli_num_rows($q)) {
					$user = mysqli_fetch_assoc($q);
					if ($user['user_pass'] === $_COOKIE['pass']) {
						$banned = false;
						$q = mysqli_query("SELECT * FROM `bans` WHERE (`ban_user_id` = $user[user_id] OR (`ban_ips` LIKE '$_SERVER[REMOTE_ADDR]%' OR `ban_ips` LIKE '%$_SERVER[REMOTE_ADDR]' OR `ban_ips` LIKE '%|$_SERVER[REMOTE_ADDR]|%')) AND `ban_until` > UNIX_TIMESTAMP(NOW())");
						if (mysqli_num_rows($q)) {
							$banned = true;
						}
						if ($user['user_status'] != '0' && $user['user_status'] != '2' && !$banned) {
							if (strlen($user['login_id'])) {
								if ($user['login_ip'] != $_SERVER['REMOTE_ADDR']) {
									$unset = true;
								}
							}
							if (!$unset) {
								$q = mysqli_query("SELECT * FROM `logins` WHERE `login_user_id` = $user[user_id] AND `login_ip` != '$_SERVER[REMOTE_ADDR]' ORDER BY `login_id` DESC");
								$r = mysqli_fetch_assoc($q);
								$user['last_ip'] = $r['login_ip'];
								if (!$user['last_ip']) {
									$user['last_ip'] = $_SERVER['REMOTE_ADDR'];
								}
								$this->logged_in = true;
								$this->is_admin = $user['user_status'] == '3';
								$this->info = $user;
								$this->set_user_cookies($user);
							}
						} else {
							$unset = true;
						}
					} else {
						$unset = true;
					}
				} else {
					$unset = true;
				}
				if ($unset) {
					$this->unset_user_cookies();
				}
			}
		}
		
		function login () {
			global $config;
			$errors = array();
			$values = array();
			$success = false;
			
			$username = mysqli_real_escape_string($_POST['username']);
			$q = mysqli_query("SELECT * FROM `users` WHERE `user_name` = '$username'");
			if (mysqli_num_rows($q)) {
				$values['username'] = $_POST['username'];
				$user = mysqli_fetch_assoc($q);
				if ($user['user_pass'] === md5($_POST['password'])) {
					if ($user['user_pin'] === $_POST['pin']) {
						$q = mysqli_query("SELECT * FROM `bans` WHERE (`ban_user_id` = $user[user_id] OR (`ban_ips` LIKE '$_SERVER[REMOTE_ADDR]%' OR `ban_ips` LIKE '%$_SERVER[REMOTE_ADDR]' OR `ban_ips` LIKE '%|$_SERVER[REMOTE_ADDR]|%')) AND `ban_until` > UNIX_TIMESTAMP(NOW())");
						if (mysqli_num_rows($q)) {
							$r = mysqli_fetch_assoc($q);
							$errors['banned'] = 'Your account and/or IP address has been banned until <strong>' . date($config['date']['with_time'], $r['ban_until']) . '</strong>';
						} elseif ($user['user_status'] == '0') {
							$errors['activate'] = 'Your account has not been activated yet';
						} elseif ($user['user_status'] == '2') {
							$errors['banned'] = 'Your account has been banned';
						} else {
							$q = mysqli_query("INSERT INTO `logins` SET `login_user_id` = $user[user_id], `login_ip` = '$_SERVER[REMOTE_ADDR]', `login_date` = UNIX_TIMESTAMP(NOW())");
							$this->logged_in = true;
							$this->is_admin = $user['user_status'] == '3';
							$this->info = $user;
							$this->set_user_cookies($user);
							$success = true;
						}
					} else {
						$errors['pin'] = 'You did not enter the correct PIN';
					}
				} else {
					$errors['password'] = 'The password you entered was invalid';
				}
			} else {
				$errors['username'] = 'The username you entered was not found';
			}
			
			return array('errors' => $errors, 'values' => $values, 'success' => $success);
		}
		
		function register () {
			global $config;
			$errors = array();
			$values = array();
			$success = false;
			
			if (!strlen($_POST['name'])) {
				$errors['name'] = 'You did not enter your full name';
			} else {
				$values['name'] = $_POST['name'];
			}
			
			if (!valid_username($_POST['username'])) {
				$errors['username'] = 'Your username must be at least 3 characters in length, containing only letters, numbers, underscores and dashes';
			} else {
				if (username_exists($_POST['username'])) {
					$errors['username'] = 'The username you entered is already in use';
				} else {
					$values['username'] = $_POST['username'];
				}
			}
			
			if (!valid_email($_POST['email'])) {
				$errors['email'] = 'The email address you entered was invalid';
			} else {
				if (email_exists($_POST['email'])) {
					$errors['email'] = 'The email address you entered is already in use';
				} else {
					$values['email'] = $_POST['email'];
				}
			}
			
			if (strlen($_POST['password']) < 4) {
				$errors['password'] = 'Your password must be at least 4 characters in length';
			} else {
				if ($_POST['password'] !== $_POST['password2']) {
					$errors['password2'] = 'The confirmation password you entered was incorrect';
				}
			}
			
			if (!array_key_exists($_POST['country'], $config['countries'])) {
				$errors['country'] = 'You did not select a valid country';
			} else {
				$values['country'] = $_POST['country'];
			}
			
			if (!valid_pin($_POST['pin'])) {
				$errors['pin'] = 'Your pin must be 4 numbers';
			} else {
				$values['pin'] = $_POST['pin'];
			}
			
			$resp = recaptcha_check_answer($config['recaptcha']['private'], $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
			if (!$resp->is_valid) {
				$errors['captcha'] = 'You did not enter the correct security code';
			}
			
			if (!count($errors)) {
				$account_number = generate_account_number();
				$name = mysqli_real_escape_string($_POST['name']);
				$password = md5($_POST['password']);
				$hash = md5(crypt(uniqid(), md5(time() * rand(10000, 99999))));
				$q = mysqli_query("INSERT INTO `users` SET `user_account_number` = '$account_number', `user_name` = '$_POST[username]', `user_fullname` = '$name', `user_email` = '$_POST[email]', `user_pass` = '$password', `user_country` = '$_POST[country]', `user_pin` = '$_POST[pin]', `user_date` = UNIX_TIMESTAMP(NOW()), `user_hash` = '$hash', `user_ip` = '$_SERVER[REMOTE_ADDR]'");
				$insert_id = mysqli_insert_id();
				$q = mysqli_query("SELECT * FROM `users` WHERE `user_id` = '$insert_id'");
				$user = mysqli_fetch_assoc($q);
				send_email($_POST['email'], 'Activate your account', 'activate_account.php', $user);
				$success = true;
			}
			
			return array('errors' => $errors, 'values' => $values, 'success' => $success);
		}
		
		function activate () {
			global $config;
			$success = false;
			
			$hash = mysqli_real_escape_string($_GET['hash']);
			$q = mysqli_query("SELECT * FROM `users` WHERE `user_hash` = '$hash' AND `user_status` = 0");
			if (mysqli_num_rows($q)) {
				$user = mysqli_fetch_assoc($q);
				$q = mysqli_query("UPDATE `users` SET `user_status` = 1, `user_hash` = '' WHERE `user_id` = '$user[user_id]'");
				$success = true;
			}
			
			return $success;
		}
		
		function change_email () {
			global $config;
			$success = false;
			
			$hash = mysqli_real_escape_string($_GET['hash']);
			$q = mysqli_query("SELECT * FROM `email_changes` WHERE `change_hash` = '$hash'");
			if (mysqli_num_rows($q)) {
				$change = mysqli_fetch_assoc($q);
				$q = mysqli_query("UPDATE `users` SET `user_email` = '$change[change_email]' WHERE `user_id` = '$change[change_user_id]'");
				$q = mysqli_query("DELETE FROM `email_changes` WHERE `change_id` = $change[change_id]");
				$success = true;
			}
			
			return $success;
		}
		
		function logout () {
			$this->unset_user_cookies();
		}
		
		function set_user_cookies ($user) {
			global $config;
			setcookie('user', $user['user_id'], time() + $config['login_expires'], $config['root']);
			setcookie('pass', $user['user_pass'], time() + $config['login_expires'], $config['root']);
		}
		
		function unset_user_cookies () {
			global $config;
			setcookie('user', '', time() - $config['login_expires'], $config['root']);
			setcookie('pass', '', time() - $config['login_expires'], $config['root']);
		}
		
		function get_profile_values () {
			$q = mysqli_query("SELECT * FROM `users` WHERE `user_id` = {$this->info[user_id]}");
			$r = mysqli_fetch_assoc($q);
			$q = mysqli_query("SELECT * FROM `logins` WHERE `login_user_id` = {$this->info[user_id]} GROUP BY `login_ip` ORDER BY `login_id` DESC LIMIT 5");
			$r['ips'] = mysqli_fetch_assoc($q);
			return $r;
		}
		
		function update_profile () {
			global $config;
			$errors = array();
			$values = array();
			$success = false;
			$change_email = false;
			$skip_password = false;
			$skip_pin = false;
			
			if (md5($_POST['old_password']) === $this->info['user_pass']) {
				
				if ($this->info['user_email'] != $_POST['email']) {
					if (!valid_email($_POST['email'])) {
						$errors['email'] = 'The email address you entered was invalid';
					} else {
						if (email_exists($_POST['email'])) {
							$errors['email'] = 'The email address you entered is already in use';
						} else {
							$change_email = true;
							$values['email'] = $_POST['email'];
						}
					}
				}
				
				if (strlen($_POST['password'])) {
					if (strlen($_POST['password']) < 4) {
						$errors['password'] = 'Your password must be at least 4 characters in length';
					} else {
						if ($_POST['password'] !== $_POST['password2']) {
							$errors['password2'] = 'The confirmation password you entered was incorrect';
						}
					}
				} else {
					$skip_password = true;
				}
				
				if (!array_key_exists($_POST['country'], $config['countries'])) {
					$errors['country'] = 'You did not select a valid country';
				} else {
					$values['country'] = $_POST['country'];
				}
				
				if (strlen($_POST['pin'])) {
					if (!valid_pin($_POST['pin'])) {
						$errors['pin'] = 'Your pin must be 4 numbers';
					} else {
						$values['pin'] = $_POST['pin'];
					}
				} else {
					$skip_pin = true;
				}
				
				if (!count($errors)) {
					$sql = "UPDATE `users` SET `user_country` = '$_POST[country]'";
					if (!$skip_password) {
						$password = md5($_POST['password']);
						$sql .= ", `user_pass` = '$password'";
					}
					if (!$skip_pin) {
						$sql .= ", `user_pin` = '$_POST[pin]'";
					}
					if ($change_email) {
						$hash = md5(crypt(uniqid(), md5(time() * rand(10000, 99999))));
						$q = mysqli_query("INSERT INTO `email_changes` SET `change_user_id` = {$this->info[user_id]}, `change_email` = '$_POST[email]', `change_hash` = '$hash'") || die(mysqli_error());
					}
					$q = mysqli_query("$sql WHERE `user_id` = {$this->info[user_id]}") || die(mysqli_error());
					$q = mysqli_query("SELECT * FROM `users` WHERE `user_id` = {$this->info[user_id]}");
					$user = mysqli_fetch_assoc($q);
					$user['new_email'] = $_POST['email'];
					$user['new_hash'] = $hash;
					send_email($this->info['user_email'], 'Confirm your e-mail address change', 'confirm_email.php', $user);
					$this->set_user_cookies($user);
					$success = true;
				}
				
			} else {
				$errors['old_password'] = 'You entered an incorrect password';
			}
			
			return array('errors' => $errors, 'values' => $values, 'success' => $success);
		}
		
	}
?>