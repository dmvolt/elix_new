<?php defined('SYSPATH') or die('No direct script access.');

/* DB::query(Database::INSERT, 'DROP TABLE `comments`')->execute(); */

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`comments` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`parent_id` int(10) NOT NULL,
			`user_id` int(11) NOT NULL,
			`lang_id` int(3) NOT NULL,
			`date` varchar(32),
			`content_id` int(10) NOT NULL,
			`module` varchar(64),
			`author` varchar(32),
			`message` text,
			`timestamp` varchar(32),
			`status` int(1) NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();