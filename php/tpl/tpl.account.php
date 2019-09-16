<div id="account">
	<h2>My Account</h2>
	<div class="overview">
		<div class="item">
			<strong>Balance:</strong>
			<span class="green">$<?php echo number_format($user->info['user_balance'], 2); ?> USD</span>
		</div>

		<div class="item">
			<strong>Member Since:</strong>
			<span><?php echo date($config['date']['full'], $user->info['user_date']); ?></span>
		</div>
		<div class="item">
			<strong>Full Name:</strong>
			<span><?php echo htmlspecialchars($user->info['user_fullname']); ?></span>
		</div>
		<div class="item">
			<strong>Username:</strong>
			<span><?php echo $user->info['user_name']; ?></span>
		</div>
		<div class="item">
			<strong>Country:</strong>
			<span><?php echo $config['countries'][$user->info['user_country']]; ?></span>
		</div>
		</div>
		<div class="overview2">		
		<div class="item">
			<strong>Account Number:</strong>
			<span><?php echo $user->info['user_account_number']; ?></span>
		</div>
		</div>
		<div class="overview2">
		<div class="item">
			<strong>Your IP Address:</strong>
			<span><?php echo $_SERVER['REMOTE_ADDR']; ?></span>
		</div>
		<div class="item">
			<strong>Last IP Address Logged In:</strong>
			<span><?php echo $user->info['last_ip']; ?></span>
		</div>
	</div>
	<div class="clear"></div>
	<h2>Recent Transactions</h2>
	<table cellpadding="0" cellspacing="0" class="transactions">
		<tr class="head">
			<td width="150">Transaction ID</td>
			<td width="75">Sent/Received</td>
			<td>To/From</td>
			<td width="90">Amount</td>
			<td width="150">Date</td>
			<td width="100">Memo</td>
		</tr>
<?php
	$txns = $transactions->get_transactions(25);
	foreach ($txns['transactions'] as $txn):
?>
		<tr class="item">
			<td><?php echo $txn['txn_real_id']; ?></td>
			<td><?php echo $txn['txn_user_id'] == $user->info['user_id'] ? 'Sent' : 'Received'; ?></td>
			<td><?php echo htmlspecialchars($txn['user_fullname']); ?> (<?php echo $txn['user_account_number']; ?>)</td>
			<td>$<?php echo number_format($txn['txn_amount'], 2); ?></td>
			<td><?php echo date($config['date']['with_time'], $txn['txn_date']); ?></td>
			<td><?php echo substr(htmlspecialchars($txn['txn_note']), 0, 50); ?></td>
		</tr>
<?php
	endforeach;
?>
	</table>
</div>