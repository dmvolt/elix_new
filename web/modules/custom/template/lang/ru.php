<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
	'text_page_not_found' => 'Извините, здесь пока ничего нет.',
	'text_edit' => 'Редактировать',	
	'text_full_edit' => 'Расширеное редактирование материала',
	'text_save' => 'Сохранить',
	'text_old_browser_warning' => 'Вы используете <strong>устаревший</strong> браузер. Пожалуйста <a href="http://browsehappy.com/">обновите Ваш браузер</a> для корректного отображения страницы.',
);

View::set_global($lang_array);