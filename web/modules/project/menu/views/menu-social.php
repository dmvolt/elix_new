<?php if (count($menu) > 0): ?>
	<?php foreach ($menu as $item): ?>
		<a href="<?= $item['url'] ?>"><img src="<?= PARENT_FULLURL ?>/images/<?= $item['descriptions'][Data::_('lang_id')]['title'] ?>.svg" alt="" class="icon icon--big js-svg"></a>
	<?php endforeach; ?>
<?php endif; ?>