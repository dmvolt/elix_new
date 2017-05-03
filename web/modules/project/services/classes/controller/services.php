<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Services extends Controller_Template {

    public function action_service() {
	
		$services_obj = new Model_Services();
		$related_obj = new Model_Related();
		$partners_obj = new Model_Partners();
		
		$partners = array();
	
        $alias = $this->request->param('alias');
		$cat = $this->current_param_cat;
		$cat2 = $this->request->param('cat2');
		
        $content = View::factory($this->template_directory . 'service')
				->bind('edit_interface', $edit_interface)
				->bind('cat', $cat)
				->bind('cat2', $cat2)
				->bind('partners', $partners)
                ->bind('service', $service);
				
        
        $service = $services_obj->get_content($alias);
		
		$this->page_class = 'text-service';
		
		if($service){
		
			$edit_interface = Liteedit::get_interface($service['id'], 'services');		
			$this->service_id = $service['id'];
			$this->page_title = $service['descriptions'][$this->lang_id]['title'];
			
			$related = $related_obj->get_related_to_content($service['id'], 0, 'services');
			
			if(!empty($related)){
				foreach($related as $item){
					$partners[] = $partners_obj->get_content($item['code']);
				}
			}
			
			/****************************** SEO ******************************/	
			$seo_obj = new Model_Seo();
			$seo = $seo_obj->get_seo_to_content($service['id'], 'services');
			
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
	
    public function action_services() {
	
        $services_obj = new Model_Services();
        $categories_obj = new Model_Categories();
		
		$cat = $this->current_param_cat;
		$cat2 = $this->request->param('cat2');
		
		$filter_query = '';
		$inner_join = '';
		
		$category_info2 = $categories_obj->getCategory(2, SUBDOMEN);
		
		if($category_info2){
			$filter_query .= ' AND (cc1.category_id = '.$category_info2[0]['id'].' AND cc1.module = "services") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = a.id ';
			
			$this->page_title = 'Услуги';
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
			
			$this->page_title .= ' - '.$category_info1[0]['descriptions'][1]['title'];
		}
		
		if($cat2){
			$category_info3 = $categories_obj->getCategory(1, $cat2);
			
			if($category_info3){
				$filter_query .= ' AND (cc3.category_id = '.$category_info3[0]['id'].' AND cc3.module = "services") ';		
				$inner_join .= ' INNER JOIN `contents_categories` cc3 ON cc3.content_id = a.id ';
			}
			
			$this->page_title .= ' - '.$category_info3[0]['descriptions'][1]['title'];
		}
		
		$total = $services_obj->get_total_all(0, $inner_join, $filter_query);   // Получение общего количества записей
		$result = Pagination::start($total);
		$pagination = Pagination::navigation($result['page'], $total, $result['total_page'], $result['num']);
		$contents = $services_obj->get_all(0, $result['start'], $result['num'], 'a.weight', $inner_join, $filter_query);
		
		$content = View::factory($this->template_directory . 'services')
					->bind('child_categories', $child_categories)
					->bind('category_info1', $category_info1)
					->bind('category_info2', $category_info3)
					->bind('cat', $cat)
					->bind('cat2', $cat2)
					->bind('pagination', $pagination)
					->bind('services', $contents);
					
        $this->template->content = $content;
    }
}
// Services