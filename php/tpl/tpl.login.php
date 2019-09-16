<?php if (!$login['success']): ?>
<form method="post" action="<?php echo $config['root']; ?>/login/" id="login">
	<h2>Login</h2>
	<input type="hidden" name="action" value="login" />
<?php if (count($login['errors'])): ?>
	<ul class="errors"><li><?php echo implode("</li>\n<li>", $login['errors']); ?></li></ul>
<?php endif; ?>
	<div class="field">
		<div class="left"><label for="username">Username</label></div>
		<div class="right"><input type="text" name="username" id="username" value="<?php echo $login['values']['username']; ?>" size="30" /></div>
	</div>
	<div class="field">
		<div class="left"><label for="password">Password</label></div>
		<div class="right"><input type="password" name="password" id="password" size="30" /></div>
	</div>
	<div class="field">
		<div class="left"><label for="pin">PIN</label></div>
		<div class="right"><input type="password" name="pin" id="pin" size="4" /></div>
	</div>
	<input type="submit" value="Login" class="button" />
</form>
<div id="login2"><img src="<?php echo $config['root']; ?>/img/loginsecure.png" border="0" alt="" /></div>
<div class="clear"></div>
<?php else: ?>
<p style="font-size: 13px;">You are now logged in as <strong><?php echo $user->info['user_name']; ?></strong>.</p>
<?php endif; ?>