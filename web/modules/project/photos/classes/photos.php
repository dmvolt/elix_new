<?php

defined('SYSPATH') or die('No direct script access.');

class Photos {
	
	public static function get_front_block($alias = '') {
		
		$photos_obj = new Model_Photos();
        $contents = $photos_obj->get_content($alias);
        return View::factory(Data::_('template_directory') . 'photos_front_block')->bind('contents', $contents);
    }
}
// Articles