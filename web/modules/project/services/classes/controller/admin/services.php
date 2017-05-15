<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Kohana user guide and api browser.
 *
 * @package    Kohana/Userguide
 * @category   Controllers
 * @author     Kohana Team
 */
class Controller_Admin_Services extends Controller_Admin_Template {

    public function action_index() {
	
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
		$services_obj = new Model_Services();
		$categories_obj = new Model_Categories();
		
		$catid1 = Arr::get($_GET, 'cat1', null); // Получение параметра cat1 (Город)
		
		$contents = array();
		
		$cat_name = '';
		$filter_query = '';
		$inner_join = '';
		$parameters = '';
		$i = 0;
		
        $content = View::factory('admin/services')
				->bind('parameters', $parameters)
                ->bind('contents', $contents)
				->bind('parent_services', $parent_services)
				->bind('pagination', $pagination)
                ->bind('pagination2', $pagination2)
				->bind('cat_name', $cat_name)
                ->bind('parent1', $catid1)
                ->bind('group_cat', $group_cat);
				
		$group_cat = Kohana::$config->load('menu.group_cat');
		
		foreach ($group_cat as $group) { 
			$result = $categories_obj->getCategories($group['dictionary_id'], 0, 2);
			if ($result) {
				foreach ($result as $item) {
					$cats[$group['dictionary_id']][$item['id']] = array(
						'name' => $item['descriptions'][1]['title'],
					);
					$cats2[$group['dictionary_id']][] = array(
						'id' => $item['id'],
						'name' => $item['descriptions'][1]['title'],
					);
				}
			}
        }
		
		if($catid1 AND !empty($catid1)){
			$filter_query .= ' AND (cc1.category_id = '.$catid1.' AND cc1.module = "services") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = a.id ';
			
			$parameters .= ($i)?'&cat1='.$catid1:'?cat1='.$catid1;
			$i++;
			
			$cat_name .= 'Услуги - '.$cats[2][$catid1]['name'];
		}
			
		$total = $services_obj->get_total_all(1, $inner_join, $filter_query, $this->lang_id);   // Получение общего количества записей
		$result = Pagination::start($total);
		$pagination = Pagination::admin_navigation($result['page'], $total, $result['total_page'], $result['num']);
		$pagination2 = Pagination::admin_navigation2($result['page'], $total, $result['total_page'], $result['num']);
		$parent_contents = $services_obj->get_parent_all(1, $result['start'], $result['num'], 'a.weight', $inner_join, $filter_query, 0, $this->lang_id);
		
		if($parent_contents AND count($parent_contents)>0){
			foreach($parent_contents as $value){
				
				$children = $services_obj->get_parent_all(1, 0, 1000, 'a.weight', $inner_join, $filter_query, $value['id'], $this->lang_id);
				$contents[] = array(
					'service' => $value,
					'children' => $children,
				);
			}
		}

		if($result['page']){
			$parameters .= ($i) ? '&page='.$result['page'] : '?page='.$result['page'];
			$i++;
		}
        $this->template->content = $content;
    }
	
    public function action_add() {
	
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
		$services_obj = new Model_Services();
        if (isset($_POST['descriptions'][1]['title'])) {
            $v_data = array('descriptions' => $_POST['descriptions'], 'title' => $_POST['descriptions'][1]['title'], 'alias' => $_POST['alias']);
            $validation = Validation::factory($v_data);
            $validation->rule('title', 'not_empty');
            $validation->rule('title', 'min_length', array(':value', '2'));
            $validation->rule('title', 'max_length', array(':value', '128'));
            $validation->rule('alias', 'not_empty');
            $validation->rule('alias', 'alpha_dash');
            $validation->rule('alias', 'max_length', array(':value', '128'));
            $validation->rule('alias', array($this, 'unique_url'));
            $validation->labels(array('title' => $this->lang['text_name'], 'alias' => $this->lang['text_alias']));
            if ($validation->check()) {
			
                $add_data = array(
                    'descriptions' => Arr::get($_POST, 'descriptions', array()),
					'parent_id' => Arr::get($_POST, 'parent_id', 0),
					'date' => Arr::get($_POST, 'date', ''),					
                    'alias' => Arr::get($_POST, 'alias', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );
				
                $new_content_id = $services_obj->add($add_data);
				
                if ($new_content_id) {
					
					/********************* Операции с модулями ********************/
					Controller_Admin_Categories::set_fields($new_content_id, $_POST, 'services');
					Controller_Admin_Files::set_fields($new_content_id, $_POST, 'services');
					Controller_Admin_Seo::set_fields($new_content_id, $_POST, 'services');
					Controller_Admin_Tags::set_fields($new_content_id, $_POST, 1, 'services');
					Controller_Admin_Related::set_fields($new_content_id, $_POST, 'services');
					/***********************************************************/
					
                    Request::initial()->redirect('admin/services'.$this->parameters);
                }
            }
            $errors = $validation->errors('validation');
        }
		
		$parent_services = $services_obj->get_tree(0);
		
		/********************* Операции с модулями ********************/
		//$data['categories_form1'] = Controller_Admin_Categories::get_fields(array(), 'services', 1);
		$data['categories_form2'] = Controller_Admin_Categories::get_fields(array(), 'services', 2);
        $data['files_form'] = Controller_Admin_Files::get_fields(array(), 'services');
		$data['seo_form'] = Controller_Admin_Seo::get_fields(array(), 'services');	
		$data['tags_form'] = Controller_Admin_Tags::get_fields(array(), 1, 'services');
		$data['address_form'] = Controller_Admin_Related::get_fields(array(), 'services');
		/***********************************************************/		
		
        $this->template->content = View::factory('admin/services-add', $data)
                ->bind('errors', $errors)
				->bind('parent_services', $parent_services)
                ->bind('post', $validation);
    }
	
    public function action_edit() {
	
        $Id = $this->request->param('id');
        $services_obj = new Model_Services();
		
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
        if (isset($_POST['descriptions'][1]['title'])) {
		
            $v_data = array('descriptions' => $_POST['descriptions'], 'title' => $_POST['descriptions'][1]['title'], 'alias' => $_POST['alias']);
            $validation = Validation::factory($v_data);
            $validation->rule('title', 'not_empty');
            $validation->rule('title', 'min_length', array(':value', '2'));
            $validation->rule('title', 'max_length', array(':value', '128'));
            $validation->rule('alias', 'not_empty');
            $validation->rule('alias', 'alpha_dash');
            $validation->rule('alias', 'max_length', array(':value', '128'));
            $validation->labels(array('title' => $this->lang['text_name'], 'alias' => $this->lang['text_alias']));
			
            if ($validation->check()) {
                
                $edit_data = array(
                    'descriptions' => Arr::get($_POST, 'descriptions', array()), 
					'parent_id' => Arr::get($_POST, 'parent_id', 0),
					'date' => Arr::get($_POST, 'date', ''),						
                    'alias' => Arr::get($_POST, 'alias', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );
               
                $result = $services_obj->edit($Id, $edit_data);
				
                if ($result) {
				
					/********************* Операции с модулями ********************/
					Controller_Admin_Categories::set_fields($Id, $_POST, 'services');
					Controller_Admin_Files::set_fields($Id, $_POST, 'services');
					Controller_Admin_Seo::set_fields($Id, $_POST, 'services');
					Controller_Admin_Tags::set_fields($Id, $_POST, 1, 'services');
					Controller_Admin_Related::set_fields($Id, $_POST, 'services');
					/***********************************************************/
					
                    Request::initial()->redirect('admin/services'.$this->parameters);
                }
            }
			
            $errors = $validation->errors('validation');
        }
		
        $data['content'] = $services_obj->get_content($Id);
		$parent_services = $services_obj->get_tree(0);
		
		/********************* Операции с модулями ********************/	
		//$data['categories_form1'] = Controller_Admin_Categories::get_fields($data['content'], 'services', 1);
		$data['categories_form2'] = Controller_Admin_Categories::get_fields($data['content'], 'services', 2);
        $data['files_form'] = Controller_Admin_Files::get_fields($data['content'], 'services');
		$data['seo_form'] = Controller_Admin_Seo::get_fields($data['content'], 'services');
		$data['tags_form'] = Controller_Admin_Tags::get_fields($data['content'], 1, 'services');
		$data['address_form'] = Controller_Admin_Related::get_fields($data['content'], 'services');
		/***********************************************************/
        $this->template->content = View::factory('admin/services-edit', $data)
                ->bind('errors', $errors)
				->bind('parent_services', $parent_services)
                ->bind('post', $validation);
    }
	
    public function action_delete() {
	
        $Id = $this->request->param('id');
		
        $services_obj = new Model_Services();
		$categories_obj = new Model_Categories();
		$file_obj = new Model_File();
		$seo_obj = new Model_Seo();
		$tags_obj = new Model_Tags();
		$related_obj = new Model_Related();
		
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
        if (isset($_POST['delete'])) {
            $result = $services_obj->delete($Id);
			
			/********************* Операции с модулями ********************/
			$categories_obj->delete_category_by_content($Id, 'services');
			$seo_obj->delete_by_content($Id, 'services');
			$file_obj->delete_files_by_content($Id, 'services');
			$tags_obj->delete($Id, 'services');
			$related_obj->delete($Id);
			/***********************************************************/
		
            if ($result) {
                Request::initial()->redirect('admin/services'.$this->parameters);
            }
        }
        $data['content'] = $services_obj->get_content($Id);
        $this->template->content = View::factory('admin/services-delete', $data);
    }
	
    public function unique_url($url) {
        return !DB::select(array(DB::expr('COUNT(alias)'), 'total'))
                        ->from('services')
                        ->where('alias', '=', $url)
                        ->execute()
                        ->get('total');
    }
	
	public static function set_fields($content_id = 0, $post = array(), $module = 'products') {
	
		$services_obj = new Model_Services();
		$services = Arr::get($post, 'serviceId1', array());
		
		$services_obj->delete_by_content($content_id, $module);
        if (count($services) > 0) {
            foreach ($services as $cat_id) {
                $services_obj->add_by_content($content_id, $cat_id, $module);
            }
        }		
		return true;
    }
	
	public static function get_fields($data = array(), $module = 'products', $wrapper = true, $multiple = 'multiple') {
	
		$services_obj = new Model_Services();
		$select_services = $services_obj->get_parent_and_children(0);
		
		if($data AND !empty($data)){
			$parent = Model::factory($module)->get_service_parent($data['id']);
		} else {
			
			$parent = 0;
		}	
	
		return View::factory('admin/fields_services')
				->bind('select_services', $select_services)
				->bind('multiple', $multiple)
				->bind('wrapper', $wrapper)
                ->bind('parent', $parent);
    }
}