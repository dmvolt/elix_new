<?php if (count($menu) > 0): ?>
	<?php foreach ($menu as $item): ?>
		<a href="<?= $item['url'] ?>" target="_blank" class="header__soc">
			<object data="<?= PARENT_FULLURL ?>/images/<?= $item['descriptions'][Data::_('lang_id')]['title'] ?>.svg" type="image/svg+xml" class="js-svg"></object>
		</a>
	<?php endforeach; ?>
<?php endif; ?>