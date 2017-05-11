<?php

defined('SYSPATH') or die('No direct script access.');

class Articles {
	
	public static function get_block($cat_alias = '', $num = 12) {
		
		$articles_obj = new Model_Articles();
		$categories_obj = new Model_Categories();
		
		$filter_query = '';
		$inner_join = '';
		
        $category_info_sub = $categories_obj->getCategory(2, SUBDOMEN);
		$category_info_cat = $categories_obj->getCategory(1, $cat_alias);
		
		if($category_info_sub AND count($category_info_sub)>0){
			$filter_query .= ' AND (cc1.category_id = '.$category_info_sub[0]['id'].' AND cc1.module = "articles") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = a.id ';
		}
		
		if($category_info_cat AND count($category_info_cat)>0){
			$filter_query .= ' AND (cc2.category_id = '.$category_info_cat[0]['id'].' AND cc2.module = "articles") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc2 ON cc2.content_id = a.id ';
		}

		$contents = $articles_obj->get_all(0, 0, $num, 'a.id', $inner_join, $filter_query);
		
        return View::factory(Data::_('template_directory') . 'article_block')->bind('contents', $contents);
    }
	
	public static function get_right_block($cat_alias = '', $num = 3) {
		
		$articles_obj = new Model_Articles();
		$categories_obj = new Model_Categories();
		
		$filter_query = '';
		$inner_join = '';
		
        $category_info_sub = $categories_obj->getCategory(2, SUBDOMEN);
		$category_info_cat = $categories_obj->getCategory(1, $cat_alias);
		
		if($category_info_sub AND count($category_info_sub)>0){
			$filter_query .= ' AND (cc1.category_id = '.$category_info_sub[0]['id'].' AND cc1.module = "articles") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = a.id ';
		}
		
		if($category_info_cat AND count($category_info_cat)>0){
			$filter_query .= ' AND (cc2.category_id = '.$category_info_cat[0]['id'].' AND cc2.module = "articles") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc2 ON cc2.content_id = a.id ';
		}

		$contents = $articles_obj->get_all(0, 0, $num, 'a.id', $inner_join, $filter_query);
		
        return View::factory(Data::_('template_directory') . 'article_right_block')->bind('contents', $contents);
    }
}
// Articles