<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_group_menu' => 'Меню:',
    'text_add_new_menu' => 'Добавить элемент меню',
    'text_parent_menu' => 'Родительский элемент:',
    'text_edit_menu' => 'Редактировать меню',
    'text_menu_url' => 'URL (адрес ссылки):',
    'text_menu_status' => 'Опубликовано:',
    'text_menu_thead_name' => 'Наименование и вложеность',
    'text_menu_thead_alias' => 'URL (адрес ссылки)',
    'text_menu_thead_status' => 'Статус',
    'text_menu_thead_action' => 'Действия',
);

View::set_global($lang_array);