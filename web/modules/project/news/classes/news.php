<?php

defined('SYSPATH') or die('No direct script access.');

class News {

    public static function news_block($num = 25) {
        $content = View::factory('news-block')
                ->bind('last_news', $last_news);

        $news_obj = new Model_News();
		$categories_obj = new Model_Categories();
		
		$category_info = $categories_obj->getCategory(1, SUBDOMEN);
        $last_news = $news_obj->get_all_to_cat($category_info[0]['id'], 0, $num);

        return $content;
    }
	
	public static function current_block($content_id, $num = 25) {
	
		$categories_obj = new Model_Categories();
		$news_obj = new Model_News();
		 
        $content = View::factory('news-current-block')
                ->bind('current_news', $current_news);
		
		$category_info = $categories_obj->getCategory(1, SUBDOMEN);
       
        $current_news = $news_obj->get_current_to_cat($category_info[0]['id'], $content_id, 0, $num);

        return $content;
    }
}
// News