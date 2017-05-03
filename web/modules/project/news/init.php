<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`news` ( 
			`id` int(5) auto_increment,
			`date` varchar(64),
			`timestamp` int(20),
			`alias` varchar(255),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();


Route::set('news_lang', '<lang>/news', array('lang' => '[a-zA-Z]{2}'))
	->defaults(array(
		'controller' => 'news',
		'action'     => 'news',
)); 

Route::set('news', 'news')
	->defaults(array(
		'controller' => 'news',
		'action'     => 'news',
));  

Route::set('new_lang', '<lang>/news/<alias>', array('lang' => '[a-zA-Z]{2}', 'alias' => '.+'))
->defaults(array(
	'controller' => 'news',
	'action'     => 'new',
));

Route::set('new', 'news/<alias>', array('alias' => '.+'))
->defaults(array(
	'controller' => 'news',
	'action'     => 'new',
));