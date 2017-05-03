<div class="narrow clearfix">
	<?php if($news): ?>
		<?= Breadcrumbs::get_breadcrumbs($news['id'], 'news') ?>
		<?= News::current_block($news['id']) ?>
		<h1><?=$news['descriptions'][Data::_('lang_id')]['title'] ?></h1>
		<?= $edit_interface ?>
		<article>
			<?=$news['descriptions'][Data::_('lang_id')]['body'] ?>
		</article>
	<?php else: ?>
		<div class="h1"><?= $text_page_not_found ?></div>
	<?php endif; ?>
</div>