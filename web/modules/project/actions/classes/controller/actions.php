<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Actions extends Controller_Template {

	public function action_action() {
		$categories_obj = new Model_Categories();
		$actions_obj = new Model_Actions();  // Создание экземпляра объекта модели
		
		$alias = $this->request->param('alias');

        $content = View::factory($this->template_directory . 'actions')
				->bind('edit_interface', $edit_interface)
                ->bind('actions', $one_action);

        $category_info = $categories_obj->getCategory(2, SUBDOMEN);
		
        $one_action = $actions_obj->get_content_to_cat($category_info[0]['id'], $alias); // Создание экземпляра объекта модели с выборкой из метода
		
		if($one_action){
		
			$edit_interface = Liteedit::get_interface($one_action['id'], 'actions');

			$this->page_title = $one_action['descriptions'][$this->lang_id]['title'];
			/****************************** SEO ******************************/	
			$seo_obj = new Model_Seo();
			$seo = $seo_obj->get_seo_to_content($one_action['id'], 'actions');

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

    public function action_actions() {
	
		$categories_obj = new Model_Categories();
		$actions_obj = new Model_Actions();
		
		$cat = $this->current_param_cat;
		
		$filter_query = '';
		$inner_join = '';
		$cat_url = '';
		
		if($cat != 'epil'){
			$cat_url = '/'.$cat;
		}
		
		$category_info2 = $categories_obj->getCategory(2, SUBDOMEN);
		
		if($category_info2){
			$filter_query .= ' AND (cc1.category_id = '.$category_info2[0]['id'].' AND cc1.module = "actions") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = a.id ';
			
			$this->page_title = 'Акции';
		}
		
		if($cat){
			$category_info1 = $categories_obj->getCategory(1, $cat);
			
			if($category_info1){
				$filter_query .= ' AND (cc2.category_id = '.$category_info1[0]['id'].' AND cc2.module = "actions") ';		
				$inner_join .= ' INNER JOIN `contents_categories` cc2 ON cc2.content_id = a.id ';
			}
			
			$this->page_title = 'Акции - '.$category_info1[0]['descriptions'][1]['title'];
		}
		
		$total = $actions_obj->get_total_all(0, $inner_join, $filter_query);   // Получение общего количества записей
		$result = Pagination::start($total);
		$pagination = Pagination::navigation($result['page'], $total, $result['total_page'], $result['num']);
		$contents = $actions_obj->get_all(0, $result['start'], $result['num'], 'a.weight', $inner_join, $filter_query);
       
        $content = View::factory($this->template_directory . 'all-actions')
                ->bind('all_actions', $contents)
				->bind('cat_url', $cat_url)
				->bind('modulinfo', $modulinfo)
				->bind('pagination', $pagination);
		
		$modulinfo = Modulinfo::get_block('actions', $category_info2[0]['id']);
		if(!empty($modulinfo)){
			/****************************** SEO ******************************/	
			$seo_obj = new Model_Seo();
			$seo = $seo_obj->get_seo_to_content($modulinfo[0]['id'], 'modulinfo');
			
			if($seo[$this->lang_id]['title'] != ''){
				$this->page_title = $seo[$this->lang_id]['title'];
			}
			
			$this->meta_description = $seo[$this->lang_id]['meta_d'];
			$this->meta_keywords = $seo[$this->lang_id]['meta_k'];
			/****************************** /SEO *****************************/
		}
		
        $this->template->content = $content;
    }
}
// Actions