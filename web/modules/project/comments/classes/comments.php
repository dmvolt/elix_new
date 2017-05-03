<?php

defined('SYSPATH') or die('No direct script access.');

class Comments {

    public static function get_block($content_id, $module = 'articles') {	
	
		$comment_obj = new Model_Comment();
		$siteinfo_obj = new Model_Siteinfo();

        if ($_POST) {
            $_POST = Arr::map('trim', $_POST);

            $post = Validation::factory($_POST);
            $post->rule('author', 'not_empty')
                    ->rule('author', 'min_length', array(':value', 2))
                    ->rule('author', 'max_length', array(':value', 20))
                    ->rule('message', 'not_empty')
					->rule('message', 'max_length', array(':value', 200))
					->rule('captcha', 'not_empty')
					->rule('captcha', 'max_length', array(':value', 20))
                    ->rule('captcha', array('Comments', 'valid_captcha'));
					
			$post->labels(array(
				'author' => '-Автор-',
				'message' => '-Текст сообщения-',
				'captcha' => '-Капча-',
			));
					
            if ($post->check()) {
			
				if(Data::_('logged')){
					$default_status = 1;
					$user_id = Data::_('user')->id;
				} else {
					$default_status = 0;
					$user_id = 0;
				}
			
				$data = array(
					'content_id' => $content_id,
                    'parent_id' => 0,
                    'module' => $module,
                    'author' => Arr::get($_POST, 'author'),
                    'message' => Arr::get($_POST, 'message'),
                    'date' => date('d/m/Y'),
					'user_id' => $user_id,
					'status' => $default_status,
				);

                $comment_obj->create_comment($data);
				
				$info = $siteinfo_obj->get_siteinfo(1);

				//Отправка эл. почты администратору
				$from = $info['email'];
				$to = $info['email'];
				$subject = FILIAL.' Новый комментарий';
				$message = '<html><body>';
				$message .= 'г. '.FILIAL.'.<br>' . $data['message'] . '<br><br>Дата: ' . $data['date'] . '<br>Автор: ' . $data['author'];
				$message .= '</body></html>';

				$headers = "Content-type: text/html; charset=utf-8 \r\n";
				$headers .= "From: <" . $from . ">\r\n";

				mail($to, $subject, $message, $headers);

                $uri = Request::detect_uri();
                Request::initial()->redirect($uri);
            } else {
                $errors = $post->errors('validation');
            }
        }
		$hidden = array(
			'content_id' => $content_id,
			'module' => $module,
			'captcha_img' => Captcha::instance()->render(),
		);

        $comments = $comment_obj->get_comments($content_id, $module);
        return View::factory(Data::_('template_directory') . 'comments')
                ->bind('comments', $comments)
				->bind('hidden', $hidden)
                ->bind('errors', $errors);
    }
	
	public static function valid_captcha($data) {
		return Captcha::valid($data);
	}	
}
// Comments
