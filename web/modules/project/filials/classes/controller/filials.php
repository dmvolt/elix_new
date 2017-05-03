<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Filials extends Controller {

    public function action_index() {
        if ($filial = Arr::get($_GET, 'filial')) {
			$redirect_data = Kohana::$config->load('redirect');
			
			if(isset($redirect_data[$filial])){
				Request::initial()->redirect($redirect_data[$filial]['url']);
			} else {
				Request::initial()->redirect('/');
			}
        } else {
			Request::initial()->redirect('/');
        }
    }
}
// End Controller_Filials