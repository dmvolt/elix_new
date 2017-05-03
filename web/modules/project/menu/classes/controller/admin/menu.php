<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana user guide and api browser.
 *
 * @package    Kohana/Userguide
 * @category   Controllers
 * @author     Kohana Team
 */
class Controller_Admin_Menu extends Controller_Admin_Template {

    public function action_index() {
	
        $menu_obj = new Model_Menu();
        $menu_group_menu = Kohana::$config->load('menu.group_menu');

        foreach ($menu_group_menu as $group_menu) {
            $data['group_menu'][] = array(
                'isgroup' => $menu_obj->isDictionary($group_menu['dictionary_id']),
                'name' => $group_menu['name'],
                'dictionary_id' => $group_menu['dictionary_id'],
            );
        }
        if (isset($_POST['descriptions'][1]['title'])) {
            $v_data = array(
				'name' => $_POST['descriptions'][1]['title'], 
				'url' => $_POST['url'], 
				'descriptions' => $_POST['descriptions']
			);
            $validation = Validation::factory($v_data);
            $validation->rule('name', 'not_empty');
            $validation->rule('name', 'min_length', array(':value', '2'));
            $validation->rule('name', 'max_length', array(':value', '128'));
            $validation->rule('url', 'not_empty');
            /* $validation->rule('url', 'alpha_dash'); */
            $validation->rule('url', 'max_length', array(':value', '128'));

            $validation->labels(array('name' => $this->lang['text_name'], 'url' => $this->lang['text_alias']));

            if ($validation->check()) {
				$parent_id = Arr::get($_POST, 'parent_id', '');
				
				$add_data = array(
					'content_id' => 0, 
					'module' => 0, 
					'descriptions' => Arr::get($_POST, 'descriptions', array()), 
					'url' => Arr::get($_POST, 'url', ''), 
					'weight' => Arr::get($_POST, 'weight', 0), 
					'dictionary_id' => Arr::get($_POST, 'dictionary_id', 0),
				);
				
                $res = $menu_obj->add($parent_id, $add_data);

                if ($res) {
                    Request::initial()->redirect('admin/menu');
                } else {
                    Request::initial()->redirect('admin/menu');
                }
            }
            $errors = $validation->errors('validation');
        }
        $this->template->content = View::factory('admin/menu', $data)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }

    public function action_edit() {
	
        $menuId = $this->request->param('id');
        $menu_obj = new Model_Menu();
        $data['group_menu'] = Kohana::$config->load('menu.group_menu');

        if (isset($_POST['descriptions'][1]['title'])) {
            $v_data = array('name' => $_POST['descriptions'][1]['title'], 'url' => $_POST['url'], 'descriptions' => $_POST['descriptions']);
            $validation = Validation::factory($v_data);
            $validation->rule('name', 'not_empty');
            $validation->rule('name', 'min_length', array(':value', '2'));
            $validation->rule('name', 'max_length', array(':value', '128'));
            $validation->rule('url', 'not_empty');
            /* $validation->rule('url', 'alpha_dash'); */
            $validation->rule('url', 'max_length', array(':value', '128'));

            $validation->labels(array('name' => $this->lang['text_name'], 'url' => $this->lang['text_alias']));

            if ($validation->check()) {
			
				$dictionary_id = Arr::get($_POST, 'dictionary_id', 0);
				$parent_id = Arr::get($_POST, 'parent_id', '');
				
                $children = $menu_obj->getChildren($menuId);

                if ($children) {
                    foreach ($children as $child) {
                        $menu_obj->editChild($child['id'], $dictionary_id);
                    }
                }
				
				$edit_data = array(
					'descriptions' => Arr::get($_POST, 'descriptions', array()), 
					'url' => Arr::get($_POST, 'url', ''), 
					'weight' => Arr::get($_POST, 'weight', 0), 
					'dictionary_id' => Arr::get($_POST, 'dictionary_id', 0), 
					'status' => Arr::get($_POST, 'status', 0),
				);

                $res = $menu_obj->edit($menuId, $parent_id, $edit_data);

                if ($res) {
                    Request::initial()->redirect('admin/menu');
                } else {
                    Request::initial()->redirect('admin/menu');
                }
            }
            $errors = $validation->errors('validation');
        }

        $data['menu'] = $menu_obj->getNode($menuId);  // Извлекаем поля категории
        $data['parent'] = $menu_obj->getParent($menuId); // Извлекаем родительскую категорию по id дочерней
        $data['dictionary'] = $menu_obj->getDictionary($menuId); // Извлекаем id группы по id категории

        $this->template->content = View::factory('admin/menu-edit', $data)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }

    public function action_delete() {
	
        $menuId = $this->request->param('id');
        $menu_obj = new Model_Menu();

        $children = $menu_obj->getChildren($menuId);
        $all_children = $menu_obj->getTree($menuId);

        if (isset($_POST['delete'])) {
            if (!$children) {
                $res = $menu_obj->delete($menuId);

                if ($res) {
                    $data['mess'] = 'Элемент меню успешно удален';
                    $this->template->content = View::factory('admin/menu', $data);
                    Request::initial()->redirect('admin/menu');
                } else {
                    $data['mess'] = 'Ошибка удаления элемента меню';
                    $this->template->content = View::factory('admin/menu', $data);
                    Request::initial()->redirect('admin/menu');
                }
            } else {

                if ($_POST['remove'] == 1) {

                    $parent_id = $menu_obj->getParent($menuId); // Извлекаем родительскую категорию по id дочерней

                    foreach ($children as $child) {
                        $menu_obj->editParent($child['id'], $parent_id);
                    }

                    $res = $menu_obj->delete($menuId);

                    if ($res) {
                        $data['mess'] = 'Элемент меню успешно удален, вложенные элементы были переопределены на уровень выше';
                        $this->template->content = View::factory('admin/menu', $data);
                        Request::initial()->redirect('admin/menu');
                    } else {
                        $data['mess'] = 'Ошибка удаления элемента меню, или ошибка переопределения вложенных элементов';
                        $this->template->content = View::factory('admin/menu', $data);
                        Request::initial()->redirect('admin/menu');
                    }
                } else {

                    foreach ($all_children as $child) {
                        $res = $menu_obj->delete($child['id']);
                    }

                    $res = $menu_obj->delete($menuId);

                    if ($res) {
                        $data['mess'] = 'Элемент меню и вложеные элементы успешно удалены';
                        $this->template->content = View::factory('admin/menu', $data);
                        Request::initial()->redirect('admin/menu');
                    } else {
                        $data['mess'] = 'Ошибка удаления элемента меню, или ошибка удаления вложенных элементов';
                        $this->template->content = View::factory('admin/menu', $data);
                        Request::initial()->redirect('admin/menu');
                    }
                }
            }
        } else {

            if ($all_children) {
                $data['children'] = $all_children;
                $data['menu'] = $menu_obj->getNode($menuId);  // Извлекаем поля категории
            } else {
                $data['menu'] = $menu_obj->getNode($menuId);  // Извлекаем поля категории
            }
        }
        $this->template->content = View::factory('admin/menu-delete', $data);
    }

    public function unique_url($url) {
        return !DB::select(array(DB::expr('COUNT(url)'), 'total'))
                        ->from('menu')
                        ->where('url', '=', $url)
                        ->execute()
                        ->get('total');
    }

}

// End Controller_Admin_News
