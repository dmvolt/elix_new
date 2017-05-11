<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Reviews extends Controller_Template {

    public function action_review() {
	
        $id = $this->request->param('id');
		
        $content = View::factory($this->template_directory . 'review')
				->bind('edit_interface', $edit_interface)
                ->bind('article', $article);
				
        $reviews_obj = new Model_Reviews();
        $article = $reviews_obj->get_content($id);
		
		$this->page_class = 'feedback';
		
		if($article){
		
			$edit_interface = Liteedit::get_interface($article['id'], 'reviews');
			$this->page_title = $article['descriptions'][$this->lang_id]['title'];
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
	
    public function action_reviews() {
	
        $reviews_obj = new Model_Reviews();
		$categories_obj = new Model_Categories();
		$seo_obj = new Model_Seo();
		
		$reviews = array();
			
		$catpages = $categories_obj->getCategory(2, SUBDOMEN);
		
		if($catpages){
			$parent = $reviews_obj->get_all_to_cat($catpages[0]['id']);
			if(!empty($parent)){
				foreach($parent as $item){
					$childs = $reviews_obj->get_childs($item['id']);
					$reviews[] = array(
						'id' => $item['id'],
						'parent_id' => $item['parent_id'],
						'date' => $item['date'],
						'group_id' => $item['group_id'],
						'thumb' => $item['thumb'],
						'images' => $item['images'],
						'descriptions' => $item['descriptions'],
						'answer' => $childs,
					);
				}
			}
		}
		$this->page_title = 'Отзывы';
		$this->page_class = 'feedback';
		
		$modulinfo = Modulinfo::get_block('reviews', $catpages[0]['id']);
		if(!empty($modulinfo)){
			/****************************** SEO ******************************/	
			$seo = $seo_obj->get_seo_to_content($modulinfo[0]['id'], 'modulinfo');
			
			if($seo[$this->lang_id]['title'] != ''){
				$this->page_title = $seo[$this->lang_id]['title'];
			}
			
			$this->meta_description = $seo[$this->lang_id]['meta_d'];
			$this->meta_keywords = $seo[$this->lang_id]['meta_k'];
			/****************************** /SEO *****************************/
		}
		
		$content = View::factory('reviews')
					->bind('modulinfo', $modulinfo)
					->bind('reviews', $reviews);
					
        $this->template->content = $content;
    }
}
// Reviews