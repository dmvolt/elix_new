<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`banners` ( 
			`id` int(5) NOT NULL AUTO_INCREMENT,
			`title` varchar(250),
			`code` text,
			`display_pages` text,
			`display_all` int(1),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();