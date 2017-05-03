<?php if ($related AND count($related) > 0): ?>
    <div class="connected">
		<h2>Статьи по теме:</h2>
		<?php foreach ($related as $item): ?>
			<a href="<?= Data::_('lang_uri') ?>/articles/<?= $item['alias'] ?>">
				<?php if ($item['thumb']): ?>
					<img src="/files/preview/<?= $item['thumb'] ?>" alt="<?= $item['descriptions'][Data::_('lang_id')]['title'] ?>">
				<?php endif; ?>
				<?= $item['descriptions'][Data::_('lang_id')]['title'] ?>
			</a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
