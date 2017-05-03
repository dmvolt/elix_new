<?php

defined('SYSPATH') or die('No direct script access.');

class Filials {

    public static function get_block($filial) {
		$redirect_data = Kohana::$config->load('redirect');
        return View::factory(Data::_('template_directory') . 'filial_block')
				->set('filial', $filial)
				->set('redirect_data', $redirect_data);
    }

}