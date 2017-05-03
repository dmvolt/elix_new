<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Comments extends Controller_Admin_Template {

    public function action_update() {
        $comment_obj = new Model_Comment();
        
        $status = Arr::get($_POST, 'status', array());
        $delete = Arr::get($_POST, 'delete', array());
        $author = Arr::get($_POST, 'author', array());
        $message = Arr::get($_POST, 'message', array());
        $redirect_uri = Arr::get($_POST, 'redirect_uri', '/');
        $content_id = Arr::get($_POST, 'content_id', false);
        $module = Arr::get($_POST, 'module', false);
        $lang_id = Arr::get($_POST, 'lang_id', $this->lang_id);
        $user_id = Arr::get($_POST, 'user_id', $this->user->id);
		
		$post = array(
			'status' => $status,
			'delete' => $delete,
			'author' => $author,
			'message' => $message,
			'redirect_uri' => $redirect_uri,
			'content_id' => $content_id,
			'module' => $module,
			'lang_id' => $lang_id,
			'user_id' => $user_id,
		);

        if (!empty($status)) {
            $comment_obj->edit_status_messages($post);
        }
        
        if (!empty($author) AND !empty($message)) {
            $comment_obj->reply_messages($post);
        }
        
        if (!empty($delete)) {
            $comment_obj->delete_messages($post);
        }
        Request::initial()->redirect($redirect_uri);
    }
	
	public function action_index() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);
		
		$comment_obj = new Model_Comment();
		
		$query = '';
		
		$filter = Arr::get($_GET, 'filter', 'all'); // Получение параметра filter из адресной строки
		//$module = Arr::get($_GET, 'module', 'all'); // Получение параметра module из адресной строки
		
		if($filter != 'all'){
			$query .= ' AND `status` = ' . $filter;
		}
		
		/* if($module != 'all'){
			$query .= ' AND `module` = "' . $module . '"';
		} */

        $comments = $comment_obj->get_all_comments($query);
		
        $content = View::factory('admin/comments')
				->bind('user_name', $this->user->username)
                ->bind('comments', $comments);

        $this->template->content = $content;
    }
}