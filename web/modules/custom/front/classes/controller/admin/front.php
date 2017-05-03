<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Front extends Controller_Admin_Template {

    public function action_index() {
        $content = View::factory('admin/main');

        $content->page_title = 'Главная страница админки';
        $content->page_text = 'Здравствуйте, Вы находитесь в администраторском разделе сайта.';
                
        $roles = Kohana::$config->load('admin/user.roles');
        
        if($roles[$this->user->role_id]['in_front'] != '' AND $roles[$this->user->role_id]['in_front'] != '/admin'){
            Request::initial()->redirect($roles[$this->user->role_id]['in_front']);
        }
        $this->template->content = $content;
    }

}

// End Admin_Front