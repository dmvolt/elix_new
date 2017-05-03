<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Specials extends Controller_Template {

    public function action_special() {

        $alias = $this->request->param('alias');
		
        $content = View::factory($this->template_directory . 'special')
				->bind('edit_interface', $edit_interface)
                ->bind('article', $article);
				
        $specials_obj = new Model_Specials();
		
        $article = $specials_obj->get_content($alias);
		
		if($article){
		
			$edit_interface = Liteedit::get_interface($article['id'], 'specials');
			$this->page_title = $article['descriptions'][$this->lang_id]['title'];
			$this->page_class = 'text-article';
			/****************************** SEO ******************************/	
			$seo_obj = new Model_Seo();
			$seo = $seo_obj->get_seo_to_content($article['id'], 'specials');
			
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
	
    public function action_specials() {
	
        $specials_obj = new Model_Specials();
		$categories_obj = new Model_Categories();
		
		$cat = $this->current_param_cat;
		
		$filter_query = '';
		$inner_join = '';
		$cat_url = '';
		
		if($cat != 'epil'){
			$cat_url = '/'.$cat;
		}
		
		$category_info2 = $categories_obj->getCategory(2, SUBDOMEN);
		
		if($category_info2){
			$filter_query .= ' AND (cc1.category_id = '.$category_info2[0]['id'].' AND cc1.module = "specials") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = s.id ';
			
			$this->page_title = 'Специалисты';
		}
		
		if($cat){
			$category_info1 = $categories_obj->getCategory(1, $cat);
			
			if($category_info1){
				$filter_query .= ' AND (cc2.category_id = '.$category_info1[0]['id'].' AND cc2.module = "specials") ';		
				$inner_join .= ' INNER JOIN `contents_categories` cc2 ON cc2.content_id = s.id ';
			}
			
			$this->page_title = 'Специалисты - '.$category_info1[0]['descriptions'][1]['title'];
		}
		
		$specials = $specials_obj->get_all(0, 0, 100, 's.weight', $inner_join, $filter_query);
	
		$content = View::factory($this->template_directory . 'specials')
					->bind('cat_url', $cat_url)
					->bind('specials', $specials);
					
        $this->template->content = $content;
    }
}
// Specials