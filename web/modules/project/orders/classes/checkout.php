<?php
defined('SYSPATH') or die('No direct script access.');
class Checkout {
    public static function contact_form() {
		$payment_methods = Kohana::$config->load('admin/order.payment');
        return View::factory(Data::_('template_directory') . 'checkout')
				->bind('payment_methods', $payment_methods);
    }
}
// End Checkout