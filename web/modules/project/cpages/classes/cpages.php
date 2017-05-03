<?php

defined('SYSPATH') or die('No direct script access.');

class Cpages {
    public static function cpages_block($num = 100) {
        $content = View::factory(Data::_('template_directory') . 'cpages-block')
                ->bind('cpages', $cpages);

        $cpages_obj = new Model_Cpages();
		$categories_obj = new Model_Categories();
		
        $result = $cpages_obj->get_last($num);
		
		if($result){
			foreach($result as $value){
				$cat_id = $cpages_obj->get_one_parent($value['id']);
				$catinfo = $categories_obj->getNode($cat_id);
				if(!empty($result)){
					$cpages[] = array(
						'category' => $catinfo,
						'content' => $value,
					);
				}
			}
		}

        return $content;
    }
	
	public static function cpages_front_block() {
		$categories_obj = new Model_Categories();
		$cpages_obj = new Model_Cpages();
		$cpages = array();
		
		$catpages = $categories_obj->getCategories(1, 0, 2);
		
		if($catpages){
			foreach($catpages as $value){
				$result = $cpages_obj->get_all_to_cat_in_front($value['id']);
				if(!empty($result)){
					$cpages[] = array(
						'category' => $value,
						'cpages' => $result,
					);
				}
			}
		}
							  		
        $content = View::factory(Data::_('template_directory') . 'cpages-front-block')
                ->bind('cpages', $cpages);

        return $content;
    }
	
	public static function cpages_current($id) {
		$categories_obj = new Model_Categories();
		$cpages_obj = new Model_Cpages();
		$cpages = array();
		
		$catpages = $cpages_obj->get_parent($id);
		
		if($catpages){
			foreach($catpages as $cat_id){
				$result = $cpages_obj->get_current_to_cat($cat_id, $id);
				$catinfo = $categories_obj->getNode($cat_id);
				if(!empty($result)){
					$cpages[] = array(
						'category' => $catinfo,
						'cpages' => $result,
					);
				}
			}
		}
							  		
        $content = View::factory(Data::_('template_directory') . 'cpages-current-block')
                ->bind('cpages', $cpages);

        return $content;
    }
}
// Cpages