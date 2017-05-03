<h2 class="title"><?= $text_market_orders ?></h2>
<form action="" method="get" id="form_filter" style="float:left;">
    <div class="form_item">
        <label for="order_status"><?= $text_market_thead_order_status ?></label></br>
        <select name="order_status">
			<option value="0">--<?= $text_all ?>--</option>
			<?php foreach ($order['status'] as $id => $item): ?>
				<?php if (Arr::get($_GET, 'order_status', 0) == $id): ?>
					<option value="<?= $id ?>" selected="selected"><?= $item['name'] ?></option>
				<?php else: ?>
					<option value="<?= $id ?>"><?= $item['name'] ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
    </div>
	<div class="form_item">
		<label for="order_id"><?= $text_market_thead_order_id ?></label><br>
		<input type="text" name="order_id" class="short" value="<?= Arr::get($_GET, 'order_id', '') ?>">
	</div>	
	<!--<div class="form_item">
		<label for="order_phone">Телефон<?//= $text_market_thead_order_email ?></label><br>
		<input type="text" name="order_phone" class="text" value="<?//= Arr::get($_GET, 'order_phone', '') ?>">
	</div>-->
    <div class="form_item" style="top:32px">
        <a onclick="$('#form_filter').submit();" class="btn_core btn_core_blue btn_core_md"><span><?= $text_save ?></span></a>
    </div>
</form>

<div class="clear"></div>
<?php if (isset($all_orders) AND count($all_orders) > 0): ?>
<div>
	<form method="post" id="weight_form">
    <table class="order_list">
        <thead>
            <tr>
				<th><strong><?= $text_market_thead_order_id ?></strong></th>
				<th><strong><?= $text_market_thead_order_date ?></strong></th>
				<th><strong>Время заказа<?//= $text_market_thead_order_date ?></strong></th>
				<th><strong><?= $text_market_thead_order_customer ?></strong></th>
				<th><strong>Телефон<?//= $text_market_thead_order_email ?></strong></th>
				<th><strong><?= $text_market_thead_order_status ?></strong><br></th>
				<th><strong>Доставка</strong></th>
				<th class="last"><strong><?= $text_articles_thead_action ?></strong></th>
			</tr>
			</thead>
            <tbody>
			<?php foreach ($all_orders as $key => $value): ?>
				<tr>
					<td><?= $value['id'] ?></td>
					<td><?= $value['order_date'] ?></td>
					<td><?= $value['order_time'] ?></td>
					<td><?= $value['name'] ?></td>
					<td><?= $value['phone'] ?></td>
					<td>
						<?php if (isset($order['status'])): ?>
							<?php foreach ($order['status'] as $id => $item): ?>
								<?php if ($value['order_status'] == $id): ?>
									<?= $item['image'] ?><span> <?= $item['name'] ?></span>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if (isset($order['shipping'][$value['order_shipping']])): ?>
							<span><?= $order['shipping'][$value['order_shipping']]['name'] ?></span>                                 
						<?php endif; ?>
					</td>
					<td class="last"><a href="/admin/orders/edit/<?= $value['id'] ?>" class="edit"><?= $text_edit ?></a>&nbsp;&nbsp;<a href="/admin/orders/delete/<?= $value['id'] ?>" class="delete"><?= $text_delete_img ?></a></td>
				</tr>
		<?php endforeach; ?>
		</tbody>		
	</table>
	<input type="hidden" name="module" value="orders" />
    </form>
</div>
<?php else: ?>
	<h2 class="title"><?= $text_market_orders_none ?></h2>
<?php endif; ?> 