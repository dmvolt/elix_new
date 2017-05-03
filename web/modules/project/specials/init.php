<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`specials` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`alias` varchar(250),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

Route::set('special', '(<cat>/)doctors/<alias>', array('cat' => 'cosmetology|epil', 'alias' => '[a-zA-Z0-9\-\_]+'))
->defaults(array(
	'controller' => 'specials',
	'action'     => 'special',
));

Route::set('specials', '(<cat>/)doctors', array('cat' => 'cosmetology|epil'))
	->defaults(array(
		'controller' => 'specials',
		'action'     => 'specials',
));