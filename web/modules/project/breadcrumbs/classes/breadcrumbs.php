<?php
defined('SYSPATH') or die('No direct script access.');

class Breadcrumbs {
	
    public static function get_breadcrumbs($id = 0, $module = 'cpages', $cat1 = false, $cat2 = false, $cat3 = false) {
		
		$modules = Kohana::modules();
		
        $breadcrumbs = array();
		$cat_tree_prelink = '/services/';
		
		$breadcrumbs[] = array(
			'name' => 'Главная',
			'href' => 'href="/"',
		);
		
		if($module != 'cpages'){
			if (is_file($modules[$module] . 'config/menu' . EXT)) {
				require MODPATH_PROJECT . $module . '/config/menu' . EXT;
				$breadcrumbs[] = array(
					'name' => $menu['name'],
					'href' => 'href="'.$menu['href'].'"',
				);
			}
		}
		
		if($cat1){
			$result1 = Model::factory($module)->get_content($cat1);
			
			$breadcrumbs[] = array(
				'name' => '<img src="/images/back.svg" alt="" class="icon icon--big js-svg"> '.$result1['descriptions'][Data::_('lang_id')]['title'],
				'href' => 'href="'.$cat_tree_prelink.$result1['alias'].'"',
			);
			
			$cat_tree_prelink .= $result1['alias'].'/';
		}
		
		if($cat2){
			$result2 = Model::factory($module)->get_content($cat2);
			
			$breadcrumbs[] = array(
				'name' => '<img src="/images/back.svg" alt="" class="icon icon--big js-svg"> '.$result2['descriptions'][Data::_('lang_id')]['title'],
				'href' => 'href="'.$cat_tree_prelink.$result2['alias'].'"',
			);
			
			$cat_tree_prelink .= $result2['alias'].'/';
		}
		
		if($cat3){
			$result3 = Model::factory($module)->get_content($cat3);
			
			$breadcrumbs[] = array(
				'name' => '<img src="/images/back.svg" alt="" class="icon icon--big js-svg"> '.$result3['descriptions'][Data::_('lang_id')]['title'],
				'href' => 'href="'.$cat_tree_prelink.$result3['alias'].'"',
			);
			
			$cat_tree_prelink .= $result3['alias'].'/';
		}
		
        if ($id) {
			
			if($module == 'photos'){
				$module = 'services';
			}
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