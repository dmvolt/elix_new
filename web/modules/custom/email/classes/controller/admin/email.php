<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Email extends Controller_Admin_Template {

    public function action_index() {
        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        $content = View::factory('admin/email')
                ->bind('contents', $contents);

        $material = new Model_Email();
        $contents = $material->get_all();

        $this->template->content = $content;
    }

    public function action_edit() {
        $Id = $this->request->param('id');

        $content = new Model_Email();

        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        if (isset($_POST['title'])) {
            $title = Arr::get($_POST, 'title', '');
            $body = Arr::get($_POST, 'body', '');

            $material = array(
                'title' => $title,
                'body' => $body
            );

            $result = $content->edit($Id, $material);

            if ($result) {
                Request::initial()->redirect('admin/email');
            }
        }

        $data['content'] = $content->get_content($Id);

        if ($Id < 4) {
            $data['email_tokens'] = Kohana::$config->load('email_tokens.user');
        } else {
            $data['email_tokens'] = Kohana::$config->load('email_tokens.products');
        }

        $this->template->content = View::factory('admin/email-edit', $data);
    }

}