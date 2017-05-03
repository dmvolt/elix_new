<?php defined('SYSPATH') or die('No direct script access.');
DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`articles` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`author` varchar(100),
			`alias` varchar(250),
			`menu` varchar(64),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

Route::set('article', '(<cat>/)articles/<alias>', array('cat' => 'cosmetology|epil', 'alias' => '[a-zA-Z0-9\-\_]+'))
	->defaults(array(
		'controller' => 'articles',
		'action'     => 'article',
));

Route::set('articles', '(<cat>/)articles', array('cat' => 'cosmetology|epil'))
	->defaults(array(
		'controller' => 'articles',
		'action'     => 'articles',
));