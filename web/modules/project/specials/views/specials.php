<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">

		<!-- block breadcrumbs start -->
		<?= Breadcrumbs::get_breadcrumbs(0, 'specials', false, $current_param_cat) ?>
		<!-- block breadcrumbs end -->

		<h1><?= $page_title ?></h1>
		
		<div class="flex">
			<?php  if($specials): ?>
					
				<?php foreach($specials as $article): ?>
					<div class="flex__item flex__item--33 flex__item--bp-980--50">
						<!-- block person start -->
						<div class="photo">
							<a href="<?= Data::_('lang_uri').$cat_url.'/doctors/' . $article['alias'] ?>" class="photo__figure">
								<?php if($article['thumb']): ?>
									<img src="<?= Im::imagepath('250x200', $article['thumb']) ?>">
								<?php endif; ?>
							</a>
							<div class="photo__name"><?= $article['descriptions'][Data::_('lang_id')]['title'] ?></div>
							<div class="photo__info text-small"><?= $article['descriptions'][Data::_('lang_id')]['teaser'] ?></div>
						</div>
						<!-- block person end -->
					</div>
				<?php endforeach; ?> 
				
				<?= Infoblock::get_page_block(Request::detect_uri()) ?>
					
			<?php else: ?>
				<article>	
					<h2><?= $text_page_not_found ?></h2>
				</article>	   
			<?php endif; ?>
		</div>

		<?= Articles::get_block($current_param_cat, 9) ?>
	</div>

	<aside class="flex__item flex__item--33 flex__item--bp-720--100 main__right">
		<!-- block widgets start -->
		<div class="info info--widgets pos-sticky">
			<?= Banners::get_right_block2($current_param_cat, 5) ?>
		</div>
		<!-- block widgets end -->
		<!-- VK Widget --> 
		<?//= Text::vk_widget() ?>
	</aside>
</div>