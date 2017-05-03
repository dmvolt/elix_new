<?php defined('SYSPATH') OR die('No direct access allowed.');
return array(

    'products' => array(
	
		'order_id' => 'Номер заказа',
		
		'order_date' => 'Дата заказа',
		
		'order_status' => 'Статус заказа, Способ оплаты или доставки (... от контекста)',
		
		'customer_name' => 'Имя заказчика',
		
		'customer_lastname' => 'Фамилия заказчика',
		
		'customer_info' => 'Личные данные заказчика ( Имя, Фамилия, e-mail и т.д. )',
		
		'address_info' => 'Адрес заказчика ( отображается, если выбран вариант с доставкой )',
		
		'cart_info' => 'Заказанные товары ( в виде таблицы с итоговой стоимостью )',
	),
	
	'user' => array(
	
		'reg_data' => 'Регистрационные данные ( логин и пароль )',
		
		'pwrecovery_link' => 'Ссылка на страницу восстановления пароля',
	),
);