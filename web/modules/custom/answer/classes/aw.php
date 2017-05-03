<?php

defined('SYSPATH') or die('No direct script access.');

class AW {

    public static function answer($answer_message, $errors = array()) {

        $message = Data::_('session')->get('answer', 0);
        $errors_message = Data::_('session')->get('errors', 0);

        if ($message) {
            Data::_('session')->delete('answer');
        }

        if ($errors_message) {
            Data::_('session')->delete('errors');
        }

        Data::_('session')->set('answer', $answer_message);
        Data::_('session')->set('errors', $errors);
        Request::initial()->redirect('/answer');
    }

}