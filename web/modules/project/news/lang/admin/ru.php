<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_news' => 'Все новости',
	'text_cat_news' => 'Регион',
    'text_add_new_news' => 'Добавить новость',
    'text_news_date' => 'Дата публикации:',
    'text_news_status' => 'Опубликовано:',
    'text_news_thead_date' => 'Дата публикации',
    'text_news_thead_name' => 'Наименование',
    'text_news_thead_alias' => 'Путь (синоним)',
    'text_news_thead_status' => 'Статус',
    'text_news_thead_action' => 'Действия',
);

View::set_global($lang_array);