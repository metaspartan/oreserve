<h2>Register</h2>
<?php if (!$register['success']): ?>
<form method="post" action="<?php echo $config['root']; ?>/register/" id="register">
	<input type="hidden" name="action" value="register" />
<?php if (count($register['errors'])): ?>
	<ul class="errors"><li><?php echo implode("</li>\n<li>", $register['errors']); ?></li></ul>
<?php endif; ?>
	<div class="field">
		<div class="left">
			<label for="username">Username</label>
			<p>Numbers, letters, underscores and dashes, between 3-16 characters in length</p>
		</div>
		<div class="right"><input type="text" name="username" id="username" value="<?php echo $register['values']['username']; ?>" size="30" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label for="email">Email Address</label>
			<p>Must be valid</p>
		</div>
		<div class="right"><input type="text" name="email" id="email" value="<?php echo $register['values']['email']; ?>" size="30" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label for="password">Password</label>
			<p>At least 4 characters in length</p>
		</div>
		<div class="right"><input type="password" name="password" id="password" size="30" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label for="password2">Confirmation Password</label>
			<p>Must match your password</p>
		</div>
		<div class="right"><input type="password" name="password2" id="password2" size="30" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label for="pin">PIN</label>
			<p>Four numbers (Ex: 1234)</p>
		</div>
		<div class="right"><input type="text" name="pin" id="pin" size="4" value="<?php echo $register['values']['pin']; ?>" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label for="name">Full Name</label>
			<p>Must not be left blank</p>
		</div>
		<div class="right"><input type="text" name="name" id="name" value="<?php echo htmlspecialchars($register['values']['name']); ?>" size="30" /></div>
	</div>
	<div class="field">
		<div class="left">
			<label for="country">Country</label>
		</div>
		<div class="right">
			<select name="country" id="country">
<?php foreach ($config['countries'] as $code => $country): ?>
				<option value="<?php echo $code; ?>"<?php echo $code == $register['values']['country'] ? ' selected="selected"' : ''; ?>><?php echo $country; ?></option>
<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="field">
		<div class="left">
			<label for="recaptcha">Security Code</label>
			<p>Enter the words in the box</p>
		</div>
		<div class="right"><?php echo recaptcha_get_html($config['recaptcha']['public']); ?></div>
	</div>
	<input type="submit" value="Register" class="button" />
</form>
<?php else: ?>
<p style="font-size: 13px;">Thank you for registering, <strong><?php echo htmlspecialchars($register['values']['name']); ?></strong>. Your registration is almost complete, an email has been sent to you containing instructions on how to activate your account.</p>
<?php endif; ?>