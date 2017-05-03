<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Faq extends Controller_Template {

    public function action_view() {
	
        $id = $this->request->param('id');
        
		$content = View::factory($this->template_directory . 'view')
				->bind('edit_interface', $edit_interface)
                ->bind('article', $article);
				
        $faq_obj = new Model_Faq();
        $article = $faq_obj->get_content($id);
		
		if($article){
		
			$edit_interface = Liteedit::get_interface($article['id'], 'faq');
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
	
    public function action_faq() {
	
        $faq_obj = new Model_Faq();
		$categories_obj = new Model_Categories();
		$seo_obj = new Model_Seo();
		
		$faq = array();
			
		$cat = $this->current_param_cat;
		
		$filter_query = '';
		$inner_join = '';
		$cat_url = '';
		
		if($cat != 'epil'){
			$cat_url = '/'.$cat;
		}
		
		$category_info2 = $categories_obj->getCategory(2, SUBDOMEN);
		
		if($category_info2){
			$filter_query .= ' AND (cc1.category_id = '.$category_info2[0]['id'].' AND cc1.module = "faq") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = f.id ';
			
			$this->page_title = 'Вопрос ответ';
		}
		
		if($cat){
			$category_info1 = $categories_obj->getCategory(1, $cat);
			
			if($category_info1){
				$filter_query .= ' AND (cc2.category_id = '.$category_info1[0]['id'].' AND cc2.module = "faq") ';		
				$inner_join .= ' INNER JOIN `contents_categories` cc2 ON cc2.content_id = f.id ';
			}
			
			$modulinfo = Modulinfo::get_block('faq', $category_info1[0]['id']);
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
			
			$this->page_title = 'Вопрос ответ - '.$category_info1[0]['descriptions'][1]['title'];
		}
		
		$total = $faq_obj->get_total_all(0, $inner_join, $filter_query);   // Получение общего количества записей
		$result = Pagination::start($total);
		$pagination = Pagination::navigation($result['page'], $total, $result['total_page'], $result['num']);
		$parent = $faq_obj->get_all(0, $result['start'], $result['num'], 'f.weight', $inner_join, $filter_query);
		
		if(!empty($parent)){
			foreach($parent as $item){
				$childs = $faq_obj->get_childs($item['id']);
				$faq[] = array(
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
		
		$content = View::factory('faq')
					->bind('modulinfo', $modulinfo)
					->bind('pagination', $pagination)
					->bind('cat_url', $cat_url)
					->bind('faq', $faq);
					
        $this->template->content = $content;
    }
}
// Faq