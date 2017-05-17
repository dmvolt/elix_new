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
		
		$this->page_class = 'service';
		
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
		$related_obj = new Model_Related();
		$partners_obj = new Model_Partners();
		
		$partners = array();
		
		$cat = false;
		$cat1 = $this->request->param('cat1');
		$cat2 = $this->request->param('cat2');
		$cat3 = $this->request->param('cat3');
		
		$filter_query = '';
		$inner_join = '';
		$cat_tree_prelink = '/';
		
		$city_info = $categories_obj->getCategory(2, SUBDOMEN);
		
		if($city_info){
			$filter_query .= ' AND (cc1.category_id = '.$city_info[0]['id'].' AND cc1.module = "services") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = a.id ';
			
			$this->page_title = 'Услуги';
		}
		
		if($cat1){
			$cat = $cat1;
			$cat_tree_prelink .= $cat1.'/';
		}
		
		if($cat2){
			$cat = $cat2;
			$cat_tree_prelink .= $cat2.'/';
		}
		
		if($cat3){
			$cat = $cat3;
			$cat_tree_prelink .= $cat3.'/';
		}
		
		if($cat){
			$service_info = $services_obj->get_content($cat);
			
			if($service_info){
				$filter_query .= ' AND a.parent_id = '.$service_info['id'].' ';		
			}
			
			$related = $related_obj->get_related_to_content($service_info['id'], 0, 'services');
			
			if(!empty($related)){
				foreach($related as $item){
					$partners[] = $partners_obj->get_content($item['code']);
				}
			}
			
			$this->page_title .= ' - '.$service_info['descriptions'][1]['title'];
		}
		
		$total = $services_obj->get_total_all(0, $inner_join, $filter_query);   // Получение общего количества записей
		$result = Pagination::start($total);
		$pagination = Pagination::navigation($result['page'], $total, $result['total_page'], $result['num']);
		$contents = $services_obj->get_all(0, $result['start'], $result['num'], 'a.weight', $inner_join, $filter_query);
		
		$this->page_class = 'services';
		
		$content = View::factory($this->template_directory . 'services')
					->bind('service_info', $service_info)
					->bind('cat1', $cat1)
					->bind('cat2', $cat2)
					->bind('cat3', $cat3)
					->bind('partners', $partners)
					->bind('cat_tree_prelink', $cat_tree_prelink)
					->bind('pagination', $pagination)
					->bind('services', $contents);
					
        $this->template->content = $content;
    }
}
// Services