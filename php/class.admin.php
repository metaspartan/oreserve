<?php
	class admin {
		
		function get_users ($limit = 50, $page = 1, $query = false) {			
			$search = $query ? "WHERE (`user_name` LIKE '%$query%' OR `user_fullname` LIKE '%$query%' OR `user_email` LIKE '%$query%')" : '';
			$sql = "SELECT * FROM `users` $search ORDER BY `user_id` DESC";
			$q = mysqli_query($sql);
			$pages = ceil(mysqli_num_rows($q) / $limit);
			$page = $page >= 1 && $page <= $pages ? $page : 1;
			$offset = ($page - 1) * $offset;
			$q = mysqli_query("$sql LIMIT $offset, $limit");
			$users = array();
			while ($r = mysqli_fetch_assoc($q)) {
				$users[] = $r;
			}
			return array('users' => $users, 'pages' => $pages, 'page' => $page, 'query' => $query);
		}
		
		function get_user ($user_id) {
			$user_id = mysqli_real_escape_string($user_id);
			$q = mysqli_query("SELECT * FROM `users` WHERE `user_id` = '$user_id'");
			if (mysqli_num_rows($q)) {
				$user = mysqli_fetch_assoc($q);
				$q = mysqli_query("SELECT * FROM `logins` LEFT JOIN `users` ON `user_id` = `login_user_id` WHERE `user_id` = $user[user_id] GROUP BY `login_ip` ORDER BY `login_id` DESC");
				while ($r = mysqli_fetch_assoc($q)) {
					$ip = array('address' => $r['login_ip'], 'owner' => $r['login_ip'] == $r['user_ip']);
					$user['ips'][] = $ip;
				}
				return $user;
			} else {
				return false;
			}
		}
		
		function delete_user ($user_id) {
			$user_id = mysqli_real_escape_string($user_id);
			$q = mysqli_query("DELETE FROM `users` WHERE `user_id` = '$user_id'");
		}
		
		function update_user () {
			global $config;
			$errors = array();
			$values = array();
			$success = false;
			$change_username = false;
			$change_email = false;
			$skip_pin = false;
			
			$user = $this->get_user($_POST['user_id']);
			if (!$user) {
				$errors['user'] = 'The use you are trying to edit could not be found';
			}
			
			if ($user['user_name'] != $_POST['username']) {
				if (!valid_username($_POST['username'])) {
					$errors['username'] = 'Your username must be at least 3 characters in length, containing only letters, numbers, underscores and dashes';
				} else {
					if (username_exists($_POST['username'])) {
						$errors['username'] = 'The username you entered is already in use';
					} else {
						$change_username = true;
						$values['user_name'] = $_POST['username'];
					}
				}
			}
			
			if ($user['user_email'] != $_POST['email']) {
				if (!valid_email($_POST['email'])) {
					$errors['email'] = 'The email address you entered was invalid';
				} else {
					if (email_exists($_POST['email'])) {
						$errors['email'] = 'The email address you entered is already in use';
					} else {
						$change_email = true;
						$values['user_email'] = $_POST['email'];
					}
				}
			}
			
			if (!array_key_exists($_POST['country'], $config['countries'])) {
				$errors['country'] = 'You did not select a valid country';
			} else {
				$values['user_country'] = $_POST['country'];
			}
			
			if (strlen($_POST['pin'])) {
				if (!valid_pin($_POST['pin'])) {
					$errors['pin'] = 'Your pin must be 4 numbers';
				} else {
					$values['user_pin'] = $_POST['pin'];
				}
			} else {
				$skip_pin = true;
			}
			
			if (!count($errors)) {
				$name = mysqli_real_escape_string($_POST['name']);
				$balance = floatval(preg_replace('#[^0-9.]#', '', $_POST['balance']));
				$sql = "UPDATE `users` SET `user_fullname` = '$name', `user_country` = '$_POST[country]', `user_balance` = '$balance'";
				if ($change_username) {
					$sql .= ", `user_name` = '$_POST[username]'";
				}
				if ($change_email) {
					$sql .= ", `user_email` = '$_POST[email]'";
				}
				if (!$skip_pin) {
					$sql .= ", `user_pin` = '$_POST[pin]'";
				}
				$q = mysqli_query("$sql WHERE `user_id` = $user[user_id]") || die(mysqli_error());
				$success = true;
			}
			
			return array('errors' => $errors, 'values' => $values, 'success' => $success);
		}
		
		function ban_user () {
			$errors = array();
			$values = array();
			$success = false;
			
			$user = $this->get_user($_POST['user_id']);
			if (!$user) {
				$errors['user'] = 'The use you are trying to ban could not be found';
			}
			
			if (!strtotime($_POST['until'])) {
				$errors['until'] = 'You did not enter a valid date to ban until';
			} else {
				$values['until'] = $_POST['until'];
			}
			
			if (is_array($_POST['ips'])) {
				$values['ips'] = $_POST['ips'];
			}
			
			if (!count($errors)) {
				$ips = @implode('|', $_POST['ips']);
				$until = strtotime($_POST['until']);
				$q = mysqli_query("INSERT INTO `bans` SET `ban_user_id` = $user[user_id], `ban_ips` = '$ips', `ban_until` = '$until'");
				$success = true;
			}
			
			return array('errors' => $errors, 'values' => $values, 'success' => $success);
		}
		
	}
?>