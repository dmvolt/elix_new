<?php

defined('SYSPATH') or die('No direct script access.');

class Actions {
   
	public static function actions_block($num = 1) {
        $content = View::factory(Data::_('template_directory') . 'actions-block')
				->bind('edit_interface', $edit_interface)
                ->bind('actions', $actions);
        $actions_obj = new Model_Actions();
        //$actions = $actions_obj->get_last($num);
		$actions = $actions_obj->get_first($num);
		$edit_interface = Liteedit::get_interface($actions[0]['id'], 'actions', 'text_field', true);
        return $content;
    }
}
// Actions