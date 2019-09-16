<h2>Activate</h2>
<?php if ($activate): ?>
<p style="font-size: 13px;">Thank you for activating your account! You may now proceed to <a href="<?php echo $config['root']; ?>/login/">login</a>.</a>
<?php else: ?>
<p style="font-size: 13px;">You have followed an invalid activate link. Return to <a href="<?php echo $config['root']; ?>/">home</a>.
<?php endif; ?>