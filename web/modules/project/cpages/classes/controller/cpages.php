<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Cpages extends Controller_Template {

	public function action_index() {
	
		$filter_query = '';
		$filter_query2 = '';
		$inner_join = '';
		$page = false;
		
		$cpages_obj = new Model_Cpages();
		$categories_obj = new Model_Categories();
		$services_obj = new Model_Services();
		
        $alias = $this->request->param('page');

        $content = View::factory($this->template_directory . 'pages')
				->bind('edit_interface', $edit_interface)
				->bind('page', $page)
                ->bind('services', $services);

		$category_info2 = $categories_obj->getCategory(2, SUBDOMEN);
		
		if($category_info2){
			$filter_query .= ' AND (cc1.category_id = '.$category_info2[0]['id'].' AND cc1.module = "cpages") ';	
			$filter_query2 .= ' AND (cc1.category_id = '.$category_info2[0]['id'].' AND cc1.module = "services") ';
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = a.id ';
		}
		
		if($alias){
			$filter_query .= ' AND a.alias = "'.$alias.'" ';

			if($alias == 'price'){
				$services = $services_obj->get_all(0, 0, 100, 'a.weight', $inner_join, $filter_query2);
			}
		}
		
		$contents = $cpages_obj->get_all(0, 0, 100, 'a.weight', $inner_join, $filter_query);
		
		$this->page_class = 'action';
		
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