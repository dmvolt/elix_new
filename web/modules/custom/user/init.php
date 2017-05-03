<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`users` ( 
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`avatar` varchar(250) NOT NULL,
			`email` varchar(254) NOT NULL,
			`username` varchar(32) NOT NULL,
			`password` varchar(64) NOT NULL,
			`rempass` varchar(255) NOT NULL,
			`logins` int(10) unsigned NOT NULL,
			`last_login` int(10) unsigned DEFAULT NULL,
			`role_id` int(3) NOT NULL,
			`status` int(1) NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `uniq_username` (`username`),
			UNIQUE KEY `uniq_email` (`email`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();