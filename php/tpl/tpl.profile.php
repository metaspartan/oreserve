<h2>Edit Profile</h2>
<?php if (!$update['success']): ?>
<form method="post" action="<?php echo $config['root']; ?>/profile/">
	<input type="hidden" name="action" value="update_profile" />
<?php if (count($update['errors'])): ?>
	<ul class="errors"><li><?php echo implode("</li>\n<li>", $update['errors']); ?></li></ul>
<?php endif; ?>
	<div class="field">
		<div class="left">
			<label for="old_password">Old Password</label>
			<p>Required to make any changes</p>
		</div>
		<div class="right"><input type="password" name="old_password" id="old_password" size="30" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label for="password">New Password</label>
			<p>Optional, at least 4 characters in length</p>
		</div>
		<div class="right"><input type="password" name="password" id="password" size="30" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label for="password2">Confirm New Password</label>
			<p>Must match your password</p>
		</div>
		<div class="right"><input type="password" name="password2" id="password2" size="30" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label>Full Name</label>
			<p>You may not change your name</p>
		</div>
		<div class="right"><input type="text" value="<?php echo htmlspecialchars($values['user_fullname']); ?>" size="40" disabled="disabled" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label for="email">Email Address</label>
			<p>Requires confirmation</p>
		</div>
		<div class="right"><input type="text" name="email" id="email" value="<?php echo htmlspecialchars($values['user_email']); ?>" size="40" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label>Username</label>
			<p>You may not change your username</p>
		</div>
		<div class="right"><input type="text" value="<?php echo $values['user_name']; ?>" size="30" disabled="disabled" /></div>
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
	<input type="submit" value="Update Profile" class="button" />
</form>
<?php else: ?>
<p>Your profile has been updated successfully.</p>
<?php endif; ?>