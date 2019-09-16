<div id="account">
	<h2>History</h2>
	<table cellpadding="0" cellspacing="0" class="transactions">
		<tr class="head">
			<td width="150">Transaction ID</td>
			<td width="100">Sent/Received</td>
			<td>To/From</td>
			<td width="100"><a href="<?php echo $config['root']; ?>/history/?sort=amount">Amount</a></td>
			<td width="150"><a href="<?php echo $config['root']; ?>/history/?sort=date">Date</a></td>
		</tr>
<?php
	$txns = $transactions->get_transactions(25, $_GET['page'], $_GET['sort']);
	foreach ($txns['transactions'] as $txn):
?>
		<tr class="item">
			<td width="150"><?php echo $txn['txn_real_id']; ?></td>
			<td width="150"><?php echo $txn['txn_user_id'] == $user->info['user_id'] ? 'Sent' : 'Received'; ?></td>
			<td><?php echo htmlspecialchars($txn['user_fullname']); ?> (<?php echo $txn['user_account_number']; ?>)</td>
			<td width="100">$<?php echo number_format($txn['txn_amount'], 2); ?></td>
			<td width="200"><?php echo date($config['date']['with_time'], $txn['txn_date']); ?></td>
		</tr>
<?php
	endforeach;
?>
	</table>
	<div class="pagination">
		<span>Select a page:</span>
<?php for ($i = 1; $i <= $txns['pages']; $i++): ?>
		<a href="<?php echo $config['root']; ?>/history/<?php echo $i; ?>/<?php echo $txns['sort'] ? '?sort=' . $txns['sort'] : ''; ?>"<?php echo $i == $txns['page'] ? ' class="active"' : ''; ?>><?php echo $i; ?></a>
<?php endfor; ?>
	</div>
</div>