<aside class="right-column clearfix">
	<?= Infoblock::infoblock_block(50) ?>
	<div class="right-bottom-collumn clearfix">
		<?= Reviews::get_block() ?>
		<a href="/ruller" class="ruller"></a>
	</div>
</aside>

<div class="center-column clearfix">
	<?= Breadcrumbs::get_breadcrumbs($article['id'], 'reviews') ?>
	<?php if($article): ?>
		<article>
			<?= $edit_interface ?>
			<div id="reviews_body_<?= $article['id'] ?>"><?=$article['descriptions'][Data::_('lang_id')]['body'] ?></div>
		</article>	
	<?php else: ?>	
		<h1><?= $text_page_not_found ?></h1>
	<?php endif; ?>
</div>

<aside class="left-column clearfix">
	<section class="blog clearfix">
		<?= Articles::articles_block() ?>
	</section>
	<section class="vacancy">
		<?= Specials::specials_block() ?>
	</section>
</aside>