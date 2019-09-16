<h2>Change E-mail</h2>
<?php if ($change): ?>
<p>Your e-mail address has been updated successfully! Return to <a href="<?php echo $config['root']; ?>/">home</a>.</a>
<?php else: ?>
<p>You have followed an invalid link. Return to <a href="<?php echo $config['root']; ?>/">home</a>.
<?php endif; ?>