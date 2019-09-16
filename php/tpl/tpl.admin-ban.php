<h2>Ban User: <?php echo $_user['user_name']; ?></h2>
<?php if (!$ban['success']): ?>
<form method="post" action="<?php echo $config['root']; ?>/admin/ban/<?php echo $_user['user_id']; ?>/">
	<input type="hidden" name="action" value="ban_user" />
	<input type="hidden" name="user_id" value="<?php echo $_user['user_id']; ?>" />
<?php if (count($ban['errors'])): ?>
	<ul class="errors"><li><?php echo implode("</li>\n<li>", $ban['errors']); ?></li></ul>
<?php endif; ?>
	<div class="field">
		<div class="left">
			<label for="until">Ban Until</label>
			<p>Enter a date that the user will be banned until, any readable date format</p>
		</div>
		<div class="right"><input type="text" name="until" id="until" value="<?php echo $ban['values']['until']; ?>" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label>Associated IPs</label>
			<p>Select the IPs you would like to ban with this account</p>
		</div>
		<div class="checkboxes">
<?php foreach ($_user['ips'] as $ip): ?>
			<label><strong><?php echo $ip['address']; ?></strong> <?php echo $ip['owner'] ? ' (Account Owner\'s)' : ''; ?> <input type="checkbox" name="ips[]" value="<?php echo $ip['address']; ?>"<?php echo @in_array($ip['address'], $ban['values']['ips']) ? ' checked="checked"' : ''; ?> /></label><br />
<?php endforeach; ?>
		</div>
	</div>
	<input type="submit" value="Ban" class="button" />
</form>
<?php else: ?>
<p>This user has been banned until <strong><?php echo date($config['date']['with_time'], strtotime($ban['values']['until'])); ?></strong>. The following IPs have also been banned:</p>
<ul class="ips"><li><?php echo implode("</li>\n<li>", $ban['values']['ips']); ?></li></ul>
<p>Return to <a href="<?php echo $config['root']; ?>/admin/">admin home</a>.</a>
<?php endif; ?>