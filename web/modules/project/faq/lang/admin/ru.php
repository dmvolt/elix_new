<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_faq' => 'Все вопросы(ответы)',
	'text_cat_faq' => 'Регион',
	'text_group_faq' => 'Группа вопросов(ответов)',
    'text_add_new_faq' => 'Добавить вопрос(ответ)',
    'text_faq_date' => 'Дата:',
	'text_body_faq' => 'Содержание:',
    'text_faq_status' => 'Опубликовано:',
    'text_faq_thead_date' => 'Дата',
    'text_faq_thead_name' => 'Наименование',
    'text_faq_thead_status' => 'Статус',
    'text_faq_thead_action' => 'Действия',
);

View::set_global($lang_array);