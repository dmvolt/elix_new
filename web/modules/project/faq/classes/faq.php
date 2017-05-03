<?php

defined('SYSPATH') or die('No direct script access.');

class Faq {
    public static function get_block($num = 1) {

        $faq_obj = new Model_Faq();		
			
        $content = $faq_obj->get_last($num);		
        return View::factory(Data::_('template_directory') . 'faq-block')->bind('content', $content);
    }
}