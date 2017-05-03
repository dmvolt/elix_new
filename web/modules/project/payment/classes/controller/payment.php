<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Payment extends Controller_Template {

	public function action_send() {
	
		$order_id = Arr::get($_GET, 'order_id', 0);
		$method = Arr::get($_GET, 'method', 0);
		$total = Arr::get($_GET, 'sum', 0);
		$payment = Arr::get($_GET, 'payment', 2);
		$shortdest = '';
		
		$user_email = '';
		$user_phone = '';
		
		if($order_id){
			$orders_obj = new Model_Orders();
			$orderinfo = $orders_obj->get_order($order_id);
			
			if($orderinfo){
				if(!empty($orderinfo['order_product'])){
					foreach($orderinfo['order_product'] as $key => $value){
						if($key){
							$shortdest .= ', '.$value['product_title'];
						} else {
							$shortdest .= $value['product_title'];
						}
					}
				}
				$user_email = $orderinfo['email'];
				$user_phone = $orderinfo['phone'];
			}
			
			$payment_methods = Kohana::$config->load('admin/order.payment');
			$yandex_config = Kohana::$config->load('payment.yandex');
			
			$paymentType = $payment_methods[$payment]['code'];
			
			$payment_form_data = array(
				'shop_id' => $yandex_config['shop_id'],
				'scid' => $yandex_config['scid'],
				'formcomment' => 'Elixepil.ru - Оплата заказа №'.$order_id.' '.$shortdest,
				'short-dest' => 'Оплата заказа №'.$order_id.' '.$shortdest,
				'quickpay-form' => $yandex_config['quickpay-form'],
				'targets' => 'Оплата заказа №'.$order_id,
				'sum' => $total,
				'payment_type' => $paymentType,
				'order_id' => $order_id,
				'comment' => '',
				'success_url' => $yandex_config['success_url'],
				'fail_url' => $yandex_config['fail_url'],
				
				'user_name' => $orderinfo['name'],
				'user_address' => $orderinfo['street'].' '.$orderinfo['house'],
				'user_email' => $user_email,
				'user_phone' => $user_phone,
			);
			
			$content = View::factory($this->template_directory . 'payment-redirect')
					->bind('payment_form_data', $payment_form_data)
					->bind('service_url', $yandex_config['service_url']);
			
		} else {
			$answer_message = 'Произошла переадресация без параметра!'; // $answer_message = 'Благодарим вас за покупку! Ваш заказ оформлен';
			AW::answer($answer_message);
		}
		
        $this->page_title = 'Переадресация на страницу оплаты';
        $this->template->content = $content;
    }
	
	public function action_check() {
		$settings = new Settings();
		$yaMoneyCommonHttpProtocol = new Yamoneycommonhttpprotocol("checkOrder", $settings);
		$yaMoneyCommonHttpProtocol->processRequest($_REQUEST);
		exit;
    }
	
	public function action_aviso() {
		$settings = new Settings();
		$yaMoneyCommonHttpProtocol = new Yamoneycommonhttpprotocol("paymentAviso", $settings);
		$yaMoneyCommonHttpProtocol->processRequest($_REQUEST);
    }
	
	public function action_success() {
		$this->page_title = 'Успешная оплата';
        $this->template->content = View::factory($this->template_directory . 'payment-success');
    }
	
	public function action_fail() {
		$this->page_title = 'Ошибка оплаты';
        $this->template->content = View::factory($this->template_directory . 'payment-fail');
    }
}