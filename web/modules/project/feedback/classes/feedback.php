<?php
defined('SYSPATH') or die('No direct script access.');
class Feedback {
	
	public static function contact_form() {
        return View::factory(Data::_('template_directory') . 'feedback');
    }
	
	public static function rev_form() {
        return View::factory(Data::_('template_directory') . 'review_form');
    }
}
// End Feedback