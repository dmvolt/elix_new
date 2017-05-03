<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Seo {

	public static function set_fields($id, $post = array(), $module = 'pages') {
		$seo_obj = new Model_Seo();	
		$seo_data = Arr::get($post, 'seo_data', array());
	
		$seo_obj->add($id, $seo_data, $module);	
		return true;
    }
	
	public static function get_fields($data = array(), $module = 'pages') {
		$seo_obj = new Model_Seo();		
		if($data AND !empty($data)){
			$result = $seo_obj->get_seo_to_content($data['id'], $module);
		} else {
			$languages = Kohana::$config->load('language');
			foreach($languages as $value){
				$result[$value['lang_id']] = array(
					'id' => 0,
					'title' => '',
					'meta_k' => '',
					'meta_d' => '',
					'alt' => '',
				);
			}
		}		
		return View::factory('admin/fields_seo')
                ->bind('field', $result);
    }
}