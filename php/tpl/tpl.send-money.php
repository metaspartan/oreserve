<h2>Send Money</h2>
<?php if (!$send['success']): ?>
<form method="post" action="<?php echo $config['root']; ?>/send-money/" id="send">
	<input type="hidden" name="action" value="send_money" />
<?php if (!$send['confirm'] || $send['edit']): ?>
<?php if (count($send['errors'])): ?>
	<ul class="errors"><li><?php echo implode("</li>\n<li>", $send['errors']); ?></li></ul>
<?php endif; ?>
	<div class="field">
		<div class="left">
			<label for="account_number">Recipient's Account Number</label>
			<p>The account number (PXXXXXXXXXX) of the recipient</p>
		</div>
		<div class="right"><input type="text" name="account_number" id="account_number" value="<?php echo $send['values']['account_number']; ?>" size="40" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label for="amount">Amount</label>
			<p>The amount you are sending</p>
		</div>
		<div class="right"><input type="text" name="amount" id="amount" value="$<?php echo number_format($send['values']['amount'], 2); ?>" size="20" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label for="note">Note</label>
			<p>An optional note to the recipient</p>
		</div>
		<div class="right"><textarea name="note" id="note" cols="60" rows="5"><?php echo htmlspecialchars($send['values']['note']); ?></textarea></div>
	</div>
	<input type="submit" value="Send Money" class="button" />
<?php else: ?>
	<input type="hidden" name="confirm" value="1" />
	<input type="hidden" name="account_number" value="<?php echo $send['values']['account_number']; ?>" />
	<input type="hidden" name="amount" value="<?php echo $send['values']['amount']; ?>" />
	<input type="hidden" name="note" value="<?php echo htmlspecialchars($send['values']['note']); ?>" />
	<p class="plain" style="font-size: 13px;">Please review and confirm your payment.</p>
	<p class="details" style="font-size: 13px;">
		<strong>To:</strong> <?php echo htmlspecialchars($send['values']['recipient']['user_fullname']); ?> (<?php echo $send['values']['recipient']['user_account_number']; ?>)<br />
		<strong>Amount:</strong> $<?php echo number_format($send['values']['amount'], 2); ?><br />
		<strong>Note:</strong> <?php echo $send['values']['note'] ? htmlspecialchars($send['values']['note']) : 'None entered'; ?><br />
	</p>
	<input type="submit" value="Confirm and Send Money" class="button" />
	<button name="edit" value="1" class="button">Make Changes</button>
<?php endif; ?>
</form>
<?php else: ?>
<p style="font-size: 13px;">You have successfully made a payment of <strong>$<?php echo number_format($send['values']['amount'], 2); ?></strong> to <strong><?php echo htmlspecialchars($send['values']['recipient']['user_fullname']); ?></strong> <em>(<?php echo $send['values']['recipient']['user_account_number']; ?>)</em>
<?php endif; ?>