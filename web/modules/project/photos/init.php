<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`photos` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`alias` varchar(250),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

Route::set('photo', '(<cat>/)photos/<alias>', array('cat' => 'cosmetology|epil', 'alias' => '[a-zA-Z0-9\-]+'))
->defaults(array(
	'controller' => 'photos',
	'action'     => 'photo',
));

Route::set('photos', '(<cat>/)photos', array('cat' => 'cosmetology|epil'))
	->defaults(array(
		'controller' => 'photos',
		'action'     => 'photos',
));