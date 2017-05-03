<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Front extends Controller_Template {

    public function action_index() {
	
        $siteinfo_obj = new Model_Siteinfo();
		$services_obj = new Model_Services();
        $categories_obj = new Model_Categories();
		
		$cat = $this->current_param_cat;
		
		$cat_title = 'Услуги по эпиляции';
		
		$filter_query = '';
		$inner_join = '';
		
		$category_info2 = $categories_obj->getCategory(2, SUBDOMEN);
		
		if($category_info2){
			$filter_query .= ' AND (cc1.category_id = '.$category_info2[0]['id'].' AND cc1.module = "services") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = a.id ';
		}
		
		if($cat){
			$category_info1 = $categories_obj->getCategory(1, $cat);
			
			$child_categories_pre = $categories_obj->getCategories(1, $category_info1[0]['id'], 0);
			
			if($category_info1){
				$filter_query .= ' AND (cc2.category_id = '.$category_info1[0]['id'].' AND cc2.module = "services") ';		
				$inner_join .= ' INNER JOIN `contents_categories` cc2 ON cc2.content_id = a.id ';
			}
			
			if($child_categories_pre){
				foreach($child_categories_pre as $value){
					$services = false;
					
					$sp_filter_query = ' AND (ccs.category_id = '.$value['id'].' AND ccs.module = "services") ';		
					$sp_inner_join = ' INNER JOIN `contents_categories` ccs ON ccs.content_id = a.id ';
					
					$s_filter_query = $filter_query.$sp_filter_query;		
					$s_inner_join = $inner_join.$sp_inner_join;
					
					$services = $services_obj->get_all(0, 0, 100, 'a.weight', $s_inner_join, $s_filter_query);
					$child_categories[] = array(
						'id' => $value['id'],
						'parent_id' => $value['parent_id'],
						'descriptions' => $value['descriptions'],
						'alias' => $value['alias'],
						'thumb' => $value['thumb'],	
						'services' => $services,
					);
				}
			}
			if($cat == 'cosmetology'){
				$cat_title = 'Услуги по косметологии';
			}
		}
		
		$info = $siteinfo_obj->get_siteinfo(1);
		$edit_interface = Liteedit::get_interface($info['id'], 'siteinfo');
		
        $content = View::factory($this->template_directory . 'main')
				->bind('edit_interface', $edit_interface)
				->bind('child_categories', $child_categories)
				->bind('cat', $cat)
				->bind('cat_title', $cat_title)
                ->bind('info', $info);
				
        $this->page_title = 'Главная';
        $this->page_class = 'front';
		
		/****************************** SEO ******************************/
		$seo_obj = new Model_Seo();
		$seo = $seo_obj->get_seo_to_content($info['id'], 'siteinfo');
		if($seo[$this->lang_id]['title'] != ''){
			$this->page_title = $seo[$this->lang_id]['title'];
		}
		$this->meta_description = $seo[$this->lang_id]['meta_d'];
		$this->meta_keywords = $seo[$this->lang_id]['meta_k'];
		/****************************** /SEO *****************************/
		
        $this->template->content = $content;
    }
}
// End Front