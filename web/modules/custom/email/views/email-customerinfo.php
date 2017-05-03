<h2><?=$text_market_checkout_customerinfo ?></h2>
<span>Имя: </span><?=$customerinfo['name'] ?><br>
<span>Фамилия: </span><?=$customerinfo['lastname'] ?><br>
<span>Телефон: </span><?=$customerinfo['tell'] ?><br>
<span>E-mail: </span><?=$customerinfo['email'] ?><br>
<span>Комментарии к заказу: </span>
	
<?php if ($customerinfo['checkout_comment'] != ''): ?>
	<br><?=$customerinfo['checkout_comment'] ?><br><br>
<?php else: ?>
	Нет<br><br>
<?php endif; ?>
        
<?php $order = Kohana::$config->load('admin/order'); ?>
<?php if (isset($order['shipping']) AND count($order['shipping'])>0): ?>
    <span>Способ доставки: <strong><?=$order['shipping'][$customerinfo['delivery']]['name'] ?></strong></span><br><br>
<?php endif; ?>

<?php if ($customerinfo['delivery']!=1): ?>
    <span><strong><?=$text_market_checkout_delivery ?></strong></span><br><br>
    <span><?=$text_market_checkout_country ?>: </span><?=$customerinfo['country'] ?><br><br>
    <span><?=$text_market_checkout_zone ?>: </span><?=$customerinfo['zone'] ?><br><br>
    <span><?=$text_market_checkout_city ?>: </span><?=$customerinfo['city'] ?><br>
    <span><?=$text_market_checkout_postcode ?>: </span><?=$customerinfo['postcode'] ?><br>
    <span><?=$text_market_checkout_address ?>: </span><?=$customerinfo['address'] ?><br><br>
<?php endif; ?>

<?php if (isset($order['payment']) AND count($order['payment'])>0): ?>
    <span>Способ оплаты: <strong><?=$order['payment'][$customerinfo['payment']]['name'] ?></strong></span>
<?php endif; ?>