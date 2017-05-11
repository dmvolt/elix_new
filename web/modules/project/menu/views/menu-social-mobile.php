<?php if (count($menu) > 0): ?>
	<?php foreach ($menu as $key => $item): ?>
		<?php if ($key): ?>&nbsp;&nbsp;&nbsp;<?php endif; ?><a href="<?= $item['url'] ?>"><img src="<?= PARENT_FULLURL ?>/images/<?= $item['descriptions'][Data::_('lang_id')]['title'] ?>.svg" alt="" class="icon icon--big js-svg"></a>
	<?php endforeach; ?>
<?php endif; ?>