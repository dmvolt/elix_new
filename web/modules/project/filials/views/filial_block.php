<form action="/filials/index" method="get" onchange="$(this).submit();" class="header__form_select">
	<select name="filial" class="header__select">
		<?php foreach($redirect_data as $key => $item): ?>
			<option value="<?= $key ?>" <?php if($filial == $key): ?>selected<?php endif; ?>><?= $item['name'] ?></option>
		<?php endforeach; ?>
	</select>
</form>