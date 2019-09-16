<h2>Edit Profile</h2>
<?php if (!$update['success']): ?>
<form method="post" action="<?php echo $config['root']; ?>/admin/edit/<?php echo $values['user_id']; ?>/">
	<input type="hidden" name="action" value="update_user" />
	<input type="hidden" name="user_id" value="<?php echo $values['user_id']; ?>" />
<?php if (count($update['errors'])): ?>
	<ul class="errors"><li><?php echo implode("</li>\n<li>", $update['errors']); ?></li></ul>
<?php endif; ?>
	<div class="field">
		<div class="left">
			<label for="name">Full Name</label>
			<p>User's full name</p>
		</div>
		<div class="right"><input type="text" name="name" id="name" value="<?php echo htmlspecialchars($values['user_fullname']); ?>" size="40" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label for="email">Email Address</label>
			<p>User's email address</p>
		</div>
		<div class="right"><input type="text" name="email" id="email" value="<?php echo htmlspecialchars($values['user_email']); ?>" size="40" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label for="username">Username</label>
			<p>User's username</p>
		</div>
		<div class="right"><input type="text" name="username" id="username" value="<?php echo $values['user_name']; ?>" size="30" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label for="pin">PIN</label>
			<p>Leave blank for no change, four numbers (Ex: 1234)</p>
		</div>
		<div class="right"><input type="password" name="pin" id="pin" size="4" value="" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label for="country">Country</label>
		</div>
		<div class="right">
			<select name="country" id="country">
<?php foreach ($config['countries'] as $code => $country): ?>
				<option value="<?php echo $code; ?>"<?php echo $code == $values['user_country'] ? ' selected="selected"' : ''; ?>><?php echo $country; ?></option>
<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="field">
		<div class="left">
			<label for="balance">Balance</label>
			<p>User's balance</p>
		</div>
		<div class="right"><input type="text" name="balance" id="balance" value="$<?php echo number_format($values['user_balance']); ?>" size="15" /></div>
	</div>
	<input type="submit" value="Update Profile" class="button" />
</form>
<?php else: ?>
<p><?php echo htmlspecialchars($values['user_fullname']); ?>'s account has been updated successfully.</p>
<?php endif; ?>