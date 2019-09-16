<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>oReserve - Next Gen Payment Processor - Online Wallet</title>
<link href="<?php echo $config['root']; ?>/css/style.css" rel="stylesheet" />
<link rel="shortcut icon" href="/en/favicon.ico" type="image/ico">	
<META NAME="Keywords" CONTENT="private,digital currency,ecurrency,e-currency,payment system,payment processor,payment gateway,api,merchant,merchant payment solution,online banking,money,transfer,finance service,payment  service,safely store funds,buy,sell,exchange,forex,casino,sports betting,poker,on-line,wallet">  
<META name="description" content="oReserve is a secure, fast, and fee FREE online payment processor. Pay online without sharing fiancial information. Anonymous online wallet."> 
</head>

<body>

<div id="wrapper">
	<div id="header">
		<a href="/"><div id="logo"></div></a>
		
		<ul>
			<li><a href="<?php echo $config['root']; ?>/">Home</a></li>
<?php if (!$user->logged_in): ?>
			<li><a href="<?php echo $config['root']; ?>/login/">Login <img src="<?php echo $config['root']; ?>/img/padlock.png" border="0" /></a></li>
			<li><a href="<?php echo $config['root']; ?>/register/">Register</a></li>
<?php else: ?>
			<li><a href="<?php echo $config['root']; ?>/account/">Account</a></li>
			<li><a href="<?php echo $config['root']; ?>/send-money/">Send Money</a></li>
			<li><a href="<?php echo $config['root']; ?>/history/">History</a></li>
			<li><a href="<?php echo $config['root']; ?>/profile/">Profile</a></li>
<?php if ($user->is_admin): ?>
			<li><a href="<?php echo $config['root']; ?>/admin/">Admin</a></li>
<?php endif; ?>
			<li><a href="<?php echo $config['root']; ?>/logout/" class="red">Logout</a></li>
<?php endif; ?>
		</ul>
		
	</div>
	<div class="content">
   <div class="content_top"><div></div></div>
      <div class="content_content">