<?php if (count($menu) > 0): ?>
	<?php foreach ($menu as $key => $item): ?>
		<?php if ($key): ?>
			<object data="<?= PARENT_FULLURL ?>/images/logo-c.svg" type="image/svg+xml" class="js-svg"></object>
		<?php endif; ?>
		<a href="<?= $item['url'] ?>" class="<?php if ($current_param_cat == $item['cat']): ?>active<?php endif; ?>"><?= $item['descriptions'][Data::_('lang_id')]['title'] ?></a>
	<?php endforeach; ?>
<?php endif; ?>