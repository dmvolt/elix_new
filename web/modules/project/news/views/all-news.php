<div class="wide clearfix">
	<?php if($all_news): ?>
	<?= Breadcrumbs::get_breadcrumbs(0, 'news') ?>
	<?php  if($modulinfo AND !empty($modulinfo)): ?>
		<article>
			<?= $modulinfo[0]['descriptions'][Data::_('lang_id')]['body'] ?>
		</article>
	<?php endif; ?>
	<div class="boxes">
		<?php foreach($all_news as $item): ?>
			<div class="box short">
				<div class="box-content">
					<a class="box-header" href="<?= Data::_('lang_uri') . '/news/' . $item['alias'] ?>"><?= $item['descriptions'][Data::_('lang_id')]['title'] ?></a>
					<div class="date"><?= $item['date'] ?></div>
					<?= $item['descriptions'][Data::_('lang_id')]['teaser'] ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php else: ?>
		<div class="h1"><?= $text_page_not_found ?></div>
	<?php endif; ?>
</div>