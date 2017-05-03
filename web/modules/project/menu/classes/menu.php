<?php

defined('SYSPATH') or die('No direct script access.');

class Menu {

	public static function getmenu($dictionary, $template_suffix = '') {
	
        $menu = array();
		$menu_obj = new Model_Menu();
        $url = $_SERVER['REQUEST_URI'];
		$group_menu = Kohana::$config->load('menu.group_menu');
		
        $result = $menu_obj->get_menu_to_dictionary_id($dictionary);
		
		if($result){
			foreach($result as $value){
			
				$cat = 'epil';
				
				if($value['url'] != '/'){
					$cat = substr_replace($value['url'], '', 0, 1);
				}
				
				$childs = $menu_obj->getChildren($value['id']);
				
				$menu[] = array(
					'id' => $value['id'],
					'content_id' => $value['content_id'],
					'parent_id' => $value['parent_id'],
					'descriptions' => $value['descriptions'],
					'url' => $value['url'],
					'icon' => $value['icon'],
					'dictionary_id' => $value['dictionary_id'],
					'weight' => $value['weight'],	
					'status' => $value['status'],
					'module' => $value['module'],
					'cat' => $cat,
					'childs' => $childs,
				);
			}
		}
		
		return View::factory(Data::_('template_directory') . 'menu'.$template_suffix)
                ->set('menu', $menu)
                ->set('url', $url)
                ->set('group_menu', $group_menu[$dictionary]);
    }
	
	public static function get_block_menu($dictionary) {
		$menu_obj = new Model_Menu();
        $url = $_SERVER['REQUEST_URI'];
        $menu = $menu_obj->get_menu_to_dictionary_id($dictionary);
		
		return View::factory(Data::_('template_directory') . 'block_menu')
                ->set('menu', $menu)
                ->set('url', $url)
                ->set('dictionary', $dictionary);
    }
    
    public static function get_main_menu() {
        $menu = array();
        $category = new Model_Categories();
        $main_cats = $category->getCategories(1, 0, 0);
        
        $current_alias = Request::current()->param('cat');
        
        if(isset($current_alias)){
            $parent_cat = $category->getCategory(0, $current_alias);
            if(count($parent_cat)>0){
                $current_parent_id = $parent_cat[0]['parent_id'];
            } else {
                $current_parent_id = null;
            }
        } else {
            $current_parent_id = null;
        }
        foreach ($main_cats as $value) {
            $children = $category->getCategories(1, $value['id'], 0);
            if($current_parent_id == $value['id']){
                $active = 'class="active"';
            } elseif($value['alias'] == 'catalog' AND !$current_parent_id) {
                $active = 'class="active"';
            } else {
                $active = '';
            }
            $menu[] = array(
                'id' => $value['id'],
                'descriptions' => $value['descriptions'],
                'alias' => $value['alias'],
                'parent_id' => $value['parent_id'],
                'active' => $active,
                'children' => $children,
            );
        }
        return View::factory(Data::_('template_directory') . 'main_menu')->set('menu', $menu);
    }
}