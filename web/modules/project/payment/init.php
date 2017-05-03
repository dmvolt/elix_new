<?php defined('SYSPATH') or die('No direct script access.');

// Payment 
Route::set('pay_lang', '<lang>/pay/result', array('lang' => '[a-zA-Z]{2}'))
	->defaults(array(
		'controller' => 'payment',
		'action'     => 'result',		
));

Route::set('pay', 'pay/result')
	->defaults(array(
		'controller' => 'payment',
		'action'     => 'result',		
));

Route::set('pay_success_lang', '<lang>/pay/success', array('lang' => '[a-zA-Z]{2}'))
	->defaults(array(
		'controller' => 'payment',
		'action'     => 'success',		
));

Route::set('pay_success', 'pay/success')
	->defaults(array(
		'controller' => 'payment',
		'action'     => 'success',		
));