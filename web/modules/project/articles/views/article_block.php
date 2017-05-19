<?php if($contents): ?>
	<h2><a href="/articles">Статьи</a></h2>
	<div class="flex">
		<?php foreach($contents as $value): ?>
			<div class="flex__item flex__item--33 flex__item--bp-980--50 flex__item--bp-480--100">
				<!-- block topic end -->
				<div class="topic">
					<div class="topic__header"><a href="<?= Data::_('lang_uri') . '/articles/' . $value['alias'] ?>"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a></div>
					<div class="topic__text">
						<?= $value['edit_interface'] ?>
						<div id="articles_content_<?= $value['id'] ?>"><?= $value['descriptions'][Data::_('lang_id')]['teaser'] ?></div>
					</div>
				</div>
				<!-- block topic end -->
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>