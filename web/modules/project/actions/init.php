<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`actions` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`alias` varchar(250),
			`in_front` varchar(250),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

Route::set('action', '(<cat>/)actions/<alias>', array('alias' => '[a-zA-Z0-9\-]+', 'cat' => 'cosmetology|epil'))
->defaults(array(
	'controller' => 'actions',
	'action'     => 'action',
));

Route::set('all_actions', '(<cat>/)actions', array('cat' => 'cosmetology|epil'))
->defaults(array(
	'controller' => 'actions',
	'action'     => 'actions',
));