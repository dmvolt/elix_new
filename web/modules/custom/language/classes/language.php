<?php

defined('SYSPATH') or die('No direct script access.');

class Language {

    public static function get_block($languages) {
	
		if(count($languages)<2){
			$languages = null;
		}
        return View::factory(Data::_('template_directory') . 'language_block')->set('languages', $languages);
    }

}