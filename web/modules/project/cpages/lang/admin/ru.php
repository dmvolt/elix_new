<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_cpages' => 'Страницы',
	'text_cat_cpages' => 'Регион',
    'text_add_new_cpages' => 'Добавить страницу',
    'text_cpages_status' => 'Опубликовано',
	'text_cpages_in_front' => 'На главную',
	'text_cpages_video' => 'Видео',
	'text_cpages_area' => 'Вставьте в эту область код видеоролика',
    'text_cpages_thead_name' => 'Наименование',
    'text_cpages_thead_alias' => 'Путь (синоним)',
    'text_cpages_thead_status' => 'Статус',
    'text_cpages_thead_action' => 'Действия',
);

View::set_global($lang_array);