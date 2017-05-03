<?php defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_market_private'=>' ... добро пожаловать в личный кабинет.',
    'text_market_private_empty'=>'Нет данных. Вероятно вы ещё ничего не заказывали на нашем сайте.',
    'text_market_private_customerinfo'=>'Личные данные',
	'text_market_private_customerinfo_desc'=>'Следующие адреса будут использоваться на странице оформления заказа по умолчанию.',
    'text_market_private_customerinfo_edit'=>'Редактировать',
	'text_market_private_password_view'=>'Не прятать пароль за звездочки',
	'text_market_private_password_old'=>'Старый пароль',
	'text_market_private_password_new'=>'Новый пароль',
	'text_market_private_password_confirm'=>'Повторите пароль',
    'text_market_private_password_edit'=>'Изменить пароль',
    'text_market_private_customerinfo_save'=>'Сохранить',
    'text_market_orders'=>'История заказов',
    'text_market_orders_none'=>'У вас пока нет заказов',
    'text_market_thead_order_id'=>'ID заказа: ',
    'text_market_thead_order_date'=>'Дата заказа',
    'text_market_thead_order_total'=>'Общая сумма заказа',
    'text_market_thead_order_delivery'=>'Необходима доставка',
    'text_market_thead_order_comment'=>'Коментарий',
	'text_market_thead_order_orderinfo'=>'Информация о заказе',
    'text_market_thead_order_customerinfo'=>'Информация о заказчике',
    'text_market_thead_order_productinfo'=>'Информация о товаре',
    'text_market_thead_order_status'=>'Статус заказа: ',   
);

View::set_global($lang_array);