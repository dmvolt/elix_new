<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`seo` ( 
			`id` int(10) auto_increment,
			`lang_id` int(10),
			`title` varchar(255),
			`meta_k` text,
			`meta_d` text,
			`alt` varchar(255),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`contents_seo` ( 
			`content_id` int(10),
			`seo_id` int(10),
			`module` varchar(64)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();