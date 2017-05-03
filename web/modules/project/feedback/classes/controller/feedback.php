<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Feedback extends Controller {

	public function action_faq() {
		
		$categories_obj = new Model_Categories();
		
		$region = 'Не определен';
		$category_name = 'Не определен';
		$region_alias = 'Не определен';
		
		if(defined('SUBDOMEN')){
			$category_info = $categories_obj->getCategory(2, SUBDOMEN);
			$region = $category_info[0]['descriptions'][1]['title'];
			$region_alias = $category_info[0]['alias'];
		}
		
        $name = Arr::get($_POST, 'name', '');
		$email = Arr::get($_POST, 'email', '');
		$text = Arr::get($_POST, 'text', '');
		$cat = Arr::get($_POST, 'cat', '');
		
		if($cat){
			$category_info2 = $categories_obj->getCategory(1, $cat);
			$category_name = $category_info2[0]['descriptions'][1]['title'];
		}
		
        $validation = Validation::factory($_POST);
        $validation->rule('name', 'not_empty');
        $validation->rule('name', 'min_length', array(':value', '2'));
        $validation->rule('name', 'max_length', array(':value', '64'));
		
		$validation->rule('text', 'not_empty');
        $validation->rule('text', 'min_length', array(':value', '10'));
        $validation->rule('text', 'max_length', array(':value', '2000'));
		$res = true;
        $errors = '';
		$validation->labels(array(
			'name' => '-Имя-',
			'text' => '-Вопрос-',
		));
		
        if (!$validation->check()) {
		
            $res = false;
			$errors_arr = $validation->errors('validation');
			foreach($errors_arr as $error){
				$errors .= $error.'<br>';
			}
			
        } else {
		
            $siteinfo_obj = new Model_Siteinfo();
			$faq_obj = new Model_Faq();
			
			$descriptions[1]['title'] = $name;
			$descriptions[1]['body'] = $text;
			
			$add_data = array(
				'descriptions' => $descriptions,
				'parent_id' => 0,
				'group_id' => 1,
				'date' => date('Y-m-d'),
				'weight' => 0,
				'status' => 0,
			);
			
			$new_content_id = $faq_obj->add($add_data);
			
			if ($new_content_id) {
				$categories_obj->add_category_by_content($new_content_id, $category_info[0]['id'], 'faq');
				
				if($cat){
					$categories_obj->add_category_by_content($new_content_id, $category_info2[0]['id'], 'faq');
				}
			}
			
            $info = $siteinfo_obj->get_siteinfo(1);
            //Отправка эл. почты администратору
            $from = $info['email'];
			$to = $info['email'];
            $subject = 'Новый вопрос на сайте - г.' . $region . ', раздел ' . $category_name;
            $message = '<html><body>';
            $message .= $text . '<br><br>Автор сообщения: ' . $name . '<br>E-mail: ' . $email . '<br>Город - ' . $region;
            $message .= '</body></html>';
            $headers = "Content-type: text/html; charset=utf-8 \r\n";
            $headers .= "From: <" . $from . ">\r\n";
            
			mail($to, $subject, $message, $headers);
            $res = true;
        }
        echo json_encode(array('result' => $res, 'errors' => $errors));
    }
	
	public function action_reviews() {
		
		$categories_obj = new Model_Categories();
		$region = 'Не определен';
		$region_alias = 'Не определен';
		if(defined('SUBDOMEN')){
			$category_info = $categories_obj->getCategory(2, SUBDOMEN);
			$region = $category_info[0]['descriptions'][1]['title'];
			$region_alias = $category_info[0]['alias'];
		}
		
        $name = Arr::get($_POST, 'name', '');
		$text = Arr::get($_POST, 'text', '');
		
        $validation = Validation::factory($_POST);
        $validation->rule('name', 'not_empty');
        $validation->rule('name', 'min_length', array(':value', '2'));
        $validation->rule('name', 'max_length', array(':value', '64'));
		
		$validation->rule('text', 'not_empty');
        $validation->rule('text', 'min_length', array(':value', '10'));
        $validation->rule('text', 'max_length', array(':value', '2000'));
		$res = true;
        $errors = '';
		$validation->labels(array(
			'name' => '-Ваше имя-',
			'text' => '-Текст отзыва-',
		));
		
        if (!$validation->check()) {
            $res = false;
			$errors_arr = $validation->errors('validation');
			foreach($errors_arr as $error){
				$errors .= $error.'<br>';
			}
        } else {
            $siteinfo_obj = new Model_Siteinfo();
			$reviews_obj = new Model_Reviews();
			
			$descriptions[1]['title'] = $name;
			$descriptions[1]['body'] = $text;
			
			$add_data = array(
				'descriptions' => $descriptions,
				'parent_id' => 0,
				'group_id' => 1,
				'date' => date('Y-m-d'),
				'weight' => 0,
				'status' => 0,
			);
			
			$new_content_id = $reviews_obj->add($add_data);
			
			if ($new_content_id) {
				$categories_obj->add_category_by_content($new_content_id, $category_info[0]['id'], 'reviews');
			}
			
            $info = $siteinfo_obj->get_siteinfo(1);
            //Отправка эл. почты администратору
            $from = $info['email'];
			$to = $info['email'];
            $subject = 'Новый отзыв на сайте - ' . $region;
            $message = '<html><body>';
            $message .= $text . '<br><br>Автор сообщения: ' . $name . '<br>Город - ' . $region;
            $message .= '</body></html>';
            $headers = "Content-type: text/html; charset=utf-8 \r\n";
            $headers .= "From: <" . $from . ">\r\n";
            
			mail($to, $subject, $message, $headers);
            $res = true;
        }
        echo json_encode(array('result' => $res, 'errors' => $errors));
    }
}