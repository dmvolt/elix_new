<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_articles' => 'Статьи',
    'text_cat_articles' => 'Категории статей',
    'text_add_new_articles' => 'Добавить статью',
    'text_articles_date' => 'Дата публикации:',
    'text_articles_author' => 'Автор:',
    'text_articles_status' => 'Опубликовано:',
    'text_articles_thead_name' => 'Наименование страницы',
    'text_articles_thead_alias' => 'Путь (синоним)',
    'text_articles_thead_status' => 'Статус страницы',
    'text_articles_thead_action' => 'Действия',
);

View::set_global($lang_array);