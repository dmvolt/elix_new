<?php if($current_news): ?>
	<div class="right-col">
		<div class="boxes">
			<?php foreach($current_news as $item): ?>
				<div class="box short">
					<div class="box-content">
						<a class="box-header" href="<?= Data::_('lang_uri') . '/news/' . $item['alias'] ?>"><?= $item['descriptions'][Data::_('lang_id')]['title'] ?></a>
						<div class="date"><?= $item['date'] ?></div>
						<?= $item['descriptions'][Data::_('lang_id')]['teaser'] ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<a href="/news">Все новости</a>
	</div>
<?php endif; ?>