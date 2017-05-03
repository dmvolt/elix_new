<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Cpages extends Controller_Template {

	public function action_index() {
	
		$filter_query = '';
		$inner_join = '';
		$page = false;
		
		$cpages_obj = new Model_Cpages();
		$categories_obj = new Model_Categories();
		
        $alias = $this->request->param('page');
		$cat = $this->request->param('cat');

        $content = View::factory($this->template_directory . 'pages')
				->bind('edit_interface', $edit_interface)
                ->bind('page', $page);

		$category_info2 = $categories_obj->getCategory(2, SUBDOMEN);
		
		if($category_info2){
			$filter_query .= ' AND (cc1.category_id = '.$category_info2[0]['id'].' AND cc1.module = "cpages") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = a.id ';
		}
		
		if($cat){
			$category_info1 = $categories_obj->getCategory(1, $cat);
			
			if($category_info1){
				$filter_query .= ' AND (cc2.category_id = '.$category_info1[0]['id'].' AND cc2.module = "cpages") ';		
				$inner_join .= ' INNER JOIN `contents_categories` cc2 ON cc2.content_id = a.id ';
			}
		}
		
		if($alias){
			$filter_query .= ' AND a.alias = "'.$alias.'" ';		
		}
		
		$contents = $cpages_obj->get_all(0, 0, 100, 'a.weight', $inner_join, $filter_query);
		
		if(!empty($contents)){
		
			$page = $contents[0];
			
			$edit_interface = Liteedit::get_interface($page['id'], 'cpages');

			$this->page_title = $page['descriptions'][$this->lang_id]['title'];

			/****************************** SEO ******************************/	
			$seo_obj = new Model_Seo();
			$seo = $seo_obj->get_seo_to_content($page['id'], 'cpages');

			if($seo[$this->lang_id]['title'] != ''){
				$this->page_title = $seo[$this->lang_id]['title'];
			}

			$this->meta_description = $seo[$this->lang_id]['meta_d'];
			$this->meta_keywords = $seo[$this->lang_id]['meta_k'];
			/****************************** /SEO *****************************/
			
			$this->template->content = $content;
			
		} else {
		
			$this->auto_render = false; //не использовать главный шаблон вида "template"
			// Выполняем запрос, обращаясь к роутеру для обработки ошибок
			$attributes = array(
				'code'  => 404, // Ошибка по умолчанию
				'message' => 'Страница не найдена или не существует!'
			);
			echo Request::factory(Route::get('error')->uri($attributes))
				->execute()
				->send_headers()
				->body();
			$this->response->status(404);
			return;
		}
    }
}
// Cpages