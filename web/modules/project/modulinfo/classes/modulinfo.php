<?php

defined('SYSPATH') or die('No direct script access.');

class Modulinfo {

    public static function get_admin_block($module = 'articles', $cat_id = false) {
        $content = View::factory('admin/modulinfo-block')
				->bind('module', $module)
                ->bind('modulinfo', $modulinfo);
        $modulinfo_obj = new Model_Modulinfo();
		
		if($cat_id){
			$modulinfo = $modulinfo_obj->get_block_to_cat($module, $cat_id);
		} else {
			$modulinfo = $modulinfo_obj->get_block($module);
		}
        return $content;
    }
	
	public static function get_block($module = 'articles', $cat_id = false) {
        $modulinfo_obj = new Model_Modulinfo();
		if($cat_id){
			$modulinfo = $modulinfo_obj->get_block_to_cat($module, $cat_id);
		} else {
			$modulinfo = $modulinfo_obj->get_block($module);
		}
        return $modulinfo;
    }
}
// Modulinfo