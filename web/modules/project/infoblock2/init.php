<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`infoblock2` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`title` varchar(255),
			`info` varchar(255),
			`link1` varchar(255),
			`link2` varchar(255),
			`pos_x` varchar(255),
			`pos_y` varchar(255),
			`type` int(1),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();