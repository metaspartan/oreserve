<div id="admin">
	<h2>User Administration</h2>
	<table cellpadding="0" cellspacing="0" class="transactions">
		<tr class="head">
			<td width="50">ID</td>
			<td>Full Name</td>
			<td>Username</td>
			<td>E-mail Address</td>
			<td width="125">Member Since</td>
			<td width="100"></td>
		</tr>
<?php
	$users = $admin->get_users(50, $_GET['page'], $_GET['s']);
	foreach ($users['users'] as $usr):
?>
		<tr class="item">
			<td><?php echo $usr['user_id']; ?></td>
			<td><?php echo htmlspecialchars($usr['user_fullname']); ?></td>
			<td><a href="<?php echo $config['root']; ?>/admin/view/<?php echo $usr['user_id']; ?>/"><?php echo $usr['user_name']; ?></td>
			<td><?php echo $usr['user_email']; ?></td>
			<td><?php echo date($config['date']['full'], $usr['user_date']); ?></td>
			<td align="right"><a href="<?php echo $config['root']; ?>/admin/edit/<?php echo $usr['user_id']; ?>/">Edit</a>, <a href="<?php echo $config['root']; ?>/admin/delete/<?php echo $usr['user_id']; ?>/">Delete</a>, <a href="<?php echo $config['root']; ?>/admin/ban/<?php echo $usr['user_id']; ?>/">Ban</a></td>
		</tr>
<?php
	endforeach;
?>
	</table>
	<div class="pagination">
		<span>Select a page:</span>
<?php for ($i = 1; $i <= $users['pages']; $i++): ?>
		<a href="<?php echo $config['root']; ?>/admin/<?php echo $i; ?>/<?php echo $users['query'] ? '?s=' . htmlspecialchars($users['query']) : ''; ?>"<?php echo $i == $users['page'] ? ' class="active"' : ''; ?>><?php echo $i; ?></a>
<?php endfor; ?>
	</div>
</div>