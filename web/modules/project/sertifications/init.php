<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`sertifications` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`alias` varchar(250),
			`code` varchar(250),
			`price` varchar(250),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

Route::set('sertifications', '(<cat>/)sertifications', array('cat' => 'cosmetology|epil'))
	->defaults(array(
		'controller' => 'sertifications',
		'action'     => 'sertifications',
));

/* DB::query(Database::INSERT, 'ALTER TABLE `sertifications` ADD `old_price` VARCHAR(255) NOT NULL')->execute(); */