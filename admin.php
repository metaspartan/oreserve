<?php
	include 'php/inc.init.php';
	include 'php/class.user.php';
	include 'php/class.admin.php';
	$user = new user();
	$admin = new admin();
	
	if (!$user->is_admin) {
		header('Location: ' . $config['root'] . '/');
		exit;
	}
	
	$page = 'tpl.admin.php';
	if ($_GET['action'] == 'view') {
		$page = 'tpl.admin-view.php';
		$_user = $admin->get_user($_GET['user']);
	} elseif ($_GET['action'] == 'edit') {
		$page = 'tpl.admin-edit.php';
		$_user = $admin->get_user($_GET['user']);
		if ($_POST['action'] == 'update_user') {
			$update = $admin->update_user();
		}
		$values = $_user;
	} elseif ($_GET['action'] == 'ban') {
		$page = 'tpl.admin-ban.php';
		$_user = $admin->get_user($_GET['user']);
		if ($_POST['action'] == 'ban_user') {
			$ban = $admin->ban_user();
		}
	} elseif ($_GET['action'] == 'delete') {
		$admin->delete_user($_GET['user']);
		if ($_SERVER['HTTP_REFERER']) {
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		} else {
			header("Location: $config[root]/admin/");
		}
		exit;
	}
	
	include 'php/tpl/tpl.head.php';
	include 'php/tpl/' . $page;
	include 'php/tpl/tpl.footer.php';
?>