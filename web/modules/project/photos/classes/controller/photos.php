<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Photos extends Controller_Template {

    public function action_photo() {
	
        $alias = $this->request->param('alias');

        $content = View::factory($this->template_directory . 'photo')
				->bind('edit_interface', $edit_interface)
                ->bind('article', $article);

        $services_obj = new Model_Services();
        $article = $services_obj->get_content($alias);
		
		$this->page_class = 'photo';
		
		if($article){
		
			$edit_interface = Liteedit::get_interface($article['id'], 'services');

			$this->page_title = $article['descriptions'][$this->lang_id]['title'];
			
			/****************************** SEO ******************************/	
			$seo_obj = new Model_Seo();
			$seo = $seo_obj->get_seo_to_content($article['id'], 'services');
			
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

    public function action_photos() {
	
        $services_obj = new Model_Services();
        $categories_obj = new Model_Categories();
		
		$this->page_class = 'photo';
		
		$filter_query = '';
		$inner_join = '';
		
		$category_info2 = $categories_obj->getCategory(2, SUBDOMEN);
		
		if($category_info2){
			$filter_query .= ' AND (cc1.category_id = '.$category_info2[0]['id'].' AND cc1.module = "services") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = a.id ';
			
			$this->page_title = 'Фотогалерея';
		}
		
		$contents = $services_obj->get_all(0, 0, 100, 'a.weight', $inner_join, $filter_query);
		
		$content = View::factory($this->template_directory . 'photos')
					->bind('photos', $contents);
					
        $this->template->content = $content;
    }
}
// Photos