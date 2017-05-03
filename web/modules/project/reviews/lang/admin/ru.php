<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_reviews' => 'Все отзывы',
	'text_cat_reviews' => 'Регион',
	'text_group_reviews' => 'Группа отзывов',
    'text_add_new_reviews' => 'Добавить отзыв',
    'text_reviews_date' => 'Дата отзыва:',
	'text_body_reviews' => 'Содержание отзыва:',
    'text_reviews_status' => 'Опубликовано:',
    'text_reviews_thead_date' => 'Дата',
    'text_reviews_thead_name' => 'Наименование',
    'text_reviews_thead_status' => 'Статус',
    'text_reviews_thead_action' => 'Действия',
);

View::set_global($lang_array);