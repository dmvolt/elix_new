<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax extends Controller {

    public function action_emailunique() {	
		
        //$email = Arr::get($_POST, 'email', '');
        $validation = Validation::factory($_POST);
        $validation->rule('email', 'not_empty');
        $validation->rule('email', 'email');
        $validation->rule('email', 'email_unique');

        if ($validation->check()) {
            $res = 1;
        } else {
            $res = 0;
        }
        echo json_encode(array('result' => $res));
    }

    public function action_loginunique() {
		
        //$login = Arr::get($_POST, 'username', '');
        $validation = Validation::factory($_POST);
        //$validation->rule('username', 'not_empty');
        $validation->rule('username', 'min_length', array(':value', '3'));
        $validation->rule('username', 'max_length', array(':value', '64'));
        $validation->rule('username', 'username_unique');
        $validation->rule('username', 'alpha_numeric');

        if ($validation->check()) {
            $res = 1;
        } else {
            $res = 0;
        }
        echo json_encode(array('result' => $res));
    }

    public function action_checkOldPass() {
		
        $oldpass = Arr::get($_POST, 'oldpass', '');
        $id = Arr::get($_POST, 'user_id', 0);

        $user = new Model_User();
        $res = $user->checkOldPass($id, $oldpass);

        echo json_encode(array('result' => $res));
    }

    public function action_savenewpass() {
		
        $newpass1 = Arr::get($_POST, 'newpass1', '');
        $newpass2 = Arr::get($_POST, 'newpass2', '');
        $oldpass = Arr::get($_POST, 'oldpass', '');
        $id = Arr::get($_POST, 'user_id', 0);

        $user = new Model_User();
        $res = $user->save_new_pass($id, $oldpass, $newpass1, $newpass2);

        echo json_encode(array('result' => $res));
    }

    public function action_generatealias() {
		
        $name = Arr::get($_POST, 'name', '');
        $res = Text::transliteration($name);

        echo json_encode(array('result' => $res));
    }

    public function action_renum() {
		
        $num = Arr::get($_POST, 'num', 10);
        
        $pagination_num = $this->session->get('num', 0);

        if ($pagination_num) {
            $this->session->delete('num');
            $this->session->set('num', $num);
        } else {
            $this->session->set('num', $num);
        }

        $res = TRUE;
        echo json_encode(array('result' => $res));
    }

    public function action_subject() {
		
        $name = Arr::get($_POST, 'name', '');
        $tell = Arr::get($_POST, 'tell', '');
		$time = Arr::get($_POST, 'time', '');
		$what_is = Arr::get($_POST, 'what_is', '');

        $validation = Validation::factory($_POST);

        $validation->rule('name', 'not_empty');
        $validation->rule('name', 'min_length', array(':value', '2'));
        $validation->rule('name', 'max_length', array(':value', '64'));

        $validation->rule('tell', 'not_empty');

        if (!$validation->check()) {
            $res = false;
        } else {
            $siteinfo = new Model_Siteinfo();
            $info = $siteinfo->get_siteinfo(1);

            //Отправка эл. почты администратору
            $from = $info['email'];
            $to = $info['email'];
            $subject = 'Запись на прием от ' . $name;
            $message = '<html><body>';
            $message .= 'Запись на прием:<br>Номер телефона ' . $tell . '<br>Желаемое время ' . $time . '<br>Хочу эпилировать ' . $what_is;
            $message .= '</body></html>';

            $headers = "Content-type: text/html; charset=utf-8 \r\n";
            $headers .= "From: <" . $from . ">\r\n";

            $result = mail($to, $subject, $message, $headers);

            $res = true;
        }
        echo json_encode(array('result' => $res));
    }
	
	public function action_rev_subject() {
		
        $name = Arr::get($_POST, 'rev_name', '');
        $text = Arr::get($_POST, 'rev_address', '');

        $validation = Validation::factory($_POST);

        $validation->rule('rev_name', 'not_empty');
        $validation->rule('rev_name', 'min_length', array(':value', '2'));
        $validation->rule('rev_name', 'max_length', array(':value', '64'));

        $validation->rule('rev_address', 'not_empty');
		$validation->rule('rev_address', 'min_length', array(':value', '10'));
        $validation->rule('rev_address', 'max_length', array(':value', '2000'));

        if (!$validation->check()) {
            $res = false;
        } else {
		
			$add_data = array(
				'descriptions' => array(1 => array('title' => $name, 'body' => $text)),
				'group_id' => Arr::get($_POST, 'group_id', 1),
				'date' => Arr::get($_POST, 'date', ''),
				'weight' => Arr::get($_POST, 'weight', 0),
				'status' => Arr::get($_POST, 'status', 0),
			);
			
			$reviews_obj = new Model_Reviews();
			$result = $reviews_obj->add($add_data);
			
            $siteinfo = new Model_Siteinfo();
            $info = $siteinfo->get_siteinfo(1);

            //Отправка эл. почты администратору
            $from = $info['email'];
            $to = $info['email'];
            $subject = 'Новый отзыв от ' . $name;
            $message = '<html><body>';
            $message .= $text.'<br>Отзыв оставил(а) ' . $name;
            $message .= '</body></html>';

            $headers = "Content-type: text/html; charset=utf-8 \r\n";
            $headers .= "From: <" . $from . ">\r\n";

            $result = mail($to, $subject, $message, $headers);
            $res = true;
        }
        echo json_encode(array('result' => $res));
    }
	
	public function action_check_sert() {
	
		$redirect_link = false;
		$res = false;
		
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

        if ($validation->check()) {

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
			
			$message .= '<br>Способ оплаты: '.$payment_methods[$payment]['name'].'<br><br>Заказчик:<br>ФИО - ' . $name . '<br>Номер телефона - ' . $tell . '<br>E-mail - ' . $email . '<br>Адрес - ' . $address . '<br>Комментарий - ' . $address2;
			
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

    public function action_getchild() {
		
        $category = new Model_Categories();
        $parrent = Arr::get($_POST, 'parrent', 0);

        if ($parrent) {
            $catsdata = $category->getCategories(2, $parrent, 0);
        }

        if (isset($catsdata) AND $catsdata) {
            $res = '';
            foreach ($catsdata as $key => $cat) {
                $res .= '<li name="' . $cat['id'] . '" class="';
                if (!$key) {
                    $res .= 'first';
                }
                $res .= '">' . $cat['menu'] . '</li>';
            }
        } else {
            $res = 0;
        }
        echo json_encode(array('result' => $res));
    }
	
	public function action_autocomplete() {
		$res = array();
        $filter_name = Arr::get($_GET, 'filter_name');
		$module = Arr::get($_GET, 'module');
		$lang_id = Arr::get($_GET, 'lang_id', 1);
		$group_id = Arr::get($_GET, 'group_id', 1);
		
		if($module AND $filter_name){
			$filter_name_array = explode(',', $filter_name);
			if(count($filter_name_array)>1){
				$res = Model::factory($module)->get_autocomplete_content(trim(end($filter_name_array)), $lang_id, $group_id);
			} else {
				$res = Model::factory($module)->get_autocomplete_content($filter_name, $lang_id, $group_id);
			}
		}
        echo json_encode($res);
    }
}