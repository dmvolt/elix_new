<?php if($current_actions): ?>
	<div class="right-col">
		<div class="boxes">
			<?php foreach($current_actions as $item): ?>
				<div class="box short">
					<div class="box-content">
						<a class="box-header" href="<?= Data::_('lang_uri') . '/actions/' . $item['alias'] ?>"><?= $item['descriptions'][Data::_('lang_id')]['title'] ?></a>
						<!--<div class="date"><?//= $item['date'] ?></div>-->
						<?php if($item['images']): ?>
							<a href="<?= Data::_('lang_uri') . '/actions/' . $item['alias'] ?>" class="auto-link"><img src="<?= PARENT_FULLURL ?>/files/preview2/<?= $item['thumb'] ?>" alt="<?= $item['images'][0]['description'][Data::_('lang_id')]['link'] ?>" title="<?= $item['images'][0]['description'][Data::_('lang_id')]['title'] ?>"></a>
						<?php endif; ?>
						<?= $item['descriptions'][Data::_('lang_id')]['teaser'] ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<a href="/actions">Все акции</a>
	</div>
<?php endif; ?>