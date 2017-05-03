<?php

defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`menu` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`parent_id` int(10),
			`name` varchar(255),
			`url` varchar(255),
			`dictionary_id` int(5),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();