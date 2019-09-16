<div id="account">
	<h2>View User: <?php echo $_user['user_name']; ?></h2>
	<div class="overview">
		<div class="item">
			<strong>Balance:</strong>
			<span class="green">$<?php echo number_format($_user['user_balance'], 2); ?></span>
		</div>
		<div class="item">
			<strong>Account Number:</strong>
			<span><?php echo $_user['user_account_number']; ?></span>
		</div>
		<div class="item">
			<strong>Member Since:</strong>
			<span><?php echo date($config['date']['full'], $_user['user_date']); ?></span>
		</div>
		<div class="item">
			<strong>Full Name:</strong>
			<span><?php echo htmlspecialchars($_user['user_fullname']); ?></span>
		</div>
		<div class="item">
			<strong>Username:</strong>
			<span><?php echo $_user['user_name']; ?></span>
		</div>
		<div class="item">
			<strong>Country:</strong>
			<span><?php echo $config['countries'][$_user['user_country']]; ?></span>
		</div>
	</div>
</div>
<div class="clear"></div>