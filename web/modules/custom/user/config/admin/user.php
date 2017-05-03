<?php
defined('SYSPATH') or die('No direct script access');
return array(
    'roles' => array(
        /* 0 => array(
            'id' => 0,
            'name' => 'СуперАдминистратор',
            'description' => 'СуперАдминистратор сайта, имеет полные права на управление сайтом',
            'image' => '<img src="" />',
            'in_front' => '/admin',
            'is_admin' => 1,
            'permission' => '*',
            ), */
        1 => array(
            'id' => 1,
            'name' => 'Администратор',
            'description' => 'Администратор сайта, имеет полные права на управление сайтом',
            'image' => '<img src="" />',
            'in_front' => '/admin/cpages',
            'is_admin' => 1,
            'permission' => '*',
            ),
        /*2 => array(
            'id' => 2,
            'name' => 'Редактор',
            'description' => 'Редактор, имеет право на редактирование содержания сайта',
            'image' => '<img src="" />',
            'in_front' => '/admin/cpages',
            'is_admin' => 1,
            'permission' => 'siteinfo, categories, categories/edit, categories/delete, pages, pages/add, pages/edit, pages/delete, menu, menu/edit, menu/delete',
            ),
        3 => array(
            'id' => 3,
            'name' => 'Покупатель',
            'description' => 'Покупатель, имеет право на доступ в личный кабинет',
            'image' => '<img src="" />',
            'in_front' => '/',
            'is_admin' => 0,
            'permission' => '',
            ),
        4 => array(
            'id' => 4,
            'name' => 'Оператор',
            'description' => 'Работа с заказами',
            'image' => '<img src="" />',
            'in_front' => '/admin/orders',
            'is_admin' => 1,
            'permission' => 'orders, orders/edit, orders/delete',
            ),
        5 => array(
            'id' => 5,
            'name' => 'Менеджер',
            'description' => 'Работа с товарами',
            'image' => '<img src="" />',
            'in_front' => '/admin/products',
            'is_admin' => 1,
            'permission' => 'newsletter, newsletter/add, newsletter/edit, newsletter/delete, products, products/add, products/edit, products/delete, products/addclone, import, export, options, options/edit, options/delete',
            ),*/
    )
);