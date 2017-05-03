<?php defined('SYSPATH') or die('No direct script access.');
DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`address` ( 
			`id` int(10) auto_increment,
			`lang_id` int(10),
			`text1` text,
			`text2` text,
			`text3` text,
			`text4` text,
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();
DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`contents_address` ( 
			`content_id` int(10),
			`address_id` int(10),
			`module` varchar(64)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();