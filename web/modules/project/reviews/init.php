<?php defined('SYSPATH') or die('No direct script access.');
DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`reviews` ( 
			`id` int(5) auto_increment,
			`parent_id` int(5),
			`group_id` int(3),
			`date` varchar(64),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

Route::set('review', 'reviews/<id>', array('id' => '[0-9]+'))
->defaults(array(
	'controller' => 'reviews',
	'action'     => 'review',
));

Route::set('reviews', 'reviews')
	->defaults(array(
		'controller' => 'reviews',
		'action'     => 'reviews',
));