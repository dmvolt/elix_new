<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`infoblock` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`date` varchar(255),
			`weight` int(5),
			`type` int(1),
			`url` varchar(255),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();