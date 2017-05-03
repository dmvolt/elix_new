<?php

defined('SYSPATH') or die('No direct script access');

return array(
	'yandex' => array(
		'shop_id' => '104516',
		'scid' => '38194',
		'service_url' => 'https://money.yandex.ru/eshop.xml',
		'quickpay-form' => 'shop', // shop — для универсальной формы-принимателя, donate — для «благотворительной» формы, small — для кнопки.
		'default-paymentType' => 'PC', // PC – оплата со счета Яндекс.Денег, AC – оплата с банковской карты
		'success_url' => 'http://elixepil.ru/payment/success',
		'fail_url' => 'http://elixepil.ru/payment/fail',
    )
);