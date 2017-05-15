<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana user guide and api browser.
 *
 * @package    Kohana/Userguide
 * @category   Controllers
 * @author     Kohana Team
 */
class Controller_Admin_Photos extends Controller_Admin_Template {

    public function action_index() {
	
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
		$photos_obj = new Model_Photos();
		$categories_obj = new Model_Categories();
		$services_obj = new Model_Services();
		
		$catid1 = Arr::get($_GET, 'cat1', null); // Получение параметра cat1 (Город) из адресной строки
		$catid2 = Arr::get($_GET, 'cat2', null); // Получение параметра cat2 (Раздел) из адресной строки
		
		$cat_name = '';
		$filter_query = '';
		$inner_join = '';
		$parameters = '';
		$i = 0;
		
        $content = View::factory('admin/photos')
				->bind('parameters', $parameters)
                ->bind('contents', $contents)
				->bind('pagination', $pagination)
                ->bind('pagination2', $pagination2)
				->bind('cat_name', $cat_name)
                ->bind('parent1', $catid1)
				->bind('parent2', $catid2)
                ->bind('select_services', $select_services)
                ->bind('group_cat', $group_cat);
				
		$select_services = $services_obj->get_parent_and_children(0);
				
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
			$filter_query .= ' AND (cc1.category_id = '.$catid1.' AND cc1.module = "photos") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = p.id ';
			
			$parameters .= ($i)?'&cat1='.$catid1:'?cat1='.$catid1;
			$i++;
			
			$cat_name .= 'Фотогалерея - '.$cats[2][$catid1]['name'];
		}
		
		if($catid2 AND !empty($catid2)){
			$filter_query .= ' AND (cs.service_id = '.$catid2.' AND cs.module = "photos") ';		
			$inner_join .= ' INNER JOIN `contents_services` cs ON cs.content_id = p.id ';

			$parameters .= ($i)?'&cat2='.$catid2:'?cat2='.$catid2;
			$i++;
		}

		$contents = $photos_obj->get_all(1, 0, 1000, 'p.weight', $inner_join, $filter_query, $this->lang_id);

        $this->template->content = $content;
    }

    public function action_add() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
		$photos_obj = new Model_Photos();

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
                    'alias' => Arr::get($_POST, 'alias', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );

                $new_content_id = $photos_obj->add($add_data);

                if ($new_content_id) {
					
					/********************* Операции с модулями ********************/
					Controller_Admin_Categories::set_fields($new_content_id, $_POST, 'photos');
					Controller_Admin_Services::set_fields($new_content_id, $_POST, 'photos');
					Controller_Admin_Files::set_fields($new_content_id, $_POST, 'photos');
					Controller_Admin_Seo::set_fields($new_content_id, $_POST, 'photos');
					/***********************************************************/
					
                    Request::initial()->redirect('admin/photos');
                }
            }
            $errors = $validation->errors('validation');
        }
		
		/********************* Операции с модулями ********************/
		$data['categories_form1'] = Controller_Admin_Services::get_fields(array(), 'photos');
		$data['categories_form2'] = Controller_Admin_Categories::get_fields(array(), 'photos', 2);
        $data['files_form'] = Controller_Admin_Files::get_fields(array(), 'photos');
		$data['seo_form'] = Controller_Admin_Seo::get_fields(array(), 'photos');		
		/***********************************************************/		

        $this->template->content = View::factory('admin/photos-add', $data)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }

    public function action_edit() {
        $Id = $this->request->param('id');

        $photos_obj = new Model_Photos();

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
                    'alias' => Arr::get($_POST, 'alias', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );
               
                $result = $photos_obj->edit($Id, $edit_data);

                if ($result) {
				
					/********************* Операции с модулями ********************/
					Controller_Admin_Categories::set_fields($Id, $_POST, 'photos');
					Controller_Admin_Services::set_fields($Id, $_POST, 'photos');
					Controller_Admin_Files::set_fields($Id, $_POST, 'photos');
					Controller_Admin_Seo::set_fields($Id, $_POST, 'photos');
					/***********************************************************/
					
                    Request::initial()->redirect('admin/photos');
                }
            }
            $errors = $validation->errors('validation');
        }
        $data['content'] = $photos_obj->get_content($Id);
		
		/********************* Операции с модулями ********************/
		$data['categories_form1'] = Controller_Admin_Services::get_fields($data['content'], 'photos');
		$data['categories_form2'] = Controller_Admin_Categories::get_fields($data['content'], 'photos', 2);
        $data['files_form'] = Controller_Admin_Files::get_fields($data['content'], 'photos');
		$data['seo_form'] = Controller_Admin_Seo::get_fields($data['content'], 'photos');
		/***********************************************************/

        $this->template->content = View::factory('admin/photos-edit', $data)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }

    public function action_delete() {
        $Id = $this->request->param('id');
        $photos_obj = new Model_Photos();
		$file_obj = new Model_File();
		$seo_obj = new Model_Seo();
		$categories_obj = new Model_Categories();
		$services_obj = new Model_Services();

        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        if (isset($_POST['delete'])) {
            $result = $photos_obj->delete($Id);
			
			/********************* Операции с модулями ********************/
			$categories_obj->delete_category_by_content($Id, 'photos');
			$services_obj->delete_by_content($Id, 'photos');
			$seo_obj->delete_by_content($Id, 'photos');
			$file_obj->delete_files_by_content($Id, 'photos');
			/***********************************************************/
		
            if ($result) {
                Request::initial()->redirect('admin/photos');
            }
        }
        $data['content'] = $photos_obj->get_content($Id);
        $this->template->content = View::factory('admin/photos-delete', $data);
    }

    public function unique_url($url) {
        return !DB::select(array(DB::expr('COUNT(alias)'), 'total'))
                        ->from('photos')
                        ->where('alias', '=', $url)
                        ->execute()
                        ->get('total');
    }
}
// End Controller_Admin_News
