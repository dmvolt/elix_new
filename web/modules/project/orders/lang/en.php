<?php defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_market_private'=>' ... welcome.',
    'text_market_private_empty'=>'No data.',
    'text_market_private_customerinfo'=>'Personal',
	'text_market_private_customerinfo_desc'=>'The following addresses will be used on the checkout page by default.',
    'text_market_private_customerinfo_edit'=>'Edit',
	'text_market_private_password_view'=>'View password',
    'text_market_private_password_edit'=>'Change password',
	'text_market_private_password_old'=>'Old password',
	'text_market_private_password_new'=>'New password',
	'text_market_private_password_confirm'=>'Confirm password',
    'text_market_private_customerinfo_save'=>'Save',
    'text_market_orders'=>'History',
    'text_market_orders_none'=>'No history',
    'text_market_thead_order_id'=>'Order ID: ',
    'text_market_thead_order_date'=>'Order date',
    'text_market_thead_order_total'=>'Order total',
    'text_market_thead_order_delivery'=>'Delivery',
    'text_market_thead_order_comment'=>'Comment',
	'text_market_thead_order_orderinfo'=>'Order info',
    'text_market_thead_order_customerinfo'=>'Customer info',
    'text_market_thead_order_productinfo'=>'Product info',
    'text_market_thead_order_status'=>'Order status: ',   
);

View::set_global($lang_array);