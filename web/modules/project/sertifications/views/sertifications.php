<main class="main main_col">
	<section class="main_col__wide">
		<?= Breadcrumbs::get_breadcrumbs(0, 'sertifications', false, $current_param_cat) ?>
	</section>
	<aside class="main_col__right main_col__right_1200">
		<form class="form" id="sert_form" method="post">
			<h2 class="form__header">Закажите сертификат</h2>
			<p>(с вами свяжется наш специалист в течение 15 минут)</p>
			<div class="form__group">
				<label for="sert_name">Ваше имя</label>
				<input id="sert_name" type="text" name="sert_name" placeholder="Ваше имя"/>
			</div>
			<div class="form__group">
				<label for="sert_email">E-mail</label>
				<input id="sert_email" type="email" name="sert_email" placeholder="E-mail"/>
			</div>
			<div class="form__group">
				<label for="sert_phone">Телефон</label>
				<input id="sert_phone" type="text" name="sert_phone" placeholder="Телефон"/>
			</div>
			<div class="form__group">
				<label for="sert_code">Выберите подарочный сертификат</label>
				<select id="sert_code" name="sert_code">
					<option value=""> - Выберите сертификат - </option>
					<?php if($sertifications): ?>
						<?php foreach($sertifications as $article): ?>
							<option value="<?= $article['code'] ?>"><?= $article['descriptions'][Data::_('lang_id')]['title'] ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>
			
			<div class="form__group">
				<label for="sert_address">Адрес</label>
				<input id="sert_address" type="text" name="sert_address" placeholder="Адрес"/>
			</div>
			
			<?php if($payment_methods AND count($payment_methods)>1): ?>
				<label for="sert_payment">Способ оплаты:
				<?php foreach($payment_methods as $pay_id => $value): ?>
					<br><input type="radio" name="sert_payment" id="pay1-<?= $pay_id ?>" <?php if($pay_id == 1): ?>checked<?php endif; ?> value="<?= $pay_id ?>"><label for="pay1-<?= $pay_id ?>"> <?= $value['name'] ?></label> 
				<?php endforeach; ?>
				</label>
			<?php endif; ?>
			
			<div class="form__group">
				<label for="sert_address2">Комментарий</label>
				<textarea id="sert_address2" name="sert_address2" placeholder="Комментарий"></textarea>
			</div>
			<div class="form__group form__group_submit">
				<button type="submit">Заказать сертификат <img src="<?= PARENT_FULLURL ?>/images/admin/loader.gif" width="32" height="32" class="loading" style="display:none;"></button>
			</div>
			<div id="sert_form_thanks"></div>
		</form>
	</aside>
	<section class="main_col__wide">
		<?php if($sertifications): ?>
			<?php foreach($sertifications as $article): ?>
				<a href="<?= Im::imagepath('colorbox', $article['thumb']) ?>" class="img-popup img-gal img-gal_big">
					<img src="<?= Im::imagepath('preview3', $article['thumb']) ?>" alt=""> <!-- 400 X 300 -->
				</a>
			<?php endforeach; ?>
		<?php else: ?>
			<h2><?= $text_page_not_found ?></h2>
		<?php endif; ?>
		<?= Infoblock::get_page_block(Request::detect_uri()) ?>
	</section>
</main>