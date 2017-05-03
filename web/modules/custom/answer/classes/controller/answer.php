<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Answer extends Controller_Template {

    public function action_answer() {

        $answer_message = $this->session->get('answer', 0);
        $errors = $this->session->get('errors', 0);

        if (!$answer_message) {
            $this->session->delete('answer');

            $answer_message = 'Сообщений больше нет';
        } else {
            $this->session->delete('answer');
            $this->session->delete('errors');
        }

        $content = View::factory($this->template_directory . 'answer')
                ->bind('answer_errors', $errors)
                ->bind('answer_message', $answer_message);

        $this->page_title = 'Ответ';

        $this->template->content = $content;
    }

}

// End Answer