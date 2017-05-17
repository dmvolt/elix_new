<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`services` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`parent_id` int(10),
			`date` varchar(250),
			`alias` varchar(250),
			`weight` int(5),
			`price` text,
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

Route::set('services', 'services(/<cat1>(/<cat2>(/<cat3>)))', array('cat1' => '[a-zA-Z0-9\-]+', 'cat2' => '[a-zA-Z0-9\-]+', 'cat3' => '[a-zA-Z0-9\-]+'))
	->defaults(array(
		'controller' => 'services',
		'action'     => 'services',
));