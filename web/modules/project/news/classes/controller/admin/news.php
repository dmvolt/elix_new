<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_News extends Controller_Admin_Template {

    public function action_index() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
		$parameters = '';
		
		$news_obj = new Model_News();
		$categories_obj = new Model_Categories();
		
		$catid = Arr::get($_GET, 'cat', null); // Получение параметра cat из адресной строки
		
        $content = View::factory('admin/news')
				->bind('parameters', $parameters)
                ->bind('contents', $contents)
				->bind('pagination', $pagination)
                ->bind('pagination2', $pagination2)
                ->bind('cat_name', $cat_name)
                ->bind('parent', $catid)
                ->bind('group_cat', $group_cat);
				
        $group_cat = Kohana::$config->load('menu.group_cat');
		
        foreach ($group_cat as $group) {
            if ($group['dictionary_id'] == 1) {
                $result = $categories_obj->getCategories($group['dictionary_id'], 0, 0);
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
					if(!$catid){
						$catid = $result[0]['id'];
					}
                }
            }
        }
		
		if ($catid) {
		
			$total = $news_obj->get_total($catid, 1, $this->lang_id);   // Получение общего количества записей
			$result = Pagination::start($total);
			$pagination = Pagination::admin_navigation($result['page'], $total, $result['total_page'], $result['num']);
			$pagination2 = Pagination::admin_navigation2($result['page'], $total, $result['total_page'], $result['num']);
			$contents = $news_obj->get_all_to_cat($catid, $result['start'], $result['num'], 's.weight', $this->lang_id);
			
			if (isset($cats2[0]['name'])) {
				$cat_name = "Новости - " . $cats[$catid]['name'];
			} else {
				$cat_name = "В данной категории нет материалов";
			}
			if (count($contents) < 1) {
				$cat_name = "В данной категории нет материалов";
			}
			
			$i = 0;
			$parameters .= ($i) ? '&cat='.$catid : '?cat='.$catid;
			$i++;
			
			if($result['page']){
				$parameters .= ($i) ? '&page='.$result['page'] : '?page='.$result['page'];
				$i++;
			}
			
		} else {
		
			$total = $news_obj->get_total(0, 1, $this->lang_id);   // Получение общего количества записей
			$result = Pagination::start($total);
			$pagination = Pagination::admin_navigation($result['page'], $total, $result['total_page'], $result['num']);
			$pagination2 = Pagination::admin_navigation2($result['page'], $total, $result['total_page'], $result['num']);
			$contents = $news_obj->get_all(1, $result['start'], $result['num'], 's.weight', $this->lang_id);
			
			$cat_name = "Новости";
			
			if (count($contents) < 1) {
				$cat_name = "В данной категории нет материалов";
			}
			
			$i = 0;
			
			if($result['page']){
				$parameters .= ($i) ? '&page='.$result['page'] : '?page='.$result['page'];
				$i++;
			}
		}
        $this->template->content = $content;
    }

    public function action_add() {
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
            $validation->rule('alias', array($this, 'unique_url'));

            $validation->labels(array('title' => $this->lang['text_name'], 'alias' => $this->lang['text_alias']));

            if ($validation->check()) {

                $add_data = array(
                    'descriptions' => Arr::get($_POST, 'descriptions', array()),
                    'date' => Arr::get($_POST, 'date', ''),
                    'alias' => Arr::get($_POST, 'alias', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );

                $news_obj = new Model_News();
                $new_content_id = $news_obj->add($add_data);

                if ($new_content_id) {
					/********************* Операции с модулями ********************/
					Controller_Admin_Categories::set_fields($new_content_id, $_POST, 'news');
					Controller_Admin_Files::set_fields($new_content_id, $_POST, 'news');
					Controller_Admin_Seo::set_fields($new_content_id, $_POST, 'news');
					/***********************************************************/
                    Request::initial()->redirect('admin/news'.$this->parameters);
                }
            }
            $errors = $validation->errors('validation');
        }
		/********************* Операции с модулями ********************/
		$data['categories_form'] = Controller_Admin_Categories::get_fields(array(), 'news');
        $data['files_form'] = Controller_Admin_Files::get_fields(array(), 'news');	
		$data['seo_form'] = Controller_Admin_Seo::get_fields(array(), 'news');
		/***********************************************************/
        $this->template->content = View::factory('admin/news-add', $data)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }

    public function action_edit() {
        $Id = $this->request->param('id');
        $news_obj = new Model_News();

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
                    'date' => Arr::get($_POST, 'date', ''),
                    'alias' => Arr::get($_POST, 'alias', ''),
                    'weight' => Arr::get($_POST, 'weight', 0),
                    'status' => Arr::get($_POST, 'status', 0),
                );
				
                $result = $news_obj->edit($Id, $edit_data);

                if ($result) {
					/********************* Операции с модулями ********************/
					Controller_Admin_Categories::set_fields($Id, $_POST, 'news');
					Controller_Admin_Files::set_fields($Id, $_POST, 'news');
					Controller_Admin_Seo::set_fields($Id, $_POST, 'news');
					/***********************************************************/
                    Request::initial()->redirect('admin/news'.$this->parameters);
                }
            }
            $errors = $validation->errors('validation');
        }
        $data['content'] = $news_obj->get_content($Id);
		
		/********************* Операции с модулями ********************/
		$data['categories_form'] = Controller_Admin_Categories::get_fields($data['content'], 'news');
        $data['files_form'] = Controller_Admin_Files::get_fields($data['content'], 'news');	
		$data['seo_form'] = Controller_Admin_Seo::get_fields($data['content'], 'news');
		/***********************************************************/

        $this->template->content = View::factory('admin/news-edit', $data)
                ->bind('errors', $errors)
                ->bind('post', $validation);
    }

    public function action_delete() {
        $Id = $this->request->param('id');
        $news_obj = new Model_News();
		$categories_obj = new Model_Categories();
		$file_obj = new Model_File();
		$seo_obj = new Model_Seo();

        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        if (isset($_POST['delete'])) {
            $result = $news_obj->delete($Id);
            if ($result) {
				/********************* Операции с модулями ********************/
				$categories_obj->delete_category_by_content($Id, 'news');
				$file_obj->delete_files_by_content($Id, 'news');
				$seo_obj->delete_by_content($Id, 'news');
				/***********************************************************/
                Request::initial()->redirect('admin/news'.$this->parameters);
            }
        }		
        $data['content'] = $news_obj->get_content($Id);
        $this->template->content = View::factory('admin/news-delete', $data);
    }

    public function unique_url($url) {
        return !DB::select(array(DB::expr('COUNT(alias)'), 'total'))
                        ->from('news')
                        ->where('alias', '=', $url)
                        ->execute()
                        ->get('total');
    }
}
// End Controller_Admin_News