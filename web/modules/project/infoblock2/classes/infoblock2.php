<?php

defined('SYSPATH') or die('No direct script access.');

class Infoblock2 {

    public static function get_blocks($cat_alias = '') {
		
		$layers = Kohana::$config->load('layers');
		
		$main_bg = 'girl-1.png';
		$main_bg_mobile = 'girl-3.png';
		
		if($cat_alias == 'cosmetology'){
			$main_bg = 'girl-2.png';
			$main_bg_mobile = 'girl-3.png';
		}
		
		$infoblock2_obj = new Model_Infoblock2();
		$categories_obj = new Model_Categories();
		
		$filter_query = '';
		$inner_join = '';
		
        $category_info_sub = $categories_obj->getCategory(2, SUBDOMEN);
		$category_info_cat = $categories_obj->getCategory(1, $cat_alias);
		
		if($category_info_sub AND count($category_info_sub)>0){
			$filter_query .= ' AND (cc1.category_id = '.$category_info_sub[0]['id'].' AND cc1.module = "infoblock2") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = i2.id ';
		}
		
		if($category_info_cat AND count($category_info_cat)>0){
			$filter_query .= ' AND (cc2.category_id = '.$category_info_cat[0]['id'].' AND cc2.module = "infoblock2") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc2 ON cc2.content_id = i2.id ';
		}

		$contents = $infoblock2_obj->get_all(0, 0, 1000, $inner_join, $filter_query);
		
		return View::factory(Data::_('template_directory') . 'infoblock2')
				->bind('main_bg', $main_bg)
				->bind('main_bg_mobile', $main_bg_mobile)
				->bind('layers', $layers)
                ->bind('contents', $contents);
    }
}
// Infoblock2