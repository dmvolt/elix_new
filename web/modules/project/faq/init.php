<?php defined('SYSPATH') or die('No direct script access.');
DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`faq` ( 
			`id` int(5) auto_increment,
			`parent_id` int(5),
			`group_id` int(3),
			`date` varchar(64),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

Route::set('one_faq', '(<cat>/)faq/<id>', array('id' => '[0-9]+', 'cat' => 'cosmetology|epil'))
->defaults(array(
	'controller' => 'faq',
	'action'     => 'view',
));

Route::set('faq', '(<cat>/)faq', array('cat' => 'cosmetology|epil'))
	->defaults(array(
		'controller' => 'faq',
		'action'     => 'faq',
));