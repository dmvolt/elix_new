<?php

defined('SYSPATH') or die('No direct script access.');

class Liteedit {

    public static function get_script() {
        if(Data::_('is_admin')){
			return View::factory(Data::_('template_directory') . 'block_liteedit');
		} else {
			return null;
		}
    }
	
	public static function get_interface($content_id = 0, $module = 'pages', $field = 'body', $mode = 0) {
        if(Data::_('is_admin')){
		
			$edit_data = array(
				'id' => $content_id,
				'module' => $module,
				'field' => $field,
				'mode' => $mode,
			);
			
			return View::factory(Data::_('template_directory') . 'block_interface')->bind('edit', $edit_data);
		} else {
			return null;
		}
    }
}

// Liteedit