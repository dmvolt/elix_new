<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Orders extends Controller_Admin_Template {

    public static function get() {
        
        $orders_obj = new Model_Orders();

		$filter['order_id'] = Arr::get($_GET, 'order_id', '');
		$filter['order_status'] = Arr::get($_GET, 'order_status', 0);
		$filter['order_phone'] = Arr::get($_GET, 'order_phone', '');

        $result = $orders_obj->get_all_orders($filter);

        $order_status = Kohana::$config->load('admin/order.status');

        echo View::factory('admin/orders')
                ->bind('all_orders', $result)
                ->bind('order_status', $order_status)
                ->bind('current_order_status', $filter['order_status']);
    }
    
    public function action_index() {
        
        $orders_obj = new Model_Orders();

		$filter['order_id'] = Arr::get($_GET, 'order_id', '');
		$filter['order_status'] = Arr::get($_GET, 'order_status', 0);
		$filter['order_phone'] = Arr::get($_GET, 'order_phone', '');

        $result = $orders_obj->get_all_orders($filter);

        $order = Kohana::$config->load('admin/order');

        $this->template->content = View::factory('admin/orders')
                ->bind('all_orders', $result)
                ->bind('order', $order)
                ->bind('current_order_status', $filter['order_status']);
    }
    
    public function action_edit() {
        $Id = $this->request->param('id');

        $orders_obj = new Model_Orders();

        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        $data['content'] = $orders_obj->get_order($Id);
        $data['order'] = Kohana::$config->load('admin/order');
        $this->template->content = View::factory('admin/orders-edit', $data);
    }

    public function action_delete() {
        $Id = $this->request->param('id');
        $orders_obj = new Model_Orders();

        $this->session->delete('content_redirect');
        $this->session->set('content_redirect', $_SERVER['REQUEST_URI']);

        if (isset($_POST['delete'])) {
            $result = $orders_obj->delete($Id);
            if ($result) {
                Request::initial()->redirect('admin/orders');
            }
        }

        $data['content'] = $orders_obj->get_order($Id);

        $this->template->content = View::factory('admin/orders-delete', $data);
    }
}
// End Controller_Admin_Order