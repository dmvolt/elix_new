<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Address extends Controller {

	public static function set_fields($id, $post = array(), $module = 'pages') {
		$address_obj = new Model_Address();	
		$address_data = Arr::get($post, 'address_data', array());
	
		$address_obj->add($id, $address_data, $module);	
		return true;
    }
	
	public static function get_fields($data = array(), $module = 'pages') {
		$address_obj = new Model_Address();		
		if($data AND !empty($data)){
			$result = $address_obj->get_address_to_content($data['id'], $module);
		} else {
			$languages = Kohana::$config->load('language');
			foreach($languages as $value){
				$result[$value['lang_id']] = array(
					'id' => 0,
					'text1' => '',
					'text2' => '',
					'text3' => '',
					'text4' => '',
				);
			}
		}		
		return View::factory('admin/fields_address')
                ->bind('field', $result);
    }
}