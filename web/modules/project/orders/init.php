<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`order` ( 
		`id` int(10) NOT NULL AUTO_INCREMENT,
		
		`name` varchar(250), 
		`phone` varchar(250), 
		`email` varchar(250), 
		`street` varchar(250), 
		`house` varchar(250), 
		`housing` varchar(250), 
		`houseroom` varchar(250),
		
		`order_date` varchar(250),
		`order_time` varchar(250),
		`order_status` int(3),
		`order_shipping` int(1),
		`order_payment` int(1),
		
		`order_total` int(10), 
		PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`order_product` ( 
		`order_id` int(10),
		`product_id` int(10),
		`product_title` varchar(64),
		`product_code` varchar(64),
		`product_price` int(10),
		`product_qty` int(5),
		`product_total` int(10)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

Route::set('cart', 'cart')
	->defaults(array(
		'controller' => 'orders',
		'action'     => 'cart',
));

/* DB::query(Database::INSERT, 'ALTER TABLE `order` ADD `order_payment` int(1)')->execute(); */