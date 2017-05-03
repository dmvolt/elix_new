<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`categories` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`parent_id` int(10),
			`alias` varchar(250),
			`dictionary_id` int(5),
			`weight` int(3),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`contents_categories` ( 
			`category_id` int(10),
			`content_id` int(10),
			`module` varchar(250)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();