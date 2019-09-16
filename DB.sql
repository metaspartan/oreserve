CREATE TABLE `bans` (
  `ban_id` int(11) NOT NULL AUTO_INCREMENT,
  `ban_user_id` int(11) NOT NULL,
  `ban_ips` text NOT NULL,
  `ban_until` int(10) NOT NULL,
  PRIMARY KEY (`ban_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



CREATE TABLE `email_changes` (
  `change_id` int(11) NOT NULL AUTO_INCREMENT,
  `change_user_id` int(11) NOT NULL,
  `change_email` varchar(128) NOT NULL,
  `change_hash` varchar(32) NOT NULL,
  PRIMARY KEY (`change_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE `logins` (
  `login_id` int(11) NOT NULL AUTO_INCREMENT,
  `login_user_id` int(11) NOT NULL,
  `login_ip` varchar(16) NOT NULL,
  `login_date` int(10) NOT NULL,
  PRIMARY KEY (`login_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE `transactions` (
  `txn_id` int(11) NOT NULL AUTO_INCREMENT,
  `txn_real_id` varchar(20) NOT NULL,
  `txn_user_id` int(11) NOT NULL,
  `txn_recipient_id` int(11) NOT NULL,
  `txn_amount` float NOT NULL,
  `txn_date` int(10) NOT NULL,
  `txn_note` text NOT NULL,
  PRIMARY KEY (`txn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_account_number` varchar(11) NOT NULL,
  `user_balance` float NOT NULL,
  `user_name` varchar(16) NOT NULL,
  `user_fullname` varchar(64) NOT NULL,
  `user_email` varchar(128) NOT NULL,
  `user_pass` varchar(32) NOT NULL,
  `user_country` varchar(64) NOT NULL,
  `user_pin` int(4) NOT NULL,
  `user_date` int(10) NOT NULL,
  `user_hash` varchar(32) NOT NULL,
  `user_ip` varchar(16) NOT NULL,
  `user_status` int(1) NOT NULL DEFAULT '0' COMMENT '0 = Unactivated, 1 = Activated, 2 = Banned, 3 = Admin',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;