<?php
defined('SYSPATH') or die('No direct script access.');
class Categories {
    public static function get_block($cat_alias = '', $field = 'body'){
		$return = '';
		$categories_obj = new Model_Categories();
		$category_info_cat = $categories_obj->getCategory(1, $cat_alias);
		if($category_info_cat AND count($category_info_cat)>0){
			$return .= $category_info_cat[0]['descriptions'][1][$field];
		}
		return $return;
    }
}
// Categories