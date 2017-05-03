<?php

defined('SYSPATH') or die('No direct script access.');

class Services {

    public static function services_block($num = 4) {
        $content = View::factory(Data::_('template_directory') . 'services')
                ->bind('services', $services);
        $services_obj = new Model_Services();
        $services = $services_obj->get_last($num);
        return $content;
    }
	
	public static function service_right_block($id) {
        return View::factory(Data::_('template_directory') . 'service_right_block')->bind('id', $id);
    }
}
// Services