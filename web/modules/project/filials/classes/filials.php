<?php

defined('SYSPATH') or die('No direct script access.');

class Filials {

    public static function get_block($filial) {
		
		$redirect_data = array();
		
		$categories_obj = new Model_Categories();
		$cities = $categories_obj->getCategories(2, 0, 0);
		
		if($cities){
			foreach($cities as $value){
				$redirect_data[$value['alias']] = array(
					'url' => 'http://'.$value['alias'].'.'.PARENT_HOST.'/',
					'name' => $value['descriptions'][1]['title'],
				);
			}
		} else {
			$redirect_data = Kohana::$config->load('redirect');
		}
		
        return View::factory(Data::_('template_directory') . 'filial_block')
				->set('filial', $filial)
				->set('redirect_data', $redirect_data);
    }
}