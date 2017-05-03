<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_infoblock' => 'Инфоблок',
	'text_cat_infoblock' => 'Регион',
    'text_add_new_infoblock' => 'Добавить Инфоблок',
    'text_infoblock_date' => 'Ссылка:',
	'text_infoblock_type' => 'Тип блока ("1" - Блок справа, "2" - Блок слева, "3" - Блок в разделе)',
	'text_infoblock_url' => 'Адрес страницы, где показывается блок',
    'text_infoblock_status' => 'Опубликовано:',
    'text_infoblock_thead_name' => 'Наименование инфоблока',
	'text_infoblock_thead_type' => 'Расположение блока',
    'text_infoblock_thead_status' => 'Статус инфоблока',
    'text_infoblock_thead_action' => 'Действия',
);

View::set_global($lang_array);