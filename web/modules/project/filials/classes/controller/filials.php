<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Filials extends Controller {

    public function action_index() {
        if ($filial = Arr::get($_GET, 'filial')) {
			
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
			
			if(isset($redirect_data[$filial])){
				Request::initial()->redirect($redirect_data[$filial]['url']);
			} else {
				Request::initial()->redirect('/');
			}
        } else {
			Request::initial()->redirect('/');
        }
    }
}
// End Controller_Filials