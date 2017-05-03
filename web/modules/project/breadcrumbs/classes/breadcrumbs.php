<?php

defined('SYSPATH') or die('No direct script access.');

class Breadcrumbs {

    public static function get_breadcrumbs($id = 0, $module = 'cpages', $cat = false, $pre_cat = false) {
		
		$categories_obj = new Model_Categories();
		$modules = Kohana::modules();
		
        $breadcrumbs = array();
		
		$breadcrumbs[] = array(
			'name' => 'Главная',
			'href' => 'href="/"',
		);
		
		if($pre_cat){
			$cat_link = '/';
			$pre_cat_info = $categories_obj->getCategory(1, $pre_cat);
			
			if($pre_cat != 'epil'){$cat_link = '/'.$pre_cat;}
			
			$breadcrumbs[] = array(
				'name' => $pre_cat_info[0]['descriptions'][Data::_('lang_id')]['title'],
				'href' => 'href="'.$cat_link.'"',
			);
		}

		if($module != 'cpages'){
			$cat_link = '';
			if($pre_cat != 'epil'){$cat_link = '/'.$pre_cat;}
			if (is_file($modules[$module] . 'config/menu' . EXT)) {
				require MODPATH_PROJECT . $module . '/config/menu' . EXT;
				$breadcrumbs[] = array(
					'name' => $menu['name'],
					'href' => 'href="'.$cat_link.$menu['href'].'"',
				);
			}
		}

		if($cat){
			$cat_info = $categories_obj->getCategory(1, $cat);
			
			$cat_link = '';
			if($pre_cat != 'epil'){$cat_link = '/'.$pre_cat;}
			
			if (is_file($modules[$module] . 'config/menu' . EXT)) {
				require MODPATH_PROJECT . $module . '/config/menu' . EXT;
				$cat_link .= $menu['href'];
			} else {
				$cat_link .= '/'.$module;
			}
			
			$breadcrumbs[] = array(
				'name' => $cat_info[0]['descriptions'][Data::_('lang_id')]['title'],
				'href' => 'href="'.$cat_link.'/'.$cat_info[0]['alias'].'"',
			);
		}

        if ($id) {
			$result = Model::factory($module)->get_content($id);

            if ($result) {         
                $breadcrumbs[] = array(
                    'name' => $result['descriptions'][Data::_('lang_id')]['title'],
                    'href' => '',
                );
            }
        }
        return View::factory('breadcrumbs')->set('breadcrumbs', $breadcrumbs);
    }
}
// Breadcrumbs