<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`services` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`date` varchar(250),
			`alias` varchar(250),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

Route::set('service', '(<cat>/)services/<cat2>/<alias>', array('cat' => 'cosmetology|epil', 'cat2' => '[a-zA-Z0-9\-]+', 'alias' => '[a-zA-Z0-9\-]+'))
->defaults(array(
	'controller' => 'services',
	'action'     => 'service',
));

Route::set('services', '(<cat>/)services/<cat2>', array('cat' => 'cosmetology|epil', 'cat2' => '[a-zA-Z0-9\-]+'))
	->defaults(array(
		'controller' => 'services',
		'action'     => 'services',
));

Route::set('services2', '(<cat>/)services', array('cat' => 'cosmetology|epil'))
	->defaults(array(
		'controller' => 'services',
		'action'     => 'services',
));