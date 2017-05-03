<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Kohana user guide and api browser.
 *
 * @package    Kohana/Userguide
 * @category   Controllers
 * @author     Kohana Team
 */
class Controller_Admin_Faq extends Controller_Admin_Template {

    public function action_index() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
		$faq_obj = new Model_Faq();
		$categories_obj = new Model_Categories();
		
		$catid1 = Arr::get($_GET, 'cat1', null); // Получение параметра cat1 (Город) из адресной строки
		$catid2 = Arr::get($_GET, 'cat2', null); // Получение параметра cat2 (Раздел) из адресной строки
		
		$contents = array();
		$cat_name = '';
		$filter_query = '';
		$inner_join = '';
		$parameters = '';
		$i = 0;
		
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
                $new_content_id = $faq_obj->add($add_data);
                if ($new_content_id) {
					/********************* Операции с модулями ********************/
					Controller_Admin_Categories::set_fields($new_content_id, $_POST, 'faq');
					/***********************************************************/
                    Request::initial()->redirect('admin/faq'.$this->parameters);
                }
            }
            $errors = $validation->errors('validation');
        }
		
		/********************* Операции с модулями ********************/
		$categories_form1 = Controller_Admin_Categories::get_fields(array(), 'faq', 1, false, ''); // true - в диве с заголовком, 'multiple' - select type
		$categories_form2 = Controller_Admin_Categories::get_fields(array(), 'faq', 2, false, ''); // true - в диве с заголовком, 'multiple' - select type
		/***********************************************************/
		
		$group_faq = Kohana::$config->load('faq.group_faq');
        $content = View::factory('admin/faq')
				->bind('parameters', $parameters)
				->bind('group_faq', $group_faq)
				->bind('categories_form1', $categories_form1)
				->bind('categories_form2', $categories_form2)
				->bind('errors', $errors)
                ->bind('post', $validation)
                ->bind('contents', $contents)
				->bind('cat_name', $cat_name)
                ->bind('parent1', $catid1)
				->bind('parent2', $catid2)
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
			$filter_query .= ' AND (cc1.category_id = '.$catid1.' AND cc1.module = "faq") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc1 ON cc1.content_id = f.id ';
			
			$parameters .= ($i)?'&cat1='.$catid1:'?cat1='.$catid1;
			$i++;
			
			$cat_name .= 'Вопрос (ответ) - '.$cats[2][$catid1]['name'];
		}
		
		if($catid2 AND !empty($catid2)){
			$filter_query .= ' AND (cc2.category_id = '.$catid2.' AND cc2.module = "faq") ';		
			$inner_join .= ' INNER JOIN `contents_categories` cc2 ON cc2.content_id = f.id ';
			
			$cat_name .= ($i)?', '.$cats[1][$catid2]['name']:'Вопрос (ответ) - '.$cats[1][$catid2]['name'];
			
			$parameters .= ($i)?'&cat2='.$catid2:'?cat2='.$catid2;
			$i++;
		}
		
		$total = $faq_obj->get_total_all(1, $inner_join, $filter_query, $this->lang_id);   // Получение общего количества записей
		$result = Pagination::start($total);
		$pagination = Pagination::admin_navigation($result['page'], $total, $result['total_page'], $result['num']);
		$pagination2 = Pagination::admin_navigation2($result['page'], $total, $result['total_page'], $result['num']);
		$parent = $faq_obj->get_all(1, $result['start'], $result['num'], 'f.weight', $inner_join, $filter_query, 0, $this->lang_id);
		
		if(!empty($parent)){
			foreach($parent as $value){
				$childs = $faq_obj->get_childs($value['id'], 1);
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

		if($result['page']){
			$parameters .= ($i) ? '&page='.$result['page'] : '?page='.$result['page'];
			$i++;
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
                $faq_obj = new Model_Faq();
                $result = $faq_obj->add($add_data);
                if ($result) {
                    Request::initial()->redirect('admin/faq');
                }
            }
            $errors = $validation->errors('validation');
        }
        $this->template->content = View::factory('admin/faq-add')
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }
	
    public function action_edit() {
        $Id = $this->request->param('id');
        $faq_obj = new Model_Faq();
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
				
                $result = $faq_obj->edit($Id, $edit_data);
                if ($result) {
					/********************* Операции с модулями ********************/
					Controller_Admin_Files::set_fields($Id, $_POST, 'faq');
					Controller_Admin_Categories::set_fields($Id, $_POST, 'faq');
					/***********************************************************/
                    Request::initial()->redirect('admin/faq'.$this->parameters);
                }
            }
            $errors = $validation->errors('validation');
        }
        $data['content'] = $faq_obj->get_content($Id);
		
		/********************* Операции с модулями ********************/
		$data['files_form'] = Controller_Admin_Files::get_fields($data['content'], 'faq');
		$data['categories_form1'] = Controller_Admin_Categories::get_fields($data['content'], 'faq', 1);	
		$data['categories_form2'] = Controller_Admin_Categories::get_fields($data['content'], 'faq', 2);		
		/***********************************************************/
        $this->template->content = View::factory('admin/faq-edit', $data)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }
	
    public function action_delete() {
        $Id = $this->request->param('id');
        $faq_obj = new Model_Faq();
		$categories_obj = new Model_Categories();
		$file_obj = new Model_File();
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
        if (isset($_POST['delete'])) {
			$childs = $faq_obj->get_childs($Id, 1);
            $result = $faq_obj->delete($Id);
            if ($result) {
				/********************* Операции с модулями ********************/
				$file_obj->delete_files_by_content($Id, 'faq');
				$categories_obj->delete_category_by_content($Id, 'faq');
				/***********************************************************/
				if($childs){
					foreach($childs as $value){
						$result2 = $faq_obj->delete($value['id']);
						if ($result2) {
							/********************* Операции с модулями ********************/
							$file_obj->delete_files_by_content($Id, 'faq');
							$categories_obj->delete_category_by_content($value['id'], 'faq');
							/***********************************************************/
						}
					}
				}
                Request::initial()->redirect('admin/faq'.$this->parameters);
            }
        }		
        $data['content'] = $faq_obj->get_content($Id);
        $this->template->content = View::factory('admin/faq-delete', $data);
    }
	
    public function unique_url($url) {
        return !DB::select(array(DB::expr('COUNT(alias)'), 'total'))
                        ->from('faq')
                        ->where('alias', '=', $url)
                        ->execute()
                        ->get('total');
    }
}
// End Controller_Admin_faq