<div class="woo" id="transparent-form">
	<form id="sert_form" method="post">
		<h3>Купить сертификат</h3>
		<p>(с вами свяжется наш специалист в течение 15 минут)</p>
		<img src="/images/admin/loading.gif" width="32" height="32" id="sert_loading" style="display:none;" alt="*" />
		<div id="sert_thanks"></div>
		<input type="text" id="sert_name" name="sert_name" value="" placeholder="ФИО">
		<input type="text" id="sert_email" name="sert_email" value="" placeholder="e-mail">
		<input type="text" id="sert_tell" name="sert_tell" value="" placeholder="Телефон">
		<?php if($payment_methods AND count($payment_methods)>1): ?>
			<p>Способ оплаты:
			<?php foreach($payment_methods as $pay_id => $value): ?>
				<br><input type="radio" name="sert_payment" id="pay1-<?= $pay_id ?>" <?php if($pay_id == 1): ?>checked<?php endif; ?> value="<?= $pay_id ?>"><label for="pay1-<?= $pay_id ?>"> <?= $value['name'] ?></label> 
			<?php endforeach; ?>
			</p>
		<?php endif; ?>
		<input type="text" id="sert_address" name="sert_address" value="" placeholder="Адрес">
		<p></p>
		<textarea id="sert_address2" name="sert_address2" placeholder="Комментарий"></textarea>
		<!-- <p>При покупке сертификата онлайн доставка осуществляется курьером по указанному в форме адресу. Наш специалист свяжется с вами в течение 15 минут для уточнения деталей заказа.</p> -->
		<input type="hidden" id="sert_code" name="sert_code" value="">
		<input type="hidden" id="sert_price" name="sert_price" value="">
		<input type="button" id="sert_submit" value="Купить сертификат">
	</form>
</div>
