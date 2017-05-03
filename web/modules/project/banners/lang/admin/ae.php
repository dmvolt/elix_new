<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_banners' => 'Баннеры',
    'text_banners_code' => 'Код баннера ( ! только для программистов)',
    'text_add_new_banners' => 'Добавить баннер',
    'text_banners_display_all' => 'Отображается на всех страницах',
    'text_banners_display_pages' => 'Введите адреса страниц через запятую ( например: about,contacts,articles ),</br> на которых должен отображаться этот баннер',
    'text_banners_status' => 'Активный:',
    'text_banners_go_banner_preview' => 'Предпросмотр баннера',
    'text_banners_files' => 'Файлы используемые в баннере',
    'text_banner_thead_img' => 'Мини изображение баннера',
    'text_banner_thead_name' => 'Наименование баннера',
    'text_banner_thead_disp' => 'Отображается на страницах -',
    'text_banner_thead_status' => 'Статус',
    'text_banner_thead_action' => 'Действия',
);

View::set_global($lang_array);