<?php
	class transactions {
		
		function get_transactions ($limit = 25, $page = 1, $sort = false) {
			global $user;
			switch ($sort) {
				default: case 'date':
					$sorting = '`txn_date`';
					break;
				case 'amount':
					$sorting = '`txn_amount`';
					break;
			}
			$sql = "SELECT * FROM `transactions` WHERE `txn_user_id` = {$user->info[user_id]} OR `txn_recipient_id` = {$user->info[user_id]} ORDER BY $sorting DESC";
			$q = mysqli_query($sql);
			$pages = ceil(mysqli_num_rows($q) / $limit);
			$page = $page >= 1 && $page <= $pages ? $page : 1;
			$offset = ($page - 1) * $limit;
			$q = mysqli_query("$sql LIMIT $offset, $limit");
			$transactions = array();
			while ($r = mysqli_fetch_assoc($q)) {
				if ($r['txn_recipient_id'] == $user->info['user_id']) {
					$user_id = $r['txn_user_id'];
				} else {
					$user_id = $r['txn_recipient_id'];
				}
				$q2 = mysqli_query("SELECT * FROM `users` WHERE `user_id` = $user_id");
				$r2 = mysqli_fetch_assoc($q2);
				$transactions[] = array_merge($r, $r2);
			}
			return array('transactions' => $transactions, 'pages' => $pages, 'page' => $page);
		}
		
		function send_money () {
			global $user;
			$errors = array();
			$values = array();
			$success = false;
			$confirm = (bool) $_POST['confirm'];
			$edit = (bool) $_POST['edit'];
			
			$recipient = get_user_by_account_number($_POST['account_number']);
			if ($recipient) {
				$values['recipient'] = $recipient;
				$values['account_number'] = $_POST['account_number'];
			} else {
				$errors['account_number'] = 'The recipient\'s account number you entered could not be found';
			}
			
			$amount = floatval(preg_replace('#[^0-9.]#', '', $_POST['amount']));
			if ($amount <= 0) {
				$errors['amount'] = 'You did not enter an amount to send';
			} elseif ($amount > $user->info['user_balance']) {
				$errors['amount'] = 'The amount you are trying to send exceeds your balance';
			} else {
				$values['amount'] = $amount;
			}
			
			if (strlen($_POST['note'])) {
				if (strlen($_POST['note']) > 50) {
					$errors['note'] = 'Your note must not be longer than 50 characters in length';
				} else {
					$values['note'] = $_POST['note'];
				}
			}
			
			if (!count($errors) && !$edit) {
				if (!$confirm) {
					$confirm = true;
				} else {
					$note = mysqli_real_escape_string($_POST['note']);
					$txn_id = generate_txn_id();
					$q = mysqli_query("INSERT INTO `transactions` SET `txn_real_id` = $txn_id, `txn_user_id` = {$user->info[user_id]}, `txn_recipient_id` = $recipient[user_id], `txn_amount` = '$amount', `txn_note` = '$note', `txn_date` = UNIX_TIMESTAMP(NOW())");
					$txn_id = mysqli_insert_id();
					$q = mysqli_query("UPDATE `users` SET `user_balance` = `user_balance` - '$amount' WHERE `user_id` = {$user->info[user_id]}");
					$q = mysqli_query("UPDATE `users` SET `user_balance` = `user_balance` + '$amount' WHERE `user_id` = $recipient[user_id]");
					$q = mysqli_query("SELECT * FROM `transactions` WHERE `txn_id` = $txn_id");
					$transaction = array('sender' => $user->info, 'recipient' => $recipient, 'transaction' => mysqli_fetch_assoc($q));
					send_email($user->info['user_email'], 'Your payment has been sent', 'payment_sent.php', $transaction);
					send_email($recipient['user_email'], 'You have received a payment', 'payment_received.php', $transaction);
					$success = true;
				}
			}
			
			return array('errors' => $errors, 'values' => $values, 'confirm' => $confirm, 'edit' => $edit, 'success' => $success);
		}
		
	}
?>