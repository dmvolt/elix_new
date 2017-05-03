<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_actions' => 'Акции',
	'text_cat_actions' => 'Регион',
    'text_add_new_actions' => 'Добавить акцию',
    'text_actions_status' => 'Опубликовано',
	'text_actions_in_front' => 'На главную',
	'text_actions_video' => 'Видео',
	'text_actions_area' => 'Вставьте в эту область код видеоролика',
    'text_actions_thead_name' => 'Наименование',
    'text_actions_thead_alias' => 'Путь (синоним)',
    'text_actions_thead_status' => 'Статус',
    'text_actions_thead_action' => 'Действия',
);

View::set_global($lang_array);