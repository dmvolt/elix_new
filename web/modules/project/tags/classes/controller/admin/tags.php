<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Tags extends Controller_Admin_Template {

	public function action_index() {

        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
		$group = Arr::get($_GET, 'group_id', 0);

        $tags_obj = new Model_Tags();
		
		$group_tags = Kohana::$config->load('tags.group_tags');

        if (isset($_POST['name'])) {
            $group_id = Arr::get($_POST, 'group_id', 1);
            $name = Arr::get($_POST, 'name', array());

            $add_data = array(
                'name' => $name,
                'group_id' => $group_id,
            );

            $result = $tags_obj->add_tag($add_data);

            if ($result) {
                Request::initial()->redirect('admin/tags');
            }
        }
		
		$contents = $tags_obj->get_all($group);

        $content = View::factory('admin/tags')
                ->bind('contents', $contents)
                ->bind('group_tags', $group_tags);

        $this->template->content = $content;
    }

    public function action_edit() {
        $Id = $this->request->param('id');

        $tags_obj = new Model_Tags();
		$group_tags = Kohana::$config->load('tags.group_tags');

        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        if (isset($_POST['name'])) {
            $group_id = Arr::get($_POST, 'group_id', 1);
            $name = Arr::get($_POST, 'name', array());
			$alias = Arr::get($_POST, 'alias', '');

            $add_data = array(
                'name' => $name,
                'group_id' => $group_id,
				'alias' => $alias,
            );

            $result = $tags_obj->edit_tag($Id, $add_data);

            if ($result) {
                Request::initial()->redirect('admin/tags');
            }
        }
        $data['content'] = $tags_obj->get_tag($Id);

        $this->template->content = View::factory('admin/tags-edit', $data)->bind('group_tags', $group_tags);
    }

    public function action_delete() {
        $Id = $this->request->param('id');
        $tags_obj = new Model_Tags();

        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        if (isset($_POST['delete'])) {
            $result = $tags_obj->delete_tag($Id);
            if ($result) {
                Request::initial()->redirect('admin/tags');
            }
        }

        $data['content'] = $tags_obj->get_tag($Id);

        $this->template->content = View::factory('admin/tags-delete', $data);
    }

	public static function set_fields($id, $post = array(), $group_id = 1, $module = 'products') {
		$tags_obj = new Model_Tags();
		$tags = Arr::get($post, 'tags', array());
		
		$tags_obj->add($id, $group_id, $tags, $module);
		return true;
    }
	
	public static function get_fields($data = array(), $group_id = 1, $module = 'products') {
		$tags_obj = new Model_Tags();
		
		$group_tags = Kohana::$config->load('tags.group_tags');
		
		if($data AND !empty($data)){
			$result = $tags_obj->get_tags_to_content($data['id'], $group_id, $module, 1);
		} else {
			$languages = Kohana::$config->load('language');
			foreach($languages as $value){
				$result[$value['lang_id']] = '';
			}
		}		
		return View::factory('admin/fields_tags')
				->bind('group', $group_tags[$group_id][1])
                ->bind('field', $result);
    }
}