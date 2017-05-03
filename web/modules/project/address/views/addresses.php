<?= Breadcrumbs::get_breadcrumbs(0, 'partners') ?>
<?php if($partners): ?>
	<?php foreach($partners as $actions): ?>
		<div class="article-short">
			<?php if($actions['thumb']): ?>
				<div class="side-block">
					<img src="/files/preview/<?= $actions['thumb'] ?>" alt="">
				</div>
			<?php endif; ?>
			<h2><a href="<?= Data::_('lang_uri') . '/contacts/' . $actions['alias'] ?>"><?= $actions['descriptions'][Data::_('lang_id')]['title'] ?></a></h2>
			<?= $actions['edit_interface'] ?>
			<div class="map"><?= $actions['map'] ?></div>
			<div class="address"><?= $actions['descriptions'][Data::_('lang_id')]['teaser'] ?></div>
		</div>
	<?php endforeach; ?>
	<?= Infoblock::get_page_block(Request::detect_uri()) ?>
<?php else: ?>
<article>	
	<h2 class="title"><?= $text_page_not_found ?></h2>
</article>	
<?php endif; ?>