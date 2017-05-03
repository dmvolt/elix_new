<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`siteinfo` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`email` varchar(250),
			`tell` varchar(250),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();