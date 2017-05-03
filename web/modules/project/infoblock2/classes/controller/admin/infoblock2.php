<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana user guide and api browser.
 *
 * @package    Kohana/Userguide
 * @category   Controllers
 * @author     Kohana Team
 */
class Controller_Admin_Infoblock2 extends Controller_Admin_Template {

    public function action_index() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
		$infoblock2_obj = new Model_Infoblock2();
		$categories_obj = new Model_Categories();
		
		$catid1 = Arr::get($_GET, 'cat1', null); // Получение параметра cat1 (Город) из адресной строки
		$catid2 = Arr::get($_GET, 'cat2', null); // Получение параметра cat2 (Раздел) из адресной строки
		
		$cat_name = '';
		$filter_query = '';
		$inner_join = '';
		$parameters = '';
		$i = 0;
		
        $content = View::factory('admin/infoblock2')
				->bind('layers', $layers)
                ->bind('parameters', $parameters)
                ->bind('contents', $contents)
                ->bind('cat_name', $cat_name)
                ->bind('parent1', $catid1)
				->bind('parent2', $catid2)
                ->bind('group_cat', $group_cat);
				
		$group_cat = Kohana::$config->load('menu.group_cat');
		
		$layers = Kohana::$config->load('layers');
		
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
			$filter_query .= ' AND (cc1.category_id = '.$catid1.' AND cc1.module = "infoblock2") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = i2.id ';
			
			$parameters .= ($i)?'&cat1='.$catid1:'?cat1='.$catid1;
			$i++;
			
			$cat_name .= 'Позиционированные блоки - '.$cats[2][$catid1]['name'];
		}
		
		if($catid2 AND !empty($catid2)){
			$filter_query .= ' AND (cc2.category_id = '.$catid2.' AND cc2.module = "infoblock2") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc2 ON cc2.content_id = i2.id ';
			
			$cat_name .= ($i)?', '.$cats[1][$catid2]['name']:'Позиционированные блоки - '.$cats[1][$catid2]['name'];
			
			$parameters .= ($i)?'&cat2='.$catid2:'?cat2='.$catid2;
			$i++;
		}
		
		$contents = $infoblock2_obj->get_all(1, 0, 100, $inner_join, $filter_query);
		
        $this->template->content = $content;
    }

    public function action_add() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
		$infoblock2_obj = new Model_Infoblock2();

        if (isset($_POST['title'])) {
            $validation = Validation::factory($_POST);
            $validation->rule('title', 'not_empty');
            $validation->rule('title', 'min_length', array(':value', '2'));
            $validation->rule('title', 'max_length', array(':value', '128'));

            $validation->labels(array('title' => $this->lang['text_name']));

            if ($validation->check()) {
                $add_data = array(
                    'title' => Arr::get($_POST, 'title',''),
					'info' => Arr::get($_POST, 'info', ''),
                    'link1' => Arr::get($_POST, 'link1', ''),
					'link2' => Arr::get($_POST, 'link2', ''),
					'pos_x' => Arr::get($_POST, 'pos_x', 0),
					'pos_y' => Arr::get($_POST, 'pos_y', 0),
					'type' => Arr::get($_POST, 'type', 1),
                    'status' => Arr::get($_POST, 'status', 0),
                );

                $new_content_id = $infoblock2_obj->add($add_data);

                if ($new_content_id) {
					
					/********************* Операции с модулями ********************/
					Controller_Admin_Categories::set_fields($new_content_id, $_POST, 'infoblock2');
					/***********************************************************/
					
                    Request::initial()->redirect('admin/infoblock2'.$this->parameters);
                }
            }
            $errors = $validation->errors('validation');
        }
		
		/********************* Операции с модулями ********************/
		$data['categories_form2'] = Controller_Admin_Categories::get_fields(array(), 'infoblock2', 2);
		$data['categories_form1'] = Controller_Admin_Categories::get_fields(array(), 'infoblock2', 1);		
		/***********************************************************/		
		
        $this->template->content = View::factory('admin/infoblock2-add')
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }

    public function action_edit() {
        $Id = $this->request->param('id');

        $infoblock2_obj = new Model_Infoblock2();

        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        if (isset($_POST['title'])) {
            $validation = Validation::factory($_POST);
            $validation->rule('title', 'not_empty');
            $validation->rule('title', 'min_length', array(':value', '2'));
            $validation->rule('title', 'max_length', array(':value', '128'));

            $validation->labels(array('title' => $this->lang['text_name']));

            if ($validation->check()) {
                
                $edit_data = array(
                    'title' => Arr::get($_POST, 'title',''),
					'info' => Arr::get($_POST, 'info', ''),
                    'link1' => Arr::get($_POST, 'link1', ''),
					'link2' => Arr::get($_POST, 'link2', ''),
					'pos_x' => Arr::get($_POST, 'pos_x', 0),
					'pos_y' => Arr::get($_POST, 'pos_y', 0),
					'type' => Arr::get($_POST, 'type', 1),
                    'status' => Arr::get($_POST, 'status', 0),
                );
               
                $result = $infoblock2_obj->edit($Id, $edit_data);

                if ($result) {
				
					/********************* Операции с модулями ********************/
					Controller_Admin_Categories::set_fields($Id, $_POST, 'infoblock2');
					/***********************************************************/
					
                    Request::initial()->redirect('admin/infoblock2'.$this->parameters);
                }
            }
            $errors = $validation->errors('validation');
        }
        $data['content'] = $infoblock2_obj->get_content($Id);
		
		/********************* Операции с модулями ********************/		
		$data['categories_form2'] = Controller_Admin_Categories::get_fields($data['content'], 'infoblock2', 2);
		$data['categories_form1'] = Controller_Admin_Categories::get_fields($data['content'], 'infoblock2', 1);
		/***********************************************************/
		
        $this->template->content = View::factory('admin/infoblock2-edit', $data)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }
	
	public function action_update() {

        $infoblock2_obj = new Model_Infoblock2();
		
		$title_arr = Arr::get($_POST, 'title');
		$info_arr = Arr::get($_POST, 'info');
		$link1_arr = Arr::get($_POST, 'link1');
		$link2_arr = Arr::get($_POST, 'link2');
		$pos_x_arr = Arr::get($_POST, 'pos_x');
		$pos_y_arr = Arr::get($_POST, 'pos_y');
		$type_arr = Arr::get($_POST, 'type');
		$status_arr = Arr::get($_POST, 'status');
		
		if($title_arr){
			foreach($title_arr as $content_id => $title){
				$edit_data = array(
					'title' => $title_arr[$content_id],
					'info' => $info_arr[$content_id],
					'link1' => $link1_arr[$content_id],
					'link2' => $link2_arr[$content_id],
					'pos_x' => $pos_x_arr[$content_id],
					'pos_y' => $pos_y_arr[$content_id],
					'type' => $type_arr[$content_id],
					'status' => $status_arr[$content_id],
				);
				$infoblock2_obj->edit($content_id, $edit_data);
			}
		}
		Request::initial()->redirect('admin/infoblock2');
    }

    public function action_delete() {
        $Id = $this->request->param('id');
        $infoblock2_obj = new Model_Infoblock2();
	
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        if (isset($_POST['delete'])) {
            $result = $infoblock2_obj->delete($Id);
            if ($result) {
                Request::initial()->redirect('admin/infoblock2');
            }
        }
        $data['content'] = $infoblock2_obj->get_content($Id);
        $this->template->content = View::factory('admin/infoblock2-delete', $data);
    }
}
// End Controller_Admin_Infoblock2
