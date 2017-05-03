<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`tags` ( 
			`id` int(10) auto_increment,
			`name` varchar(64),
			`alias` varchar(64),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`contents_tags` ( 
			`content_id` int(10),
			`tag_id` int(10),
			`module` varchar(64)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();