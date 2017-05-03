<h1>Заказ№ <?= $content['id'] ?></h1>
<div class="inline_block margin_right25">
    <h2 class="title">Информация о заказе</h2>
    <div class="private_customerinfo">
        <p><label>Имя покупателя:</label> <?= $content['name'] ?></p>
        <p><label>Телефон покупателя:</label> <?= $content['phone'] ?></p>
    </div>
</div>

<?php if($content['order_shipping'] == 2): ?>
	<div class="inline_block margin_right25">
		<h2 class="title">Адрес доставки товара</h2>
		<div class="private_customerinfo">
			<p><label>Город:</label> <?//= $content['city'] ?></p>
			<p><label>Адрес:</label> ул.<?= $content['street'] ?>, д.<?= $content['house'] ?>, <?php if ($content['housing'] != ''): ?>к.<?= $content['housing'] ?>, <?php endif; ?>кв.(оф.)<?= $content['houseroom'] ?></p>
		</div>
	</div>
<?php endif; ?>

<?php if (isset($order['shipping'][$content['order_shipping']])): ?>
<div class="margin_right25 inline_block">
    <h2 class="title">Способ доставки</h2>
	<span> <?= $order['shipping'][$content['order_shipping']]['name'] ?></span>                            
</div>
<?php endif; ?>

<div class="inline_block margin_right25">
    <h2 class="title">Выбранный способ оплаты</h2>
	<?php if(isset($order['payment'][$content['order_payment']]['name'])):?>
		<span><?= $order['payment'][$content['order_payment']]['name'] ?></span>
	<?php else: ?>
		<span>Выбранный способ оплаты отключен!</span>
	<?php endif; ?>
</div>

<div class="inline_block margin_right25">
    <h2 class="title">Статус заказа</h2>
    <span><?= $order['status'][$content['order_status']]['name'] ?></span>
</div>

<br><br><br><br>

<div class="clear"></div>

<?php if(!empty($content['order_products'])): ?>
	<h2 class="title">Заказаные товары</h2> 
	<table class="order_list">
		<thead>
			<tr>
				<th><strong>Уникальный код товара</strong></th>
				<th><strong>Наименование</strong></th>
				<th><strong>Цена за единицу</strong> (руб.)</th>
				<th><strong>Количество</strong></th>
				<th class="last"><strong>Общая стоимость позиции</strong> (руб.)</th>
			</tr>
		</thead>
		<?php foreach ($content['order_products'] as $value): ?>
			<tr>
				<td class="first"><?= $value['product_code'] ?><br></td>
				<td><?= $value['product_title'] ?></td>
				<td><?= $value['product_price'] ?></td>
				<td><?= $value['product_qty'] ?></td>
				<td class="last"><?= $value['product_total']; ?></td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<td class="last" colspan="4"><b>ИТОГО:</b></td>
			<td class="last"><b><?= $content['order_total'] ?> руб.</b></td>
		</tr>
	</table>
<?php endif; ?>