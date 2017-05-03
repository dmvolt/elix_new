<?php if ($menu): ?>
	<?php foreach ($menu as $item): ?>
		<?php if (isset($item['descriptions'][Data::_('lang_id')]['title']) AND !empty($item['descriptions'][Data::_('lang_id')]['title'])): ?>
			<a href="<?= $item['url'] ?>" title="<?= $item['descriptions'][Data::_('lang_id')]['title'] ?>" target="_blank"><img src="/files/icon/<?= $item['icon'] ?>" alt="<?= $item['descriptions'][Data::_('lang_id')]['title'] ?>"></a>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>