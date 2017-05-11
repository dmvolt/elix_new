<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Sertifications extends Controller_Template {

    public function action_sertifications() {
	
        $sertifications_obj = new Model_Sertifications();
		$categories_obj = new Model_Categories();
		
		$payment_methods = Kohana::$config->load('admin/order.payment');
		
		$cat = $this->current_param_cat;
		
		$filter_query = '';
		$inner_join = '';
		$cat_url = '';
		
		if($cat != 'epil'){
			$cat_url = '/'.$cat;
		}
		
		$category_info2 = $categories_obj->getCategory(2, SUBDOMEN);
		
		if($category_info2){
			$filter_query .= ' AND (cc1.category_id = '.$category_info2[0]['id'].' AND cc1.module = "sertifications") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = s.id ';
			
			$this->page_title = 'Сертификаты';
		}
		
		if($cat){
			$category_info1 = $categories_obj->getCategory(1, $cat);
			
			if($category_info1){
				$filter_query .= ' AND (cc2.category_id = '.$category_info1[0]['id'].' AND cc2.module = "sertifications") ';		
				$inner_join .= ' INNER JOIN `contents_categories` cc2 ON cc2.content_id = s.id ';
			}
			
			$this->page_title = 'Сертификаты - '.$category_info1[0]['descriptions'][1]['title'];
		}
		
		$sertifications = $sertifications_obj->get_all(0, 0, 100, 's.weight', $inner_join, $filter_query);
		
		$this->page_class = 'sert';
		
		$content = View::factory($this->template_directory . 'sertifications')
					->bind('cat_url', $cat_url)
					->bind('payment_methods', $payment_methods)
					->bind('sertifications', $sertifications);
					
        $this->template->content = $content;
    }
}
// Sertifications