<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Kohana user guide and api browser.
 *
 * @package    Kohana/Userguide
 * @category   Controllers
 * @author     Kohana Team
 */
class Controller_Admin_Reviews extends Controller_Admin_Template {

    public function action_index() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		$parameters = '';
		$contents = array();
		
		$reviews_obj = new Model_Reviews();
		$categories_obj = new Model_Categories();
		
		$catid = Arr::get($_GET, 'cat'); // Получение параметра cat из адресной строки
		
		if (isset($_POST['descriptions'][1]['title'])) {
            $v_data = array(
				'descriptions' => $_POST['descriptions'], 
				'title' => $_POST['descriptions'][1]['title']
			);
            $validation = Validation::factory($v_data);
            $validation->rule('title', 'not_empty');
            $validation->rule('title', 'min_length', array(':value', '2'));
            $validation->rule('title', 'max_length', array(':value', '128'));
            $validation->labels(array('title' => $this->lang['text_name']));
            if ($validation->check()) {
                $add_data = array(
                    'descriptions' => Arr::get($_POST, 'descriptions', array()),
					'parent_id' => Arr::get($_POST, 'parent_id', 0),
                    'group_id' => Arr::get($_POST, 'group_id', 1),
					'date' => Arr::get($_POST, 'date', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
                    'status' => Arr::get($_POST, 'status', 1),
                );
                $new_content_id = $reviews_obj->add($add_data);
                if ($new_content_id) {
					/********************* Операции с модулями ********************/
					Controller_Admin_Categories::set_fields($new_content_id, $_POST, 'reviews');
					/***********************************************************/
                    Request::initial()->redirect('admin/reviews'.$this->parameters);
                }
            }
            $errors = $validation->errors('validation');
        }
		
		/********************* Операции с модулями ********************/
		$categories_form = Controller_Admin_Categories::get_fields(array(), 'reviews', 2, false, ''); // true - в диве с заголовком, 'multiple' - select type
		/***********************************************************/
		
		$group_reviews = Kohana::$config->load('reviews.group_reviews');
        $content = View::factory('admin/reviews')
				->bind('parameters', $parameters)
				->bind('group_reviews', $group_reviews)
				->bind('cat_name', $cat_name)
				->bind('categories_form', $categories_form)
                ->bind('parent', $catid)
                ->bind('group_cat', $group_cat)
				->bind('errors', $errors)
                ->bind('post', $validation)
                ->bind('contents', $contents);
				
		$group_cat = Kohana::$config->load('menu.group_cat');
        foreach ($group_cat as $group) {
            if ($group['dictionary_id'] == 2) {
                $result = $categories_obj->getCategories($group['dictionary_id'], 0, 2);
                if ($result) {
                    foreach ($result as $item) {
                        $cats[$item['id']] = array(
                            'name' => $item['descriptions'][1]['title'],
                        );
                        $cats2[] = array(
                            'id' => $item['id'],
                            'name' => $item['descriptions'][1]['title'],
                        );
                    }
                }
            }
        }
		if ($catid) {
			$parent = $reviews_obj->get_all_to_cat($catid, 0, 100, 'a.weight, a.date DESC', 0, 1);		
			if(!empty($parent)){
				foreach($parent as $value){
					$childs = $reviews_obj->get_childs($value['id'], 1);
					$contents[] = array(
						'id' => $value['id'],
						'parent_id' => $value['parent_id'],
						'date' => $value['date'],
						'group_id' => $value['group_id'],
						'descriptions' => $value['descriptions'],
						'weight' => $value['weight'],
						'status' => $value['status'],
						'answer' => $childs,
					);
				}
			}
		
			if (isset($cats2[0]['name'])) {
				$cat_name = "Отзывы - " . $cats[$catid]['name'];
			} else {
				$cat_name = "В данной категории нет материалов";
			}
			
			$parameters .= '?cat='.$catid;
			
		} else {
			$parent = $reviews_obj->get_all(1);
			if(!empty($parent)){
				foreach($parent as $value){
					$childs = $reviews_obj->get_childs($value['id'], 1);
					$contents[] = array(
						'id' => $value['id'],
						'parent_id' => $value['parent_id'],
						'date' => $value['date'],
						'group_id' => $value['group_id'],
						'descriptions' => $value['descriptions'],
						'weight' => $value['weight'],
						'status' => $value['status'],
						'answer' => $childs,
					);
				}
			}
			$cat_name = "Все отзывы";
		}
        $this->template->content = $content;
    }
	
    public function action_add() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
        if (isset($_POST['descriptions'][1]['title'])) {
            $v_data = array(
				'descriptions' => $_POST['descriptions'], 
				'title' => $_POST['descriptions'][1]['title']
			);
            $validation = Validation::factory($v_data);
            $validation->rule('title', 'not_empty');
            $validation->rule('title', 'min_length', array(':value', '2'));
            $validation->rule('title', 'max_length', array(':value', '128'));
            $validation->labels(array('title' => $this->lang['text_name']));
            if ($validation->check()) {
                $add_data = array(
                    'descriptions' => Arr::get($_POST, 'descriptions', array()),
                    'group_id' => Arr::get($_POST, 'group_id', 1),
					'date' => Arr::get($_POST, 'date', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );
                $reviews_obj = new Model_Reviews();
                $result = $reviews_obj->add($add_data);
                if ($result) {
                    Request::initial()->redirect('admin/reviews');
                }
            }
            $errors = $validation->errors('validation');
        }
        $this->template->content = View::factory('admin/reviews-add')
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }
	
    public function action_edit() {
        $Id = $this->request->param('id');
        $reviews_obj = new Model_Reviews();
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
        if (isset($_POST['descriptions'][1]['title'])) {
            $v_data = array(
				'descriptions' => $_POST['descriptions'], 
				'title' => $_POST['descriptions'][1]['title']
			);
            $validation = Validation::factory($v_data);
            $validation->rule('title', 'not_empty');
            $validation->rule('title', 'min_length', array(':value', '2'));
            $validation->rule('title', 'max_length', array(':value', '128'));
            $validation->labels(array('title' => $this->lang['text_name']));
            if ($validation->check()) {
                $edit_data = array(
                    'descriptions' => Arr::get($_POST, 'descriptions', array()),
					'group_id' => Arr::get($_POST, 'group_id', 1),
                    'date' => Arr::get($_POST, 'date', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );
				
                $result = $reviews_obj->edit($Id, $edit_data);
                if ($result) {
					/********************* Операции с модулями ********************/
					Controller_Admin_Files::set_fields($Id, $_POST, 'reviews');
					Controller_Admin_Categories::set_fields($Id, $_POST, 'reviews');
					/***********************************************************/
                    Request::initial()->redirect('admin/reviews'.$this->parameters);
                }
            }
            $errors = $validation->errors('validation');
        }
        $data['content'] = $reviews_obj->get_content($Id);
		
		/********************* Операции с модулями ********************/
		$data['files_form'] = Controller_Admin_Files::get_fields($data['content'], 'reviews');
		$data['categories_form'] = Controller_Admin_Categories::get_fields($data['content'], 'reviews', 2);		
		/***********************************************************/
        $this->template->content = View::factory('admin/reviews-edit', $data)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }
	
    public function action_delete() {
        $Id = $this->request->param('id');
        $reviews_obj = new Model_Reviews();
		$categories_obj = new Model_Categories();
		$file_obj = new Model_File();
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
        if (isset($_POST['delete'])) {
			$childs = $reviews_obj->get_childs($Id, 1);
            $result = $reviews_obj->delete($Id);
            if ($result) {
				/********************* Операции с модулями ********************/
				$file_obj->delete_files_by_content($Id, 'reviews');
				$categories_obj->delete_category_by_content($Id, 'reviews');
				/***********************************************************/
				if($childs){
					foreach($childs as $value){
						$result2 = $reviews_obj->delete($value['id']);
						if ($result2) {
							/********************* Операции с модулями ********************/
							$file_obj->delete_files_by_content($Id, 'reviews');
							$categories_obj->delete_category_by_content($value['id'], 'reviews');
							/***********************************************************/
						}
					}
				}
                Request::initial()->redirect('admin/reviews'.$this->parameters);
            }
        }		
        $data['content'] = $reviews_obj->get_content($Id);
        $this->template->content = View::factory('admin/reviews-delete', $data);
    }
	
    public function unique_url($url) {
        return !DB::select(array(DB::expr('COUNT(alias)'), 'total'))
                        ->from('reviews')
                        ->where('alias', '=', $url)
                        ->execute()
                        ->get('total');
    }
}
// End Controller_Admin_reviews