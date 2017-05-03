<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Orders extends Controller_Template {

	public function action_checkout() {  
		$this->auto_render = false; //не использовать главный шаблон вида "template"
		
        $name = Arr::get($_POST, 'sert_name', '');
        $tell = Arr::get($_POST, 'sert_tell', '');
		$email = Arr::get($_POST, 'sert_email', '');
		$code = Arr::get($_POST, 'sert_code', '');
		$price = Arr::get($_POST, 'sert_price', '');
		$address = Arr::get($_POST, 'sert_address', '');
		$address2 = Arr::get($_POST, 'sert_address2', '');
		$payment = Arr::get($_POST, 'sert_payment', 1);

        $validation = Validation::factory($_POST);

        $validation->rule('sert_name', 'not_empty');
        $validation->rule('sert_name', 'min_length', array(':value', '2'));
        $validation->rule('sert_name', 'max_length', array(':value', '64'));

        $validation->rule('sert_tell', 'not_empty');
		
		$validation->rule('sert_email', 'not_empty');
		$validation->rule('sert_email', 'email');
		
		$validation->rule('sert_address', 'not_empty');
        $validation->rule('sert_address', 'min_length', array(':value', '2'));
        $validation->rule('sert_address', 'max_length', array(':value', '255'));
		
		$validation->rule('sert_address2', 'not_empty');
        $validation->rule('sert_address2', 'min_length', array(':value', '2'));
        $validation->rule('sert_address2', 'max_length', array(':value', '255'));

        if (!$validation->check()) {
            $errors = $validation->errors('validation');
			$answer_message = 'Извините, заказ не может быть оформлен';
			AW::answer($answer_message, $errors);
        } else {
			$orders_obj = new Model_Orders();
			$sertifications_obj = new Model_Sertifications();
			$product_info = $sertifications_obj->get_content_to_code($code);
			
			$products[$code] = array(
				'product_code' => $code,
				'qty' => 1,
				'product_info' => $product_info,
				'price' => $price,
				'total' => $price,
			);
			
			$order_info = array(
				'name' => $name,
                'phone' => $tell,
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
            $subject = FILIAL.' Заказ подарочного сертификата ' . $code . ' на сумму '. $price . ' руб.';
            $message = '<html><body>';
            $message .= 'г. '.FILIAL.'.<br>Заказан подарочный сертификат ' . $code . ' на сумму ' . $price . ' руб.<br>Способ оплаты: '.$payment_methods[$payment]['name'].'<br><br>Заказчик:<br>ФИО - ' . $name . '<br>Номер телефона - ' . $tell . '<br>E-mail - ' . $email . '<br>Адрес - ' . $address . '<br>Комментарий - ' . $address2;
            $message .= '</body></html>';

            $headers = "Content-type: text/html; charset=utf-8 \r\n";
            $headers .= "From: <" . $from . ">\r\n";

            $result = mail($to, $subject, $message, $headers);
			
			/********************** Оплата онлайн сервисом ************************/
			if($order_info['payment'] > 1){ // Яндекс касса
				Request::initial()->redirect('/payment/send?order_id='.$order_id.'&sum='.$order_info['total'].'&payment='.$order_info['payment']);
			} elseif($order_info['payment'] == 1) {
				$answer_message = '<h3>Ваш заказ принят!</h3>';
				$answer_message .= '<h5>Наши операторы свяжутся с Вами по телефону '.$order_info['phone'].'.</h5>';
				$answer_message .= '<h4>Номер заказа:</h4>';
				$answer_message .= '<hr>';
				$answer_message .= '<h3><span class="text-danger">'.$result.'</span></h3>';
				$answer_message .= '<hr>';
				$answer_message .= '<h4>Сумма: <span class="text-danger">'.$order_info['total'].' руб.</span></h4>';
				$answer_message .= '<small>Спасибо за заказ!</small>';
				$answer_message .= '<hr>';
				
                AW::answer($answer_message);
			}
			/********************** /Оплата онлайн сервисом ************************/
        }
    }
}