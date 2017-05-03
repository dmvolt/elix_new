<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Invoice extends Controller_Template {

    public function action_index() {
        $this->auto_render = false; //не использовать главный шаблон вида "template"	
		$data = array();
		$orders_obj = new Model_Orders();

		$order_id = Arr::get($_GET, 'order_id', 0);
		$data['content'] = $orders_obj->get_order($order_id);

        $this->response->body(View::factory(Data::_('template_directory') . 'invoice', $data));
    }
}