<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_siteinfo' => 'Информационные данные сайта',
    'text_siteinfo_name' => 'Название сайта:',
    'text_siteinfo_email' => 'Основной e-mail сайта',
    'text_siteinfo_slogan' => 'Слоган сайта:',
	'text_siteinfo_licence' => 'Лицензия:',
    'text_siteinfo_address' => 'Адрес:',
    'text_siteinfo_tell' => 'Основной контактный телефон',
    'text_siteinfo_description' => 'Описание сайта:',
    'text_siteinfo_copyright' => 'Копирайт (текущий год подставляется автоматически):',
);

View::set_global($lang_array);