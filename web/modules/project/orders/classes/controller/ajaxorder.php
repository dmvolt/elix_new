<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Ajaxorder extends Controller {

	public function action_check_sert() {
	
		$redirect_link = false;
		$res = false;
		
        $name = Arr::get($_POST, 'sert_name', '');
        $phone = Arr::get($_POST, 'sert_phone', '');
		$email = Arr::get($_POST, 'sert_email', '');
		$code = Arr::get($_POST, 'sert_code', '');
		$price = Arr::get($_POST, 'sert_price');
		$address = Arr::get($_POST, 'sert_address', '');
		$address2 = Arr::get($_POST, 'sert_address2', '');
		$payment = Arr::get($_POST, 'sert_payment', 1);

        $validation = Validation::factory($_POST);

        $validation->rule('sert_name', 'not_empty');
        $validation->rule('sert_name', 'min_length', array(':value', '2'));
        $validation->rule('sert_name', 'max_length', array(':value', '64'));

        $validation->rule('sert_phone', 'not_empty');
		
		$validation->rule('sert_email', 'not_empty');
		$validation->rule('sert_email', 'email');
		
		/* $validation->rule('sert_address', 'not_empty'); */
        /* $validation->rule('sert_address', 'min_length', array(':value', '2')); */
        $validation->rule('sert_address', 'max_length', array(':value', '2000'));
		
		/* $validation->rule('sert_address2', 'not_empty'); */
       /*  $validation->rule('sert_address2', 'min_length', array(':value', '2')); */
        $validation->rule('sert_address2', 'max_length', array(':value', '2000'));

        if ($validation->check()) {

			$orders_obj = new Model_Orders();
			$sertifications_obj = new Model_Sertifications();
			$product_info = $sertifications_obj->get_content_to_code($code);
			
			if(!$price){
				if($product_info['old_price'] != ''){
					$price = $product_info['price'];
				} else {
					$price = $product_info['price'];
				}
			}
			
			$products[$code] = array(
				'product_code' => $code,
				'qty' => 1,
				'product_info' => $product_info,
				'price' => $price,
				'total' => $price,
			);
			
			$order_info = array(
				'name' => $name,
                'phone' => $phone,
				'email' => $email,
				'shipping' => 1,
				'payment' => $payment,
                'street' => $address,
				'house' => $address2,
				'housing' => '',
				'houseroom' => '',
				'total' => $price,
            );
			
			$payment_methods = Kohana::$config->load('admin/order.payment');
			
			$order_id = $orders_obj->add_order($order_info, $products);
			
            $siteinfo_obj = new Model_Siteinfo();
            $info = $siteinfo_obj->get_siteinfo(1);

            //Отправка эл. почты администратору
            $from = $info['email'];
            $to = $info['email'];
			
            $subject = FILIAL.' Заказ подарочного сертификата (код в системе - ' . $code . ') на сумму ';
			
			if($product_info['old_price'] != ''){
				$subject .= $product_info['old_price'].' руб. цена со скидкой '.$price.' руб.';
			} else {
				$subject .= $price.' руб.';
			}
			
            $message = '<html><body>';
            $message .= 'г. '.FILIAL.'.<br>Заказан подарочный сертификат (код в системе - ' . $code . ') на сумму ';
            
			if($product_info['old_price'] != ''){
				$message .= $product_info['old_price'].' руб. цена со скидкой '.$price.' руб. ';
			} else {
				$message .= $price.' руб. ';
			}
			
			$message .= '<br>Способ оплаты: '.$payment_methods[$payment]['name'].'<br><br>Заказчик:<br>ФИО - ' . $name . '<br>Номер телефона - ' . $phone . '<br>E-mail - ' . $email . '<br>Адрес - ' . $address . '<br>Комментарий - ' . $address2;
			
			$message .= '</body></html>';

            $headers = "Content-type: text/html; charset=utf-8 \r\n";
            $headers .= "From: <" . $from . ">\r\n";

            $result = mail($to, $subject, $message, $headers);
			
			/********************** Оплата онлайн сервисом ************************/
			if($order_info['payment'] > 1){ // Яндекс касса
				$redirect_link = '/payment/send?order_id='.$order_id.'&sum='.$order_info['total'].'&payment='.$order_info['payment'];
			}
			$res = true;
			/********************** /Оплата онлайн сервисом ************************/
        }
        echo json_encode(array('result' => $res, 'payment' => $redirect_link));
    }

	public function action_editorderstatus() {
		
        $data = array();

        $order_status = Arr::get($_POST, 'order_status', 0);
        $order_id = Arr::get($_POST, 'order_id', 0);
        $notice = Arr::get($_POST, 'notice', 0);
		$user_id = Arr::get($_POST, 'user_id', 0);

        $data = array(
            'order_id' => $order_id,
			'user_id' => $user_id,
            'order_status' => $order_status,
            'notice' => $notice,
        );

        $orders_obj = new Model_Orders();
        $res = $orders_obj->edit_order_status($data);

        echo json_encode(array('result' => $res));
    }
    
    public function action_editordershipping() {
		
        $data = array();

        $order_status = Arr::get($_POST, 'order_shipping', 0);
        $order_id = Arr::get($_POST, 'order_id', 0);
        $notice = Arr::get($_POST, 'notice', 0);
		$user_id = Arr::get($_POST, 'user_id', 0);

        $data = array(
            'order_id' => $order_id,
			'user_id' => $user_id,
            'order_shipping' => $order_status,
            'notice' => $notice,
        );

        $orders_obj = new Model_Orders();
        $res = $orders_obj->edit_order_shipping($data);

        echo json_encode(array('result' => $res));
    }
    
    public function action_editorderpayment() {
		
        $data = array();

        $order_status = Arr::get($_POST, 'order_payment', 0);
        $order_id = Arr::get($_POST, 'order_id', 0);
        $notice = Arr::get($_POST, 'notice', 0);
		$user_id = Arr::get($_POST, 'user_id', 0);

        $data = array(
            'order_id' => $order_id,
			'user_id' => $user_id,
            'order_payment' => $order_status,
            'notice' => $notice,
        );

        $orders_obj = new Model_Orders();
        $res = $orders_obj->edit_order_payment($data);

        echo json_encode(array('result' => $res));
    }
}