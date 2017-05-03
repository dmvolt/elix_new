<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`partners` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`alias` varchar(250),
			`phone` varchar(250),
			`email` varchar(250),
			`map` text,
			`link` varchar(250),
			`map_x` varchar(250),
			`map_y` varchar(250),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

Route::set('address_lang', '<lang>/contacts/<alias>', array('lang' => '[a-zA-Z]{2}', 'alias' => '.+'))
->defaults(array(
	'controller' => 'partners',
	'action'     => 'article',
));

Route::set('address', 'contacts/<alias>', array('alias' => '.+'))
->defaults(array(
	'controller' => 'partners',
	'action'     => 'article',
));

Route::set('partners', 'contacts')
	->defaults(array(
		'controller' => 'partners',
		'action'     => 'partners',
));

Route::set('partners_lang', '<lang>/contacts', array('lang' => '[a-zA-Z]{2}'))
	->defaults(array(
		'controller' => 'partners',
		'action'     => 'partners',
));