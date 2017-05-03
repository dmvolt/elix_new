<?php

defined('SYSPATH') or die('No direct script access.');

class Infoblock {

    public static function infoblock_block($num = 3, $type = 1) {
		
		$categories_obj = new Model_Categories();
		$infoblock_obj = new Model_Infoblock();
		
        $category_info = $categories_obj->getCategory(2, SUBDOMEN);
		
		if($type == 1){
			$content = View::factory('infoblock-right')
                ->bind('infoblocks', $infoblocks);
		} elseif($type == 2){
			$content = View::factory('infoblock-left')
                ->bind('infoblocks', $infoblocks);
		} else {
			$content = View::factory('infoblock-right')
                ->bind('infoblocks', $infoblocks);
		}
        $infoblocks = $infoblock_obj->get_last($num, $type, $category_info[0]['id']);
        return $content;
    }
	
	public static function get_page_block($url) {
	
		$categories_obj = new Model_Categories();
		$infoblock_obj = new Model_Infoblock();
		
        $category_info = $categories_obj->getCategory(2, SUBDOMEN);
		$content = View::factory('infoblock-page')
			->bind('infoblocks', $infoblocks);
        $infoblocks = $infoblock_obj->get_blocks(3, $url, $category_info[0]['id']);
        return $content;
    }
}
// Infoblock