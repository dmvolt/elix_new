<?php

defined('SYSPATH') or die('No direct script access');

return array(
    'main_menu' => array(
        0 => array(
            'name' => 'Главная',
            'href' => '/',
            'target' => '')
    ),
    'group_cat' => array(
        1 => array(
            'name' => 'Типы услуг',
            'dictionary_id' => 1),
		2 => array(
            'name' => 'Город',
            'dictionary_id' => 2),
    ),
    'group_menu' => array(
        1 => array(
            'name' => 'Главное меню',
            'dictionary_id' => 1),
        2 => array(
            'name' => 'Главное мобильное меню',
            'dictionary_id' => 2),
		4 => array(
            'name' => 'Меню категорий услуг',
            'dictionary_id' => 4),
		3 => array(
            'name' => 'Социальные сети',
            'dictionary_id' => 3),
        
    )
);