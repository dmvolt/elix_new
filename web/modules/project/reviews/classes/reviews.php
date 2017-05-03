<?php

defined('SYSPATH') or die('No direct script access.');

class Reviews {
    public static function get_block($num = 1) {

        $reviews_obj = new Model_Reviews();		
			
        $content = $reviews_obj->get_last($num);		
        return View::factory(Data::_('template_directory') . 'reviews-block')->bind('content', $content);
    }
}