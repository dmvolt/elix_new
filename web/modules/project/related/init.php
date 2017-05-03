<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`related` ( 
			`id` int(10) auto_increment,
			`sku` varchar(64),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`contents_related` ( 
			`product_id` int(10),
			`related_id` int(10),
			`module` varchar(255)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();