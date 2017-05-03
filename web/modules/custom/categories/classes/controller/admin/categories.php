<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Categories extends Controller_Admin_Template {

    public function action_index() {
	
        $categories_obj = new Model_Categories();
        $menu_group_cat = Kohana::$config->load('menu.group_cat');
		
        foreach ($menu_group_cat as $group_cat) {
            $data['group_cat'][] = array(
                'isgroup' => $categories_obj->isDictionary($group_cat['dictionary_id']),
                'name' => $group_cat['name'],
                'dictionary_id' => $group_cat['dictionary_id'],
            );
        }

        if (isset($_POST['descriptions'][1]['title'])) {
            $v_data = array('descriptions' => $_POST['descriptions'], 'name' => $_POST['descriptions'][1]['title'], 'alias' => $_POST['alias']);
            $validation = Validation::factory($v_data);
            $validation->rule('name', 'not_empty');
            $validation->rule('name', 'min_length', array(':value', '2'));
            $validation->rule('name', 'max_length', array(':value', '128'));
            $validation->rule('alias', 'not_empty');
            $validation->rule('alias', 'alpha_dash');
            $validation->rule('alias', 'max_length', array(':value', '128'));
            $validation->rule('alias', array($this, 'unique_url'));
            $validation->labels(array('name' => $this->lang['text_name'], 'alias' => $this->lang['text_alias']));

            if ($validation->check()) {
				$parent_id = Arr::get($_POST, 'parent_id', '');				
				$add_data = array(
					'descriptions' => Arr::get($_POST, 'descriptions', array()),			
					'alias' => Arr::get($_POST, 'alias', ''),
					'weight' => Arr::get($_POST, 'weight', 0),
					'dictionary_id' => Arr::get($_POST, 'dictionary_id', 0),
				);
				
                $Id = $categories_obj->catInsert($parent_id, $add_data);

                if ($Id) {
                    Request::initial()->redirect('admin/categories');
                } else {
                    Request::initial()->redirect('admin/categories');
                }
            }
            $errors = $validation->errors('validation');
        }
        $this->template->content = View::factory('admin/categories', $data)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }

    public function action_edit() {
	
        $catId = $this->request->param('id');
        $categories_obj = new Model_Categories();
        $data['group_cat'] = Kohana::$config->load('menu.group_cat');

        if (isset($_POST['descriptions'][1]['title'])) {
            $v_data = array('name' => $_POST['descriptions'][1]['title'], 'alias' => $_POST['alias']);
            $validation = Validation::factory($v_data);
            $validation->rule('name', 'not_empty');
            $validation->rule('name', 'min_length', array(':value', '2'));
            $validation->rule('name', 'max_length', array(':value', '128'));
            $validation->rule('alias', 'not_empty');
            $validation->rule('alias', 'alpha_dash');
            $validation->rule('alias', 'max_length', array(':value', '128'));
            $validation->labels(array('name' => $this->lang['text_name'], 'alias' => $this->lang['text_alias']));

            if ($validation->check()) {
				$parent_id = Arr::get($_POST, 'parent_id', '');
				$dictionary_id = Arr::get($_POST, 'dictionary_id', 0);
				
				$edit_data = array(
					'descriptions' => Arr::get($_POST, 'descriptions', array()),			
					'alias' => Arr::get($_POST, 'alias', ''),
					'weight' => Arr::get($_POST, 'weight', 0),
					'dictionary_id' => Arr::get($_POST, 'dictionary_id', 0),
				);
				
                $children = $categories_obj->getChildren($catId);

                if ($children) {
                    foreach ($children as $child) {
                        $categories_obj->catEditChild($child['id'], $dictionary_id);
                    }
                }
				
                $res = $categories_obj->catEdit($catId, $parent_id, $edit_data);

                if ($res) {
					/********************* Операции с модулями ********************/
					Controller_Admin_Files::set_fields($catId, $_POST, 'categories');
					Controller_Admin_Seo::set_fields($catId, $_POST, 'categories');
					Controller_Admin_Address::set_fields($catId, $_POST, 'categories');
					/***********************************************************/	
                    Request::initial()->redirect('admin/categories');
                } else {
                    Request::initial()->redirect('admin/categories');
                }
            }
            $errors = $validation->errors('validation');
        }

        $data['cat'] = $categories_obj->getNode($catId);  // Извлекаем поля категории
        $data['parent'] = $categories_obj->getParent($catId); // Извлекаем родительскую категорию по id дочерней
        $data['dictionary'] = $categories_obj->getDictionary($catId); // Извлекаем id группы по id категории
		
		/********************* Операции с модулями ********************/
        $data['files_form'] = Controller_Admin_Files::get_fields($data['cat'], 'categories');
		$data['seo_form'] = Controller_Admin_Seo::get_fields($data['cat'], 'categories');
		$data['address_form'] = Controller_Admin_Address::get_fields($data['cat'], 'categories');
		/***********************************************************/	

        $this->template->content = View::factory('admin/categories-edit', $data)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }

    public function action_delete() {
	
        $catId = $this->request->param('id');
        $categories_obj = new Model_Categories();
		$file_obj = new Model_File();
		$seo_obj = new Model_Seo();
		$address_obj = new Model_Address();

        $children = $categories_obj->getChildren($catId);      
        $all_children = $categories_obj->getTree($catId);

        if (isset($_POST['delete'])) {
            if (!$children) {
                $res = $categories_obj->catDelete($catId);
                
                if ($res) {
					/********************* Операции с модулями ********************/
					$file_obj->delete_files_by_content($catId, 'categories');
					$seo_obj->delete_by_content($catId, 'categories');
					$address_obj->delete_by_content($catId, 'categories');
					/***********************************************************/
                    $data['mess'] = 'Категория успешно удалена';
                    $this->template->content = View::factory('admin/categories', $data);
                    Request::initial()->redirect('admin/categories');
                } else {
                    $data['mess'] = 'Ошибка удаления категории';
                    $this->template->content = View::factory('admin/categories', $data);
                    Request::initial()->redirect('admin/categories');
                }
            } else {

                if ($_POST['remove'] == 1) {

                    $parent_id = $categories_obj->getParent($catId); // Извлекаем родительскую категорию по id дочерней
                    
                    foreach ($children as $child) {
                        $categories_obj->catEditParent($child['id'], $parent_id);
                        
						/********************* Операции с модулями ********************/
						$file_obj->delete_files_by_content($child['id'], 'categories');
						$seo_obj->delete_by_content($child['id'], 'categories');
						$address_obj->delete_by_content($child['id'], 'categories');
						/***********************************************************/
                    }

                    $res = $categories_obj->catDelete($catId);

                    if ($res) {
						/********************* Операции с модулями ********************/
						$file_obj->delete_files_by_content($catId, 'categories');
						$seo_obj->delete_by_content($catId, 'categories');
						$address_obj->delete_by_content($catId, 'categories');
						/***********************************************************/
                        $data['mess'] = 'Категория успешно удалена, вложенные категории были переопределены на уровень выше';
                        $this->template->content = View::factory('admin/categories', $data);
                        Request::initial()->redirect('admin/categories');
                    } else {
                        $data['mess'] = 'Ошибка удаления категории, или ошибка переопределения вложенных категорий';
                        $this->template->content = View::factory('admin/categories', $data);
                        Request::initial()->redirect('admin/categories');
                    }
                } else {

                    foreach ($all_children as $child) {
                        $res = $categories_obj->catDelete($child['id']);
                 
						/********************* Операции с модулями ********************/
						$file_obj->delete_files_by_content($child['id'], 'categories');
						$seo_obj->delete_by_content($child['id'], 'categories');
						$address_obj->delete_by_content($child['id'], 'categories');
						/***********************************************************/
                    }

                    $res = $categories_obj->catDelete($catId);

                    if ($res) {
						/********************* Операции с модулями ********************/
						$file_obj->delete_files_by_content($catId, 'categories');
						$seo_obj->delete_by_content($catId, 'categories');
						$address_obj->delete_by_content($catId, 'categories');
						/***********************************************************/
                        $data['mess'] = 'Категория и вложеные категории успешно удалены';
                        $this->template->content = View::factory('admin/categories', $data);
                        Request::initial()->redirect('admin/categories');
                    } else {
                        $data['mess'] = 'Ошибка удаления категории, или ошибка или ошибка удаления вложенных категорий';
                        $this->template->content = View::factory('admin/categories', $data);
                        Request::initial()->redirect('admin/categories');
                    }
                }
            }
        } else {
            if ($all_children) {
                $data['children'] = $all_children;
                $data['category'] = $categories_obj->getNode($catId);  // Извлекаем поля категории
            } else {
                $data['category'] = $categories_obj->getNode($catId);  // Извлекаем поля категории
            }
        }
        $this->template->content = View::factory('admin/categories-delete', $data);
    }

    public function unique_url($url) {
        return !DB::select(array(DB::expr('COUNT(alias)'), 'total'))
                        ->from('categories')
                        ->where('alias', '=', $url)
                        ->execute()
                        ->get('total');
    }
	
	public static function set_fields($content_id = 0, $post = array(), $module = 'products') {
	
		$categories_obj = new Model_Categories();
		$categories = Arr::get($post, 'categoryId1', array());
		
		$categories_obj->delete_category_by_content($content_id, $module);

        if (count($categories) > 0) {
            foreach ($categories as $cat_id) {
			
				$parent_id = 0; // По умолчанию ID родителя обнуляем
				
                $categories_obj->add_category_by_content($content_id, $cat_id, $module);
				
				// Присваиваем материалу в том числе родительскую категорию, если она существует
				$parent_id = $categories_obj->getParent($cat_id);
				if($parent_id){
					$categories_obj->add_category_by_content($content_id, $parent_id, $module);
				}
            }
        }		
		return true;
    }
	
	public static function get_fields($data = array(), $module = 'products', $dictionary_id = 1, $wrapper = true, $multiple = 'multiple') {
	
		$categories_obj = new Model_Categories();
		
		$menu_group_cat = Kohana::$config->load('menu.group_cat');
		
		if($data AND !empty($data)){
			$parent = Model::factory($module)->get_parent($data['id']);
		} else {
			if(Arr::get($_GET, 'cat', null)){
				$parent = Arr::get($_GET, 'cat', null);
			} else {
				$parent = 0;
			}
		}

        foreach ($menu_group_cat as $group_cat) {
            $data['group_cat'][] = array(
                'isgroup' => $categories_obj->isDictionary($group_cat['dictionary_id']),
                'name' => $group_cat['name'],
                'dictionary_id' => $group_cat['dictionary_id'],
            );
        }		
	
		return View::factory('admin/fields_categories')
				->bind('dictionary_id', $dictionary_id)
				->bind('group_cat', $menu_group_cat)
				->bind('multiple', $multiple)
				->bind('wrapper', $wrapper)
                ->bind('parent', $parent);
    }
}