<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">

		<!-- block breadcrumbs start -->
		<?= Breadcrumbs::get_breadcrumbs(0, 'sertifications') ?>
		<!-- block breadcrumbs end -->

		<?php if($sertifications): ?>
			<h1><?= $page_title ?></h1>

			<div class="flex">
				<?php foreach($sertifications as $article): ?>
					<div class="flex__item flex__item--33 flex__item--bp-980--50">
						<a href="<?= Im::imagepath('colorbox', $article['thumb']) ?>" class="js-popup-image"><img src="<?= Im::imagepath('400x250', $article['thumb']) ?>" class="img-scale"></a>
					</div>
				<?php endforeach; ?>
			</div>
		
		<?php else: ?>
			<article>	
					<h2><?= $text_page_not_found ?></h2>
			</article>	   
		<?php endif; ?>
	</div>
	
	<aside class="flex__item flex__item--33 flex__item--bp-720--100 main__right">
		<article class="article pos-sticky pl-2e pr-3e">
			<?= Infoblock::get_page_block(Request::detect_uri()) ?>
		</article>
	</aside>
</div>

<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">
		<?= Articles::get_block($current_param_cat, 9) ?>
	</div>

	<aside class="flex__item flex__item--33 flex__item--bp-720--100 main__right">
		<!-- block widgets start -->
		<div class="info info--widgets pos-sticky">
			<?= Banners::get_right_block2($current_param_cat, 5) ?>
		</div>
		<!-- block widgets end -->
	</aside>
</div>