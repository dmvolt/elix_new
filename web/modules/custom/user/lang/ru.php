<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
	'text_entry_captcha' => 'Пожалуйста, введите комбинацию букв и цифр с картинки',
	'text_login_field' => 'Ваш логин...',
	'text_login' => 'Войти',
	'text_password_field' => 'Ваш пароль...',
	'text_reg' => 'Регистрация',
	'text_pass_recovery' => 'Забыли пароль?',
	'text_logout' => 'Выйти',
	'text_login_welcome' => 'Вы вошли как ',
);

View::set_global($lang_array);