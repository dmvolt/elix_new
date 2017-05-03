<?php

defined('SYSPATH') or die('No direct script access');

return array(
    'status' => array(
        1 => array(
            'name' => 'Отменен',
            'description' => 'Резерв обнуляется. 
                            Количество заказанного товара возвращается в доступное количество.',
            'image' => '<img src="/images/admin/back.png" />',
            'reserved_action' => '-', /* "-" Условное действие по убавлению, в данном случае количества товара на резерве */
            'quantity_action' => '+'), /* "+" Условное действие по добавлению, в данном случае количества доступного товара */

        2 => array(
            'name' => 'Принят',
            'description' => 'Товар заказан но не оплачен. 
                            Количество заказанного товара поступает в резерв, 
                            колличество доступного товара уменьшается на количество зарезервированного.',
            'image' => '<img src="/images/admin/favorite.png" />',
            'reserved_action' => '+',
            'quantity_action' => '-'),
		7 => array(
            'name' => 'Выставлен счет',
            'description' => 'Выставляется счет для юридических лиц.',
            'image' => '<img src="/images/admin/note_accept.png" />',
            'reserved_action' => '',
            'quantity_action' => '-'),
        3 => array(
            'name' => 'Оплачен',
            'description' => 'Товар заказан и оплачен через встроенный онлайн сервис. 
                            Количество доступного товара уменьшается на количество заказанного.',
            'image' => '<img src="/images/admin/credit_cart.png" />',
            'reserved_action' => '',
            'quantity_action' => '-'),
        4 => array(
            'name' => 'Готов к отгрузке',
            'description' => 'Товар отправлен по почте.',
            'image' => '<img src="/images/admin/truck.png" />',
            'reserved_action' => '',
            'quantity_action' => ''),
        5 => array(
            'name' => 'Отгружен',
            'description' => 'Товар оплачен и доставлен покупателю. Если товар находился на резерве, резерв обнуляется.',
            'image' => '<img src="/images/admin/ok.png" />',
            'reserved_action' => '-',
            'quantity_action' => ''),
        6 => array(
            'name' => 'Некорректный',
            'description' => 'Товар не доставлен по причине независящей от продавца. 
                            Товар может быть оплаченным или не оплаченным. 
                            Если товар находится на резерве, он там и остается до смены статуса на какой то определенный (Завершен или Отменен).',
            'image' => '<img src="/images/admin/office_folders.png" />',
            'reserved_action' => '',
            'quantity_action' => '')
    ),
    'shipping' => array(
        1 => array(
            'name' => 'Самовывоз',
            'description' => '',
            'image' => '',
			'onclick' => 'onclick="$(\'#is_delivery\').hide(500);"'),
        2 => array(
            'name' => 'Доставка',
            'description' => 'Доставка осуществляется курьерской службой.',
            'image' => '',
			'onclick' => 'onclick="$(\'#is_delivery\').show(500);"'),
		/* 3 => array(
            'name' => 'Доставка в другой город',
            'description' => 'Доставка осуществляется почтовой службой. Согласуется дополнительно с менеджером.',
            'image' => '',
			'onclick' => 'onclick="$(\'#is_delivery\').show(500);"'), */
    ),
    'payment' => array(
        1 => array(
            'name' => 'Наличными при получении',
            'description' => 'Оплата производится при по факту доставки товара курьером или при самовывозе товара со склада.',
			'code' => '',
            'image' => '/images/payment_icon_03.png'),
		/* 2 => array(
            'name' => 'Банковская карта',
            'description' => 'Оплата через банковскую карту.',
            'code' => 'AC',
            'image' => '/images/payment_icon_06.png'),
		3 => array(
            'name' => 'Яндекс Деньги',
            'description' => 'Оплата через Яндекс деньги.',
            'code' => 'PC',
            'image' => '/images/payment_icon_08.png'), */
		/* 4 => array(
            'name' => 'WebMoney',
            'description' => 'Оплата через WebMoney.',
            'code' => 'WM',
            'image' => '/images/payment_icon_10.png'), */
		/* 5 => array(
            'name' => 'SMS или Сбербанк Онлайн',
            'description' => 'Оплата через Сбербанк.',
            'code' => 'SB',
            'image' => '/images/payment_icon_12.png'),
		6 => array(
            'name' => 'Альфа-клик',
            'description' => 'Оплата через Альфа-банк.',
            'code' => 'AB',
            'image' => '/images/payment_icon_14.png'),
		7 => array(
            'name' => 'Кассы и терминалы',
            'description' => 'Оплата наличными через кассы и терминалы',
            'code' => 'GP',
            'image' => '/images/payment_icon_16.png'), */
    )
);