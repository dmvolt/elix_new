<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_market_orders' => 'Заказы',
    'text_market_orders_none' => 'Заказов нет',
    'text_market_thead_order_id' => 'ID заказа: ',
    'text_market_thead_order_date' => 'Дата заказа',
	'text_market_thead_order_customer' => 'Заказчик',
	'text_market_thead_order_email' => 'E-mail',
    'text_market_thead_order_total' => 'Общая сумма заказа',
    'text_market_thead_order_delivery' => 'Необходима доставка',
    'text_market_thead_order_comment' => 'Коментарий',
    'text_market_thead_order_customerinfo' => 'Информация о заказчике',
    'text_market_thead_order_productinfo' => 'Информация о товаре',
    'text_market_thead_order_status' => 'Статус заказа: ',
    
    'text_market_order_save' => 'Сохранить',
    'text_market_order_notice' => 'Уведомить клиента по email:',
    'text_market_checkout_customerinfo' => 'Информация о заказчике',
    'text_market_checkout_name' => 'Имя: ',
    'text_market_checkout_lastname' => 'Фамилия: ',
    'text_market_checkout_tell'=>'Номер телефона для связи :',
    'text_market_checkout_email' => 'E-mail: ',
    'text_market_checkout_comment' => 'Комментарии к заказу: ',
    'text_market_checkout_delivery' => 'Необходима доставка',
    'text_market_checkout_city' => 'Город: ',
    'text_market_checkout_postcode' => 'Почтовый индекс: ',
    'text_market_checkout_address' => 'Адрес: ',
    'text_market_checkout_country'=>'Страна :',
    'text_market_checkout_zone'=>'Область (регион) :',
    'text_market_entry_country' => ' - Выберите страну - ',
    'text_market_entry_zone' => ' - Выберите область (регион) - ',
    'text_market_zone_none' => ' - нет области (региона) - ',
    'text_market_cart_admin' => 'Заказаные товары',
    'text_market_cart_qty_postfix' => 'шт.',
    'text_market_cart_price_postfix' => 'руб.',
    'text_market_cart_total' => 'ИТОГО:',
);

View::set_global($lang_array);