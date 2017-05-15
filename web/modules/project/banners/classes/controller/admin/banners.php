<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana user guide and api browser.
 *
 * @package    Kohana/Userguide
 * @category   Controllers
 * @author     Kohana Team
 */
class Controller_Admin_Banners extends Controller_Admin_Template {

    public function action_index() {
	
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
		$banners_obj = new Model_Banners();
		$categories_obj = new Model_Categories();
		$services_obj = new Model_Services();
		
		$catid1 = Arr::get($_GET, 'cat1', null); // Получение параметра cat1 (Город) из адресной строки
		$catid2 = Arr::get($_GET, 'cat2', null); // Получение параметра cat2 (Раздел) из адресной строки
		$typeid = Arr::get($_GET, 'type', null); // Получение параметра type (Тип баннера) из адресной строки
		
		$cat_name = '';
		$filter_query = '';
		$inner_join = '';
		$parameters = '';
		$i = 0;
		
        $content = View::factory('admin/banners')
				->bind('parameters', $parameters)
                ->bind('contents', $contents)
				->bind('cat_name', $cat_name)
                ->bind('parent1', $catid1)
				->bind('parent2', $catid2)
				->bind('parent3', $typeid)
				->bind('banner_types', $banner_types)
                ->bind('select_services', $select_services)
                ->bind('group_cat', $group_cat);
				
		$select_services = $services_obj->get_parent_and_children(0);
				
		$group_cat = Kohana::$config->load('menu.group_cat');
		$banner_types = Kohana::$config->load('banner.types');
		
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
		
		if($typeid != null){
			$filter_query .= ' AND b.type_id = '.$typeid.' ';		
			
			$parameters .= ($i)?'&type='.$typeid:'?type='.$typeid;
			$i++;
			
			$cat_name .= 'Баннеры - '.$banner_types[$typeid];
		}
		
		if($catid1 AND !empty($catid1)){
			$filter_query .= ' AND (cc1.category_id = '.$catid1.' AND cc1.module = "banners") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = b.id ';
			
			$parameters .= ($i)?'&cat1='.$catid1:'?cat1='.$catid1;
			$i++;
			
			$cat_name .= 'Баннеры - '.$cats[2][$catid1]['name'];
		}
		
		if($catid2 AND !empty($catid2)){
			$filter_query .= ' AND (cs.service_id = '.$catid2.' AND cs.module = "banners") ';		
			$inner_join .= ' INNER JOIN `contents_services` cs ON cs.content_id = b.id ';

			$parameters .= ($i)?'&cat2='.$catid2:'?cat2='.$catid2;
			$i++;
		}
		
		$contents = $banners_obj->get_all(1, 0, 100, 'b.id', $inner_join, $filter_query);

        $this->template->content = $content;
    }

    public function action_add() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
        
		$banners_obj = new Model_Banners();
		$banner_types = Kohana::$config->load('banner.types');

        if (isset($_POST['title'])) {
            $add_data = array(
                'title' => Arr::get($_POST, 'title', ''),
				'type_id' => Arr::get($_POST, 'type_id', 0),
                'display_pages' => Arr::get($_POST, 'display_pages', ''),
                'display_all' => Arr::get($_POST, 'display_all', 1),
                'status' => Arr::get($_POST, 'status', 0),
            );
           
            $new_banners_id = $banners_obj->add($add_data);

            if ($new_banners_id) {
				Controller_Admin_Files::set_fields($new_banners_id, $_POST, 'banners');
				Controller_Admin_Categories::set_fields($new_banners_id, $_POST, 'banners');
				Controller_Admin_Services::set_fields($new_banners_id, $_POST, 'banners');
                Request::initial()->redirect('admin/banners'.$this->parameters);
            }
        }
        $data['files_form'] = Controller_Admin_Files::get_fields(array(), 'banners');
		$data['categories_form1'] = Controller_Admin_Services::get_fields(array(), 'banners', false, 'multiple');
		$data['categories_form2'] = Controller_Admin_Categories::get_fields(array(), 'banners', 2, false, 'multiple');
        $this->template->content = View::factory('admin/banners-add', $data)->bind('banner_types', $banner_types);
    }

    public function action_edit() {
        $Id = $this->request->param('id');
        $banners_obj = new Model_Banners();
      
        $data['content'] = $banners_obj->get_content($Id);
		$banner_types = Kohana::$config->load('banner.types');

        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        if (isset($_POST['title'])) {
            $edit_data = array(
                'title' => Arr::get($_POST, 'title', ''),
				'type_id' => Arr::get($_POST, 'type_id', 0),
                'display_pages' => Arr::get($_POST, 'display_pages', ''),
                'display_all' => Arr::get($_POST, 'display_all', 1),
                'status' => Arr::get($_POST, 'status', 0),
            );

            $result = $banners_obj->edit($Id, $edit_data);

            if ($result) {
				Controller_Admin_Files::set_fields($Id, $_POST, 'banners');
				Controller_Admin_Categories::set_fields($Id, $_POST, 'banners');
				Controller_Admin_Services::set_fields($Id, $_POST, 'banners');
                Request::initial()->redirect('admin/banners'.$this->parameters);
            }
        }
        $data['files_form'] = Controller_Admin_Files::get_fields($data['content'], 'banners');
		$data['categories_form1'] = Controller_Admin_Services::get_fields($data['content'], 'banners', false, 'multiple');
		$data['categories_form2'] = Controller_Admin_Categories::get_fields($data['content'], 'banners', 2, false, 'multiple');
        $this->template->content = View::factory('admin/banners-edit', $data)->bind('banner_types', $banner_types);
    }

    public function action_delete() {
        $Id = $this->request->param('id');
        $banners_obj = new Model_Banners();
		$file_obj = new Model_File();
		$categories_obj = new Model_Categories();
		$services_obj = new Model_Services();

        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        if (isset($_POST['delete'])) {
            $result = $banners_obj->delete($Id);
			$file_obj->delete_files_by_content($Id, 'banners');
			$services_obj->delete_by_content($Id, 'banners');
			$categories_obj->delete_category_by_content($Id, 'banners');
            if ($result) {
                Request::initial()->redirect('admin/banners'.$this->parameters);
            }
        }

        $data['content'] = $banners_obj->get_content($Id);
        $this->template->content = View::factory('admin/banners-delete', $data);
    }
}
// End Controller_Admin_Banners