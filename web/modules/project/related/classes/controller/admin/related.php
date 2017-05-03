<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Related extends Controller {

	public static function set_fields($id, $post = array(), $module = 'products') {
		$related_obj = new Model_Related();
		$related = Arr::get($post, 'related', '');
		
		$related_obj->add($id, $related);
		return true;
    }
	
	public static function get_fields($data = array(), $module = 'products') {
		$related_obj = new Model_Related();		
		if($data AND !empty($data)){
			$result = $related_obj->get_related_to_content($data['id'], 1);
		} else {
			$result = '';
		}		
		return View::factory('admin/fields_related')
                ->bind('field', $result);
    }
}